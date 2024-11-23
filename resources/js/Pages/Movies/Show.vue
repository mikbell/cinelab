<template>
    <AppLayout :title="movie.title">
        <template #header>
            <h2 class="py-4 text-3xl font-bold text-center text-gray-800">
                Movie Details
            </h2>
        </template>

        <div class="py-12">
            <Container>
                <div class="overflow-hidden bg-white rounded-lg shadow-xl">
                    <!-- Movie Poster -->
                    <div class="flex justify-center p-6 bg-gray-900">
                        <img
                            :src="`https://image.tmdb.org/t/p/w500${movie.poster_path}`"
                            alt="Movie Poster"
                            class="w-auto rounded-lg shadow-lg h-96"
                        />
                    </div>

                    <!-- Movie Details -->
                    <div class="p-8">
                        <!-- Title and Year -->
                        <div class="text-center">
                            <h1 class="text-4xl font-extrabold text-gray-800">
                                {{ movie.title }}
                            </h1>
                            <p class="mt-2 text-lg text-gray-500">
                                Data di uscita:
                                {{ formatDate(movie.release_date) }}
                            </p>
                        </div>

                        <!-- Plot -->
                        <div class="pt-6 mt-8 border-t">
                            <h2 class="text-2xl font-semibold text-gray-700">
                                Plot
                            </h2>
                            <p class="mt-4 leading-relaxed text-gray-600">
                                {{
                                    movie.overview ||
                                    "No plot available for this movie."
                                }}
                            </p>
                        </div>

                        <!-- Movie Information Grid -->
                        <div
                            class="grid grid-cols-1 gap-6 mt-8 text-gray-700 md:grid-cols-2"
                        >
                            <div>
                                <p>
                                    <strong>Lingua Originale:</strong>
                                    {{ movie.original_language.toUpperCase() }}
                                </p>
                                <p class="flex items-center">
                                    <strong>Voto:</strong>
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        viewBox="0 0 24 24"
                                        fill="currentColor"
                                        stroke="currentColor"
                                        stroke-width="2"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        class="w-4 h-4 text-yellow-500"
                                    >
                                        <path
                                            d="M11.525 2.295a.53.53 0 0 1 .95 0l2.31 4.679a2.123 2.123 0 0 0 1.595 1.16l5.166.756a.53.53 0 0 1 .294.904l-3.736 3.638a2.123 2.123 0 0 0-.611 1.878l.882 5.14a.53.53 0 0 1-.771.56l-4.618-2.428a2.122 2.122 0 0 0-1.973 0L6.396 21.01a.53.53 0 0 1-.77-.56l.881-5.139a2.122 2.122 0 0 0-.611-1.879L2.16 9.795a.53.53 0 0 1 .294-.906l5.165-.755a2.122 2.122 0 0 0 1.597-1.16z"
                                        />
                                    </svg>
                                    {{ movie.vote_average.toFixed(1) }}
                                </p>
                                <p>
                                    <strong>Numero di Voti:</strong>
                                    {{ movie.vote_count }}
                                </p>
                            </div>
                            <div>
                                <p>
                                    <strong>Genere:</strong>
                                    {{ formatGenres(movie.genres) }}
                                </p>
                                <p>
                                    <strong>Durata:</strong>
                                    {{ formatRuntime(movie.runtime) }}
                                </p>
                                <p>
                                    <strong>Popolarità:</strong>
                                    {{ movie.popularity.toFixed(2) }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-10 space-x-4 text-center">
                            <PrimaryButton
                                as="link"
                                :href="route('movies.index')"
                            >
                                Back to List
                            </PrimaryButton>
                            <SecondaryButton>
                                Add to Favorites
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </Container>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import Container from "@/Components/Container.vue";

const props = defineProps({
    movie: Object,
});

// Formatta la data
const formatDate = (dateString) => {
    if (!dateString) return "Unknown";
    const date = new Date(dateString);
    return new Intl.DateTimeFormat("en-US", {
        year: "numeric",
        month: "long",
        day: "numeric",
    }).format(date);
};

// Formatta la durata
const formatRuntime = (runtime) => {
    if (!runtime) return "Unknown runtime";
    const hours = Math.floor(runtime / 60);
    const minutes = runtime % 60;
    return `${hours}h ${minutes}min`;
};

// Formatta i generi
const formatGenres = (genres) => {
    if (!genres || !genres.length) return "Unknown genres";
    return genres.map((genre) => genre.name).join(", ");
};
</script>
