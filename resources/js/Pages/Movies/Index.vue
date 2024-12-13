<template>
    <AppLayout title="Movies">
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">
                TMDb API - Film Popolari
            </h2>
        </template>

        <Container>
            <PageHeading> Film Popolari </PageHeading>

            <!-- Form di ricerca -->
            <MovieSearchForm :query="query" :onSearch="updateMovies" />
            <!-- Dropdown per i generi -->
            <div class="mb-6">
                <select
                    v-model="selectedGenre"
                    @change="applyFilters"
                    class="border-gray-300 rounded-md shadow-sm"
                >
                    <option value="">Tutti i generi</option>
                    <option
                        v-for="genre in genres"
                        :key="genre.id"
                        :value="genre.id"
                    >
                        {{ genre.name }}
                    </option>
                </select>
            </div>

            <!-- Griglia dei film -->
            <div
                v-if="movies.length"
                class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
            >
                <MovieCard
                    v-for="movie in movies"
                    :key="movie.id"
                    :movie="movie"
                    :href="route('movies.show', movie.id)"
                />
            </div>

            <!-- Nessun risultato -->
            <div v-else class="mt-16 text-center">
                <p class="text-lg text-gray-600">Nessun film trovato.</p>
            </div>

            <!-- Bottone "Mostra Altro" -->
            <div class="flex justify-center mt-6">
                <SecondaryButton
                    v-if="currentPage < totalPages && !loading"
                    @click="loadMore"
                >
                    Mostra Altro
                </SecondaryButton>
                <p v-else-if="loading" class="text-sm text-gray-600">
                    Caricamento in corso...
                </p>
                <p v-else class="text-sm text-gray-600">
                    Non ci sono più risultati da mostrare.
                </p>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import MovieCard from "@/Components/MovieCard.vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import MovieSearchForm from "@/Components/MovieSearchForm.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps({
    initialMovies: Array,
    totalResults: Number,
    initialPage: Number,
    genres: Array,
});

const movies = ref([...props.initialMovies]);
const currentPage = ref(props.initialPage);
const totalPages = ref(Math.min(Math.ceil(props.totalResults / 32), 100));
const selectedGenre = ref("");
const query = ref("");
const loading = ref(false);

// Funzione per aggiornare i risultati dei film
const updateMovies = (newMovies, totalResults) => {
    movies.value = newMovies;
    console.log("Totale risultati:", totalResults);
};

// Funzione per caricare i risultati combinati
const applyFilters = async () => {
    loading.value = true;

    try {
        const response = await axios.get(route("movies.index"), {
            params: {
                query: query.value,
                genre: selectedGenre.value, // Aggiunto il parametro "genre"
                page: 1,
            },
        });

        movies.value = response.data.movies;
        currentPage.value = 1;
        totalPages.value = Math.ceil(response.data.total_results / 32);
    } catch (error) {
        console.error("Errore durante l'applicazione dei filtri:", error);
    } finally {
        loading.value = false;
    }
};

// Funzione per caricare più risultati (paginazione)
const loadMore = async () => {
    if (loading.value || currentPage.value >= totalPages.value) return;

    loading.value = true;

    try {
        const response = await axios.get(route("movies.index"), {
            params: {
                genre: selectedGenre.value,
                query: query.value,
                page: currentPage.value + 1,
            },
        });

        if (response.data?.movies) {
            movies.value = [...movies.value, ...response.data.movies];
            currentPage.value += 1;
        }
    } catch (error) {
        console.error("Errore durante il caricamento dei film:", error);
    } finally {
        loading.value = false;
    }
};
</script>
