<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import FavoriteMovieCard from "@/Components/FavoriteMovieCard.vue";
import { ref } from "vue";
import axios from "axios";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps({
    favorites: Array,
});

// Stato locale per i preferiti
const favorites = ref([...props.favorites]);

// Funzione per rimuovere un preferito
const removeFavorite = async (movieId) => {
    try {
        await axios.delete(`/favorites/${movieId}`);
        // Aggiorna lo stato locale eliminando il film rimosso
        favorites.value = favorites.value.filter(
            (movie) => movie.id !== movieId
        );
    } catch (error) {
        console.error("Errore durante la rimozione:", error);
        alert("Si è verificato un errore. Riprova più tardi.");
    }
};
</script>

<template>
    <AppLayout title="Favorites">
        <Container>
            <PageHeading> I miei Preferiti </PageHeading>
            <div
                v-if="favorites.length"
                class="grid gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5"
            >
                <FavoriteMovieCard
                    v-for="movie in favorites"
                    :key="movie.id"
                    :movie="movie"
                    @remove-favorite="removeFavorite(movie.id)"
                />
            </div>
            <p v-else class="text-gray-600">Non hai ancora preferiti.</p>
        </Container>
    </AppLayout>
</template>
