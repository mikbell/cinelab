<template>
    <AppLayout :title="post.title">
        <!-- Header -->
        <template #header>
            <h2 class="py-6 text-3xl font-bold text-center text-gray-900">
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

                <!-- Lista dei commenti -->
                <div
                    v-if="comments.data.length"
                    class="mt-6 space-y-4 divide-y divide-gray-200"
                >
                    <Comment
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
                <Pagination :meta="comments.meta" class="mt-6" />
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { computed } from "vue";
import Container from "@/Components/Container.vue";
import Pagination from "@/Components/Pagination.vue";
import { relativeDate } from "@/Utilities/date";
import Comment from "@/Components/Comment.vue";

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
</script>
