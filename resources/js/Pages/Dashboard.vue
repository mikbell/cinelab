<template>
    <AppLayout title="Dashboard">
        <!-- Header -->

        <div class="flex items-center justify-center shadow-lg hero bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500 h-96">
            <h1 class="font-bold text-white text-7xl">Cinelab</h1>
        </div>

        <Container>
            <PageHeading> Dashboard </PageHeading>
            <div class="py-12 space-y-12">
                <Section
                    title="Film Popolari"
                    :href="route('movies.index', { type: popular })"
                >
                    <MovieCarousel :movies="popularMovies" />
                </Section>

                <Section
                    title="Film Più Votati"
                    :href="route('movies.index', { type: rated })"
                >
                    <MovieCarousel :movies="topRatedMovies" />
                </Section>

                <Section
                    title="Film Recenti"
                    :href="route('movies.index', { genre: recent })"
                >
                    <MovieCarousel :movies="recentMovies" />
                </Section>

                <Section
                    title="Film d'Azione"
                    :href="route('movies.index', { genre: 28 })"
                >
                    <MovieCarousel :movies="actionMovies" />
                </Section>

                <Section
                    title="Commedie"
                    :href="route('movies.index', { genre: 35 })"
                >
                    <MovieCarousel :movies="comedyMovies" />
                </Section>

                <Section
                    title="Drama"
                    :href="route('movies.index', { genre: 18 })"
                >
                    <MovieCarousel :movies="dramaMovies" />
                </Section>
            </div>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Section from "@/Components/Section.vue";
import MovieCarousel from "@/Components/MovieCarousel.vue";
import Container from "@/Components/Container.vue";
import PageHeading from "@/Components/PageHeading.vue";

const props = defineProps({
    popularMovies: Array,
    topRatedMovies: Array,
    recentMovies: Array,
    actionMovies: Array,
    comedyMovies: Array,
    dramaMovies: Array,
});
</script>
