<template>
    <AppLayout :title="post.title">
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                {{ post.title }}
            </h2>
        </template>

        <div class="mx-auto max-w-7xl">
            <p>{{ post.content }}</p>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

defineProps({
    post: Object,
});
</script>
