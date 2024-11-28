<template>
    <AppLayout title="Posts">
        <!-- Header -->
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">Posts</h2>
        </template>

        <!-- Lista dei post -->
        <Container>
            <div class="mb-6" v-if="$page.props.auth.user">
                <PrimaryButton
                    as="link"
                    :href="route('posts.create')"
                    class="px-4 py-2 text-white bg-blue-500 rounded"
                >
                    Crea Post
                </PrimaryButton>
            </div>

            <ul class="space-y-6">
                <li
                    v-for="post in posts.data"
                    :key="post.id"
                    class="flex flex-col items-baseline justify-between p-6 transition-shadow duration-200 bg-white rounded-lg shadow-md md:flex-row group hover:shadow-lg"
                >
                    <Link :href="post.routes.show">
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

                    <Link href="/" class="px-2 py-0.5 text-sm text-blue-400 transition duration-150 ease-in-out border border-blue-400 rounded-full hover:bg-blue-400 hover:text-white">{{ post.topic.name }} </Link>
                </li>
            </ul>
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
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    posts: Object, // Aggiornato da Array a Object per includere `meta` e `data`
});

const formattedDate = (post) => relativeDate(post.created_at);
</script>
