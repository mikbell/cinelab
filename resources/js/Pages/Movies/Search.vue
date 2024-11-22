<template>
    <AppLayout title="Search">
        <template #header>
            <h2 class="py-4 text-3xl font-bold text-center text-gray-900">
                Cerca Film
            </h2>
        </template>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Campo di ricerca -->
            <div class="flex gap-2 p-6 mb-6 bg-white rounded-lg shadow-lg">
                <input
                    v-model="query"
                    @keyup.enter="searchMovies"
                    type="text"
                    placeholder="Inserisci il nome del film..."
                    class="flex-1 p-4 text-lg border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <PrimaryButton @click="searchMovies" :disabled="loading">
                    <span v-if="!loading">Cerca</span>
                    <span v-else>Caricamento...</span>
                </PrimaryButton>
            </div>

            <!-- Risultati della ricerca -->
            <div
                v-if="movies.length"
                class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <MovieCard
                    v-for="movie in movies"
                    :key="movie.id"
                    :movie="movie"
                    :href="route('movies.show', movie.id)"

                />
            </div>
            <div v-else-if="!loading" class="mt-8 text-center">
                <p class="text-lg text-gray-600">
                    Nessun film trovato. Prova con un'altra parola chiave.
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import MovieCard from "@/Components/MovieCard.vue";

const props = defineProps({
    movies: Array,
    query: String,
    totalResults: Number,
    page: Number,
});

const query = ref(props.query);
const movies = ref([...props.movies]);

const searchMovies = () => {
    if (!query.value.trim()) return;

    const url = route("movies.search", { query: query.value });
    window.location.href = url; // Cambia pagina per ricaricare i dati
};
</script>
