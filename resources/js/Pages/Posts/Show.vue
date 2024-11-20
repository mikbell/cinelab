<template>
    <AppLayout :title="post.title">
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
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
