<template>
    <Head>
        <link rel="canonical" :href="post.routes.show" />
    </Head>

    <AppLayout :title="post.title">
        <!-- Header -->

        <Container>
            <PageHeading> {{ post.title }} </PageHeading>

            <div class="flex justify-between">
                <div class="mb-4">
                    <Pill :href="route('posts.index', post.topic.slug)">
                        {{ post.topic.name }}
                    </Pill>
                </div>

                <PrimaryButton
                    v-if="post.can.update"
                    as="link"
                    :href="post.routes.edit"
                    class="mb-4"
                >
                    Modifica post
                </PrimaryButton>
            </div>

            <div class="flex items-center mt-4 space-x-2">
                <LikeButton
                    :href="route('likes.store', ['post', post.id])"
                    :liked="false"
                    v-if="post.can.like"
                />
                <LikeButton
                    :href="route('likes.destroy', ['post', post.id])"
                    :liked="true"
                    method="delete"
                    v-else
                />
                <span class="font-semibold text-gray-700"
                    >{{ post.likes_count }} like</span
                >
            </div>

            <p class="mb-4 text-sm text-gray-500">
                Pubblicato {{ formattedDate }} da
                <span class="font-semibold text-gray-700">
                    {{ post.user.name }}
                </span>
            </p>
            <article
                class="prose break-all max-w-none prose-gray"
                v-html="post.html"
            ></article>

            <!-- Sezione commenti -->
            <div class="mt-12">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Commenti ({{ comments.meta.total }})
                </h2>

                <form
                    @submit.prevent="
                        commentIdBeingEdited ? updateComment() : addComment()
                    "
                    class="mt-6"
                    v-if="$page.props.auth.user"
                >
                    <InputLabel class="sr-only" value="Commento" />
                    <MarkdownEditor
                        v-model="commentForm.content"
                        class="block w-full"
                        placeholder="Scrivi un commento..."
                        ref="commentInputRef"
                        editorClass="!min-h-[160px]"
                    />
                    <InputError
                        class="mt-2"
                        :message="commentForm.errors.content"
                    />

                    <div class="flex justify-end mt-4 space-x-2">
                        <PrimaryButton
                            type="submit"
                            :disabled="commentForm.processing"
                            v-text="
                                commentIdBeingEdited
                                    ? 'Modifica commento'
                                    : 'Aggiungi commento'
                            "
                        ></PrimaryButton>

                        <SecondaryButton
                            v-if="commentIdBeingEdited"
                            type="button"
                            @click="cancelCommentEdit"
                            v-text="'Annulla'"
                        ></SecondaryButton>
                    </div>
                </form>

                <p v-else class="mt-6 text-sm italic text-gray-500">
                    <Link :href="route('login')" class="text-black hover:underline"
                        >Accedi</Link
                    >
                    per scrivere un commento.
                </p>

                <!-- Lista dei commenti -->
                <div v-if="comments.data.length" class="mt-6 space-y-4">
                    <Comment
                        @delete="deleteComment"
                        @edit="editComment"
                        v-for="comment in comments.data"
                        :key="comment.id"
                        :comment="comment"
                    />
                </div>

                <!-- Nessun commento -->
                <p v-else class="mt-6 text-sm italic text-gray-500">
                    Nessun commento disponibile. Scrivi il primo!
                </p>

                <!-- Paginazione -->
                <Pagination
                    v-if="comments.data.length"
                    :meta="comments.meta"
                    :only="['comments']"
                    class="mt-6"
                />
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import { useForm, router, Head, Link } from "@inertiajs/vue3";
import { computed, ref } from "vue";
import { relativeDate } from "@/Utilities/date";
import { useConfirm } from "@/Utilities/Composables/useConfirm";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import LikeButton from "@/Components/LikeButton.vue";
import Pill from "@/Components/Pill.vue";
import Pagination from "@/Components/Pagination.vue";
import Comment from "@/Components/Comment.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import InputError from "@/Components/InputError.vue";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps({
    post: {
        type: Object,
        required: true,
    },
    comments: {
        type: Object,
        required: true,
    },
});

const formattedDate = computed(() => relativeDate(props.post.created_at));

const commentForm = useForm({
    content: "",
});

const commentInputRef = ref(null);

const commentIdBeingEdited = ref(null);

const commentBeingEdited = computed(() =>
    props.comments.data.find(
        (comment) => comment.id === commentIdBeingEdited.value
    )
);

const editComment = (commentId) => {
    commentIdBeingEdited.value = commentId;
    commentForm.content = commentBeingEdited.value?.content;
    commentInputRef.value.focus();
};

const cancelCommentEdit = () => {
    commentIdBeingEdited.value = null;
    commentForm.reset();
};

const addComment = () => {
    commentForm.post(route("posts.comments.store", props.post.id), {
        preserveScroll: true,
        onSuccess: () => commentForm.reset(),
    });
};

const { confirmation } = useConfirm();

const updateComment = async () => {
    if (!(await confirmation("Vuoi modificare il commento?"))) {
        return;
    }

    commentForm.put(
        route("comments.update", {
            comment: commentIdBeingEdited.value,
            page: props.comments.meta.current_page,
        }),
        {
            preserveScroll: true,
            onSuccess: () => cancelCommentEdit(),
        }
    );
};

const deleteComment = async (commentId) => {
    if (!(await confirmation("Vuoi eliminare il commento?"))) {
        return;
    }

    router.delete(
        route("comments.destroy", {
            comment: commentId,
            page:
                props.comments.data.length > 1
                    ? props.comments.meta.current_page
                    : Math.max(props.comments.meta.current_page - 1, 1),
        }),
        {
            preserveScroll: true,
        }
    );
};
</script>
