<template>
    <AppLayout title="Search">
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">
                Cerca Film "{{ query }}"
            </h2>
        </template>

        <Container>
            <!-- Campo di ricerca -->
            <MovieSearchForm />

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

            <!-- Paginazione -->
            <MoviePagination
                :page="page"
                :totalPages="totalPages"
                @page-change="onPageChange"
            />
        </Container>
    </AppLayout>
</template>

<script setup>
import { ref } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import MovieCard from "@/Components/MovieCard.vue";
import MovieSearchForm from "@/Components/MovieSearchForm.vue";
import MoviePagination from "@/Components/MoviePagination.vue";
import Container from "@/Components/Container.vue";

const props = defineProps({
    movies: Array,
    query: String,
    totalResults: Number,
    page: Number,
});
const movies = ref([...props.movies]);

const totalPages = Math.ceil(props.totalResults / 32);

const onPageChange = (newPage) => {
    const targetPage = parseInt(newPage, 10); // Assicura che sia un numero

    console.log("Navigazione alla pagina:", targetPage); // Debug
    const url = route("movies.search", {
        page: targetPage,
        query: props.query,
    });
    window.location.href = url; // Naviga alla nuova pagina
};
</script>
