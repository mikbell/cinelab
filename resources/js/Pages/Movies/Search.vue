<template>
    <AppLayout title="Search">
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                Cerca Film
            </h2>
        </template>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Campo di ricerca -->
            <div class="flex p-6 mb-6 bg-white rounded-lg shadow">
                <input
                    v-model="query"
                    @keyup.enter="searchMovies"
                    type="text"
                    placeholder="Inserisci il nome del film..."
                    class="w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                />
                <PrimaryButton @click="searchMovies"> Cerca </PrimaryButton>
            </div>

            <!-- Risultati della ricerca -->
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
            <div v-else class="mt-8 text-center">
                <p class="text-lg text-gray-600">
                    Nessun film trovato. Prova con un'altra parola chiave.
                </p>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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
