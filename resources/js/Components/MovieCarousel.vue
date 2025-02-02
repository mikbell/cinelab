<template>
    <div class="relative">
        <!-- Swiper -->
        <Swiper
            :space-between="16"
            :slides-per-view="2"
            :breakpoints="{
                640: { slidesPerView: 4, spaceBetween: 16 },
                768: { slidesPerView: 5, spaceBetween: 24 },
                1024: { slidesPerView: 6, spaceBetween: 32 },
            }"
            :navigation="true"
            class="swiper-container"
        >
            <!-- Slides -->
            <SwiperSlide
                v-for="movie in movies"
                :key="movie.id"
                class="py-6"
            >
                <MovieCard
                    :href="route('movies.show', movie.id)"
                    :movie="movie"
                />
            </SwiperSlide>

            <!-- Custom Navigation Buttons -->
            <div class="swiper-button-prev"></div>
            <div class="swiper-button-next"></div>
        </Swiper>

        <!-- Custom Pagination -->
        <div class="swiper-pagination"></div>
    </div>
</template>

<script setup>
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

<style scoped>
.swiper-container {
    width: 100%;
}
.swiper-pagination-bullet {
    background-color: #d1d5db; /* Grigio chiaro */
    opacity: 1;
    transition: background-color 0.3s;
}
.swiper-pagination-bullet-active {
    background-color: #ef4444; /* Rosso scuro */
}
.swiper-button-prev,
.swiper-button-next {
    color: rgb(179, 179, 179); /* Grigio medio */
    transition: color 0.3s;
}
.swiper-button-prev:hover,
.swiper-button-next:hover {
    color: white; /* Rosso scuro */
}
</style>
