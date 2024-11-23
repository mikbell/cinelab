<template>
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
</template>

<script setup>

import { ref } from "vue";
import PrimaryButton from "./PrimaryButton.vue";

const props = defineProps({
    query: String,
    page: Number,
});

const query = ref(props.query);

const searchMovies = () => {
    if (!query.value.trim()) return;

    const url = route("movies.search", { query: query.value });
    window.location.href = url; // Cambia pagina per ricaricare i dati
};
</script>
