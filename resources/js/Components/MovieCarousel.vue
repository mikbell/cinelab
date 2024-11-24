<template>
    <Swiper
        :space-between="16"
        :slides-per-view="1"
        :breakpoints="{
            640: { slidesPerView: 2, spaceBetween: 16 },
            768: { slidesPerView: 3, spaceBetween: 24 },
            1024: { slidesPerView: 4, spaceBetween: 32 },
        }"
        navigation
        pagination
    >
        <SwiperSlide v-for="movie in movies" :key="movie.id" class="py-4">
            <MovieCard :href="route('movies.show', movie.id)" :movie="movie" />
        </SwiperSlide>
    </Swiper>
</template>

<script setup>
// Importa Swiper.js e i moduli necessari
import { Swiper, SwiperSlide } from "swiper/vue";
import "swiper/swiper-bundle.css";

import MovieCard from "@/Components/MovieCard.vue";

// Props
const props = defineProps({
    movies: {
        type: Array,
        required: true,
    },
});
</script>
