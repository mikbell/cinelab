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
            <p class="mt-1 text-sm text-gray-500">
                {{ formatDate(movie.release_date) }}
            </p>
        </div>
        <span
            class="absolute flex items-center gap-1 px-2 py-1 text-xs font-semibold text-white bg-yellow-500 rounded-lg shadow top-2 right-2"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 24 24"
                fill="currentColor"
                stroke="currentColor"
                stroke-width="2"
                stroke-linecap="round"
                stroke-linejoin="round"
                class="w-4 h-4"
            >
                <path
                    d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"
                />
            </svg>
            {{ movie.vote_average.toFixed(1) }}
        </span>
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

// Funzione per formattare la data
const formatDate = (dateString) => {
    if (!dateString) return "Data non disponibile";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("it-IT", {
        year: "numeric",
        month: "long",
        day: "numeric",
    }).format(date);
};
</script>
