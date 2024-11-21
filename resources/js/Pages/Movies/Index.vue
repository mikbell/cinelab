<template>
    <AppLayout>
        <template #header>
            <h2 class="py-4 text-3xl font-bold text-center text-gray-800">
                OMDB API - Ricerca Film
            </h2>
        </template>

        <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white rounded-lg shadow-lg">
                <!-- Input di ricerca -->
                <div class="p-6 bg-gray-100">
                    <div class="relative">
                        <input
                            type="text"
                            v-model="defaultKeyword"
                            @input="searchMovies"
                            placeholder="Cerca un film..."
                            class="w-full p-4 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        />
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            class="absolute w-5 h-5 text-gray-400 transform -translate-y-1/2 left-3 top-1/2"
                            viewBox="0 0 20 20"
                            fill="currentColor"
                        >
                            <path
                                fill-rule="evenodd"
                                d="M12.9 14.32a8 8 0 111.414-1.414l4.387 4.386a1 1 0 01-1.414 1.415l-4.387-4.387zM8 14a6 6 0 100-12 6 6 0 000 12z"
                                clip-rule="evenodd"
                            />
                        </svg>
                    </div>
                </div>

                <!-- Risultati -->
                <div class="p-6">
                    <div
                        v-if="filteredMovies.length"
                        class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4"
                    >
                        <Link
                            :href="route('movies.show', movie.imdbID)"
                            v-for="movie in filteredMovies"
                            :key="movie.imdbID"
                            class="flex flex-col items-center transition-shadow duration-300 bg-white rounded-lg shadow-md group hover:shadow-lg"
                        >
                            <img
                                :src="movie.Poster"
                                alt="Movie Poster"
                                class="w-40 h-auto rounded-t-lg"
                            />
                            <div class="w-full p-4 text-center">
                                <h4
                                    class="text-lg font-bold text-gray-800 transition duration-150 group-hover:text-blue-600"
                                >
                                    {{ movie.Title }}
                                </h4>
                                <p class="text-sm text-gray-500">
                                    {{ movie.Year }}
                                </p>
                            </div>
                        </Link>
                    </div>
                    <!-- Nessun risultato -->
                    <div v-else class="mt-8 text-center">
                        <p class="text-lg text-gray-600">
                            Nessun film trovato. Prova con un'altra keyword.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { ref, watch } from "vue";
import { Link } from "@inertiajs/vue3";
import { debounce } from "lodash";

const props = defineProps({
    movies: Array, // Film restituiti dal backend
    defaultKeyword: String, // Parola chiave di default
});

const defaultKeyword = ref(props.defaultKeyword || "");
const localMovies = ref(props.movies);
const filteredMovies = ref([...props.movies]);

// Aggiorna defaultKeyword dinamicamente quando cambia la prop
watch(
    () => props.movies,
    (newMovies) => {
        console.log("Film ricevuti dal backend:", newMovies);
        localMovies.value = newMovies;
        filterMovies();
    }
);

const searchMovies = debounce(async () => {
    console.log("Eseguo ricerca per:", defaultKeyword.value);

    try {
        const response = await axios.get(route("movies.index"), {
            params: { keyword: defaultKeyword.value },
        });

        localMovies.value = response.data.movies;
        filterMovies();
    } catch (error) {
        console.error("Errore durante la ricerca:", error);
    }
}, 300); // Ritardo di 300ms

// Filtro dei film basato sull'input dell'utente
const filterMovies = () => {
    if (localMovies.value) {
        console.log("Parola chiave:", defaultKeyword.value);
        console.log("Film locali:", localMovies.value);

        filteredMovies.value = localMovies.value.filter((movie) =>
            movie.Title.toLowerCase().includes(
                defaultKeyword.value.toLowerCase()
            )
        );

        console.log("Film filtrati:", filteredMovies.value);
    } else {
        console.error("localMovies non è stato inizializzato");
    }
};
</script>
