<template>
    <AppLayout title="Movies">
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                TMDb API - Index
            </h2>
        </template>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="flex justify-end mb-4">
                <PrimaryButton as="link" :href="route('movies.search')"
                    >Search</PrimaryButton
                >
            </div>
            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <!-- Risultati -->
                <div class="p-6">
                    <div
                        v-if="movies.length"
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                    >
                        <Link
                            :href="route('movies.show', movie.id)"
                            v-for="movie in movies"
                            :key="movie.id"
                            class="flex flex-col items-center transition-shadow duration-300 bg-white rounded-lg shadow-md group hover:shadow-lg"
                        >
                            <img
                                :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
                                alt="Movie Poster"
                                class="w-40 h-auto rounded-t-lg"
                            />
                            <div class="w-full p-4 text-center">
                                <h4
                                    class="text-lg font-bold text-gray-800 transition duration-150 group-hover:text-blue-600"
                                >
                                    {{ movie.title }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ movie.release_date }}
                                </p>
                            </div>
                        </Link>
                    </div>
                    <!-- Nessun risultato -->
                    <div v-else class="mt-8 text-center">
                        <p class="text-lg text-gray-600">
                            Nessun film trovato. Prova con un'altra keyword.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    movies: Array, // Film ricevuti dal backend
    totalResults: Number, // Totale dei risultati
    page: Number, // Pagina attuale
});
</script>
