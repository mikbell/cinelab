<template>
    <AppLayout title="Movies">
        <template #header>
            <h2 class="py-4 text-3xl font-bold text-center text-gray-900">
                TMDb API - Film Popolari
            </h2>
        </template>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <!-- Bottone di ricerca -->
            <div class="flex justify-end mb-6">
                <PrimaryButton as="link" :href="route('movies.search')">
                    Cerca Film
                </PrimaryButton>
            </div>

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

            <!-- Paginazione -->
            <MoviePagination
                :page="page"
                :totalPages="totalPages"
                @page-change="onPageChange"
            />
        </div>
    </AppLayout>
</template>

<script setup>
import MovieCard from "@/Components/MovieCard.vue";
import MoviePagination from "@/Components/MoviePagination.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    movies: Array,
    totalResults: Number,
    page: Number,
});

const totalPages = Math.ceil(props.totalResults / 32);

const onPageChange = (newPage) => {
    const targetPage = parseInt(newPage, 10); // Assicura che sia un numero

    console.log("Navigazione alla pagina:", targetPage); // Debug
    const url = route("movies.index", { page: targetPage });
    window.location.href = url; // Naviga alla nuova pagina
};
</script>
