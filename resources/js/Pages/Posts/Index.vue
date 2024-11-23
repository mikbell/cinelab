<template>
    <AppLayout title="Posts">
        <!-- Header -->
        <template #header>
            <h2 class="py-6 text-3xl font-bold text-center text-gray-900">
                Posts
            </h2>
        </template>

        <!-- Lista dei post -->
        <Container class="space-y-6">
            <Link
                :href="route('posts.show', post)"
                v-for="post in posts.data"
                :key="post.id"
                class="block p-6 transition-shadow duration-200 bg-white rounded-lg shadow-md group hover:shadow-lg"
            >
                <h2
                    class="text-xl font-bold text-gray-800 transition duration-150 group-hover:text-blue-600"
                >
                    {{ post.title }}
                </h2>
                <p class="mt-2 text-sm text-gray-600">
                    {{ formattedDate(post) }} by
                    <span class="font-semibold text-gray-700">{{
                        post.user.name
                    }}</span>
                </p>
            </Link>
        </Container>

        <!-- Paginazione -->
        <Pagination :meta="posts.meta" class="mt-6" />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import Container from "@/Components/Container.vue";
import { relativeDate } from "@/Utilities/date";

const props = defineProps({
    posts: Object, // Aggiornato da Array a Object per includere `meta` e `data`
});

const formattedDate = (post) => relativeDate(post.created_at);
</script>
