<template>
    <AppLayout title="Movies">
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">
                TMDb API - Film Popolari
            </h2>
        </template>

        <Container>
            <!-- Bottone di ricerca -->
            <MovieSearchForm />

            <!-- Griglia dei film -->
            <div
                v-if="movies.length"
                class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
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

// Props o dati iniziali
const props = defineProps({
    initialMovies: {
        type: Array,
        default: () => [],
    },
    totalResults: {
        type: Number,
        default: 0,
    },
    initialPage: {
        type: Number,
        default: 1,
    },
});

const movies = ref([...props.initialMovies]);
const currentPage = ref(props.initialPage);
const totalPages = ref(Math.min(Math.ceil(props.totalResults / 32), 100)); // Limita a 100 pagine
const loading = ref(false);

// Funzione per caricare più film
const loadMore = async () => {
    if (loading.value || currentPage.value >= totalPages) return;

    loading.value = true;

    try {
        const response = await axios.get(route("movies.index"), {
            params: { page: currentPage.value + 1 },
            headers: {
                Accept: "application/json", // Assicura che venga restituita una risposta JSON
            },
        });

        if (response.data?.movies) {
            movies.value = [...movies.value, ...response.data.movies];
            currentPage.value += 1;
        } else {
            console.error("Risposta non valida:", response.data);
        }
    } catch (error) {
        console.error("Errore durante la richiesta:", error);
    } finally {
        loading.value = false;
    }
};
</script>
