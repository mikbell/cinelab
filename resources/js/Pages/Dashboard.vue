<template>
    <AppLayout title="Dashboard">
        <!-- Header -->
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900 ">
                Cinelab
            </h2>
        </template>
        <Container>
            <div class="py-12 space-y-12">
                <!-- Film popolari -->
                <Section title="Film Popolari">
                    <MovieCarousel :movies="popularMovies" />
                </Section>

                <!-- Film più votati -->
                <Section title="Film Più Votati">
                    <MovieCarousel :movies="topRatedMovies" />
                </Section>

                <!-- Film recenti -->
                <Section title="Film Recenti">
                    <MovieCarousel :movies="recentMovies" />
                </Section>

                <!-- Film d'Azione -->
                <Section title="Film d'Azione">
                    <MovieCarousel :movies="actionMovies" />
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

const props = defineProps({
    popularMovies: Array,
    topRatedMovies: Array,
    recentMovies: Array,
    actionMovies: Array,
});
</script>
