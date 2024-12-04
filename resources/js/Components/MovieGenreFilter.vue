<template>
    <div>
        <!-- Dropdown per i generi -->
        <div class="mb-4">
            <select
                v-model="selectedGenre"
                @change="filterByGenre"
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
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import MovieCard from "@/Components/MovieCard.vue";

const props = defineProps({
    initialMovies: Array,
    totalResults: Number,
    genres: Array,
});

const movies = ref([...props.initialMovies]);
const selectedGenre = ref("");
const totalResults = ref(props.totalResults);

const filterByGenre = async () => {
    console.log("Genere selezionato:", selectedGenre.value);

    try {
        const response = await axios.get(route("movies.index"), {
            params: { genre: selectedGenre.value, page: 1 },
        });

        console.log("Risposta API:", response.data);
        movies.value = response.data.movies || [];
        totalResults.value = response.data.total_results || 0;
    } catch (error) {
        console.error("Errore durante il filtraggio per genere:", error);
    }
};
</script>
