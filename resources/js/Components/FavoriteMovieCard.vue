<template>
    <Link
        class="relative flex flex-col transition duration-300 bg-white rounded-lg shadow hover:shadow-lg hover:scale-105"
    >
        <img
            :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
            alt="Poster del film"
            class="w-full h-auto rounded-t-lg"
        />
        <div class="flex-1 p-4 text-center">
            <h4 class="text-lg font-bold text-gray-800 truncate">
                {{ movie.title }}
            </h4>
        </div>
    </Link>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    movie: {
        type: Object,
        required: true,
    },
});
</script>
