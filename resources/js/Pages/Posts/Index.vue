<template>
    <AppLayout title="Posts">
        <!-- Header -->
        <template #header>
            <h2
                class="text-3xl font-bold text-center text-gray-900"
                v-text="selectedTopic ? selectedTopic.name : 'Tutti i post'"
            ></h2>

            <p
                v-if="selectedTopic"
                class="mt-1 text-sm text-center text-gray-600"
            >
                {{ selectedTopic.description }}
            </p>
        </template>

        <!-- Lista dei post -->
        <Container>
            <menu class="flex pb-4 mb-4 space-x-1 overflow-auto">
                <li>
                    <Pill :href="route('posts.index')" :filled="!selectedTopic"
                        >Tutti i post
                    </Pill>
                </li>

                <li v-for="topic in topics" :key="topic.id">
                    <Pill
                        :href="route('posts.index', topic.slug)"
                        :filled="topic.id === selectedTopic?.id"
                        >{{ topic.name }}
                    </Pill>
                </li>
            </menu>

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

                    <Pill :href="route('posts.index', post.topic.slug)"
                        >{{ post.topic.name }}
                    </Pill>
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
import Pill from "@/Components/Pill.vue";
import { relativeDate } from "@/Utilities/date";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import "remixicon/fonts/remixicon.css";

const props = defineProps({
    posts: Object,
    topics: Object,
    selectedTopic: Object,
});

const formattedDate = (post) => relativeDate(post.created_at);
</script>
