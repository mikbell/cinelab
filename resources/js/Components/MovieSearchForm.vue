<template>
    <div class="flex gap-2 mb-6">
        <!-- Campo di input per la ricerca -->
        <TextInput
            v-model="query"
            @keyup.enter="searchMovies"
            type="text"
            placeholder="Inserisci il nome del film..."
            class="flex-1"
        />

        <!-- Pulsante per cercare -->
        <PrimaryButton @click="searchMovies" :disabled="loading">
            <span v-if="!loading">Cerca</span>
            <span v-else>Caricamento...</span>
        </PrimaryButton>
    </div>
</template>

<script setup>
import { ref } from "vue";
import axios from "axios";
import PrimaryButton from "./PrimaryButton.vue";
import TextInput from "./TextInput.vue";

const props = defineProps({
    query: String, // Valore iniziale della query
    onSearch: Function, // Callback per aggiornare i risultati
});

// Stato locale
const query = ref(props.query || ""); // Query di ricerca
const loading = ref(false); // Stato di caricamento

// Funzione per eseguire la ricerca
const searchMovies = async () => {
    if (!query.value.trim() || loading.value) return; // Evita richieste multiple

    loading.value = true;

    try {
        const response = await axios.get(route("movies.index"), {
            params: { query: query.value, page: 1 },
        });

        // Chiamata alla funzione di callback per aggiornare i risultati
        props.onSearch(response.data.movies, response.data.total_results);
    } catch (error) {
        console.error("Errore durante la ricerca:", error);
    } finally {
        loading.value = false;
    }
};
</script>
