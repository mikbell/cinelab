<template>
    <AppLayout>
        <template #header>
            <h2 class="py-4 text-3xl font-bold text-center text-gray-800">
                Movie Details
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-5xl px-4 mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white rounded-lg shadow-xl">
                    <!-- Movie Poster -->
                    <div class="flex justify-center p-4 bg-gray-900">
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
                        </div>

                        <!-- Plot -->
                        <div class="pt-6 mt-8 border-t">
                            <h2 class="text-2xl font-semibold text-gray-700">
                                Plot
                            </h2>
                            <p class="mt-4 leading-relaxed text-gray-600">
                                {{ movie.overview }}
                            </p>
                        </div>

                        <!-- Movie Information Grid -->
                        <div
                            class="grid grid-cols-1 gap-6 mt-8 text-gray-700 md:grid-cols-2"
                        >
                            <div>
                                <p>
                                    <strong>Released:</strong>
                                    {{ movie.release_date }}
                                </p>

                                <p>
                                    <strong>Language:</strong>
                                    {{ movie.original_language }}
                                </p>

                                <p>
                                    <strong>Rated:</strong>
                                    {{ movie.vote_average }}
                                </p>
                                <p>
                                    <strong>Vote Count:</strong>
                                    {{ movie.vote_count }}
                                </p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="mt-10 space-x-4 text-center">
                            <PrimaryButton as="link" :href="route('movies.index')"> Back to List </PrimaryButton>
                            <SecondaryButton>
                                Add to Favorites
                            </SecondaryButton>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";

const props = defineProps({
    movie: Object,
});
</script>
