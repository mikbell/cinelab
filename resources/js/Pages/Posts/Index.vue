<template>
    <AppLayout>
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                Posts
            </h2>
        </template>

        <div class="mx-auto space-y-2 max-w-7xl sm:px-6 lg:px-8">
            <Link :href="route('posts.show', post)" v-for="post in posts" class="block px-4 py-2 text-lg">
                {{ post.title }}
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
