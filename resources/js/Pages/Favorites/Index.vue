<template>
    <AppLayout title="Favorites">
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">
                I Miei Preferiti
            </h2>
        </template>

        <Container>
            <div
                v-if="favorites.length"
                class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
            >
                <FavoriteMovieCard
                    v-for="movie in favorites"
                    :key="movie.id"
                    :movie="movie"
                    :href="route('movies.show', movie.id)"
                />
            </div>
            <p v-else class="text-gray-600">No favorites yet.</p>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import FavoriteMovieCard from "@/Components/FavoriteMovieCard.vue";
import { ref } from "vue";
import axios from "axios";

const props = defineProps({
    favorites: Array,
});

const removeFavorite = async (movieId) => {
    try {
        await axios.delete(`/favorites/${movieId}`);
        // Ricarica i preferiti o aggiorna lo stato locale
        window.location.reload();
    } catch (error) {
        console.error("Errore durante la rimozione:", error);
    }
};
</script>
