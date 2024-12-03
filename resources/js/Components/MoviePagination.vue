<template>
    <div>
        <!-- Risultati -->
        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <MovieCard
                v-for="movie in movies"
                :key="movie.id"
                :movie="movie"
            />
        </div>

        <!-- Pulsante "Mostra Altro" -->
        <div class="flex justify-center mt-6">
            <PrimaryButton
                v-if="page < totalPages"
                @click="loadMore"
                :disabled="loading"
            >
                {{ loading ? "Caricamento in corso..." : "Mostra Altro" }}
            </PrimaryButton>
            <p v-else class="text-sm text-gray-600">
                Non ci sono più risultati da mostrare.
            </p>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import MovieCard from "@/Components/MovieCard.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

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

const movies = ref([...props.initialMovies]); // Stato locale per i film
const page = ref(props.initialPage); // Pagina corrente
const totalPages = Math.ceil(props.totalResults / 20); // Totale pagine
const loading = ref(false); // Stato di caricamento

const loadMore = async () => {
    if (loading.value || page.value >= totalPages) return;

    loading.value = true;

    try {
        const nextPage = page.value + 1; // Prossima pagina
        const response = await axios.get(route("movies.index"), {
            params: { page: nextPage },
        });

        if (response.data?.movies) {
            movies.value = [...movies.value, ...response.data.movies]; // Aggiungi nuovi risultati
            page.value = nextPage;
        }
    } catch (error) {
        console.error("Errore durante il caricamento dei film:", error);
    } finally {
        loading.value = false;
    }
};
</script>
