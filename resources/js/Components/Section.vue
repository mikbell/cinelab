<template>
    <div>
        <Link :href="href">
            <h3 class="text-2xl font-bold text-gray-800">{{ title }}</h3>
        </Link>
        <slot />
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
defineProps({
    title: {
        type: String,
        required: true,
    },
    href: {
        type: String,
        required: true,
    },
});
</script>
