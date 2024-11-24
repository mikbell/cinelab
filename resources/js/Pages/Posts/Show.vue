<template>
    <AppLayout :title="post.title">
        <!-- Header -->
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">
                {{ post.title }}
            </h2>
        </template>

        <Container>
            <!-- Dettagli del post -->
            <div class="p-6 mb-8 bg-white rounded-lg shadow-lg">
                <p class="mb-4 text-sm text-gray-500">
                    Pubblicato {{ formattedDate }} da
                    <span class="font-semibold text-gray-700">
                        {{ post.user.name }}
                    </span>
                </p>
                <article
                    class="prose whitespace-pre-wrap max-w-none prose-gray"
                >
                    {{ post.content }}
                </article>
            </div>

            <!-- Sezione commenti -->
            <div class="mt-12">
                <h2 class="text-2xl font-semibold text-gray-800">
                    Commenti ({{ comments.meta.total }})
                </h2>

                <form
                    @submit.prevent="addComment"
                    class="mt-6"
                    v-if="$page.props.auth.user"
                >
                    <InputLabel class="sr-only" value="Commento" />
                    <TextArea
                        v-model="commentForm.content"
                        class="block w-full"
                        placeholder="Scrivi un commento..."
                        rows="3"
                    ></TextArea>
                    <InputError
                        class="mt-2"
                        :message="commentForm.errors.content"
                    />

                    <PrimaryButton
                        type="submit"
                        :disabled="commentForm.processing"
                        class="mt-4"
                        >Invia</PrimaryButton
                    >
                </form>

                <!-- Lista dei commenti -->
                <div
                    v-if="comments.data.length"
                    class="mt-6 space-y-4 divide-y divide-gray-200"
                >
                    <Comment
                        @delete="deleteComment"
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
                    :meta="comments.meta"
                    :only="['comments']"
                    class="mt-6"
                />
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import { useForm, router } from "@inertiajs/vue3";
import { computed } from "vue";
import { relativeDate } from "@/Utilities/date";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import Comment from "@/Components/Comment.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";

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

const addComment = () => {
    commentForm.post(route("posts.comments.store", props.post.id), {
        preserveScroll: true,
        onSuccess: () => commentForm.reset(),
    });
};

const deleteComment = (commentId) =>
    router.delete(
        route("comments.destroy", {
            comment: commentId,
            page: props.comments.meta.current_page,
        }),
        {
            preserveScroll: true,
        }
    );
</script>
