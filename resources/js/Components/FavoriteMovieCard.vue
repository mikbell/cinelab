<template>
    <div class="relative flex flex-col bg-white rounded-lg shadow">
        <img
            :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
            alt="Poster del film"
            class="w-full h-auto rounded-t-lg"
        />
        <div class="flex-1 p-4 text-center">
            <h4 class="text-lg font-bold text-gray-800 truncate">
                {{ movie.title }}
            </h4>
            <DangerButton @click="$emit('remove-favorite')">
                Rimuovi dai Preferiti
            </DangerButton>
        </div>
    </div>
</template>

<script setup>
import DangerButton from "./DangerButton.vue";

defineProps({
    movie: {
        type: Object,
        required: true,
    },
});
</script>
