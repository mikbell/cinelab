<template>
    <AppLayout>
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                OMDB API - Movie Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-xl">
                    <!-- Movie Poster -->
                    <div class="flex bg-gray-800">
                        <img
                            :src="data.Poster"
                            alt="Movie Poster"
                            class="mx-auto"
                        />
                    </div>

                    <!-- Movie Details -->
                    <div class="p-6">
                        <!-- Title and Year -->
                        <div class="text-center">
                            <h1 class="text-3xl font-bold text-gray-900">
                                {{ data.Title }}
                            </h1>
                            <p class="text-lg text-gray-500">
                                ({{ data.Year }})
                            </p>
                        </div>

                        <!-- Plot -->
                        <div class="mt-6">
                            <h2 class="text-lg font-semibold text-gray-700">
                                Plot
                            </h2>
                            <p class="mt-2 text-gray-600">{{ data.Plot }}</p>
                        </div>

                        <!-- Movie Information Grid -->
                        <div class="grid grid-cols-2 gap-4 mt-8 text-gray-700">
                            <div>
                                <p><strong>Type:</strong> {{ data.Type }}</p>
                                <p><strong>Genre:</strong> {{ data.Genre }}</p>
                                <p>
                                    <strong>Released:</strong>
                                    {{ data.Released }}
                                </p>
                                <p>
                                    <strong>Director:</strong>
                                    {{ data.Director }}
                                </p>
                                <p>
                                    <strong>Runtime:</strong> {{ data.Runtime }}
                                </p>
                                <p>
                                    <strong>Language:</strong>
                                    {{ data.Language }}
                                </p>
                                <p>
                                    <strong>Country:</strong> {{ data.Country }}
                                </p>
                            </div>
                            
                            <div>
                                <p>
                                    <strong>Box Office:</strong>
                                    {{ data.BoxOffice }}
                                </p>
                                <p>
                                    <strong>Awards:</strong> {{ data.Awards }}
                                </p>
                                <p><strong>Rated:</strong> {{ data.Rated }}</p>
                                <p>
                                    <strong>Writer:</strong> {{ data.Writer }}
                                </p>
                                <p>
                                    <strong>Actors:</strong> {{ data.Actors }}
                                </p>
                                <p>
                                    <strong>Metascore:</strong>
                                    {{ data.Metascore }}
                                </p>
                                <p>
                                    <strong>IMDB Rating:</strong>
                                    {{ data.ImdbRating }}
                                </p>
                                <p>
                                    <strong>IMDB Votes:</strong>
                                    {{ data.ImdbVotes }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";

const props = defineProps({
    data: Object,
});
</script>
