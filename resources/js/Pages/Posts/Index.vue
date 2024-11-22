<template>
    <AppLayout title="Posts">
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                Posts
            </h2>
        </template>

        <div class="mx-auto space-y-2 max-w-7xl sm:px-6 lg:px-8">
            <Link :href="route('posts.show', post)" v-for="post in posts" class="block px-4 text-lg group">
                <h2 class="text-xl font-semibold text-gray-800 transition duration-150 eas-in-out group-hover:text-blue-600">{{ post.title }}</h2>
            </Link>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    posts: Array,
});
</script>
