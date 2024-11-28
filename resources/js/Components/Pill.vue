<template>
    <Link
        :href="href"
        class="px-2 py-0.5 text-sm text-gray-700 whitespace-nowrap transition duration-150 ease-in-out border border-gray-700  rounded-full hover:bg-gray-700  hover:text-white"
        :class="filled ? 'bg-gray-700 text-white' : ''"
        ><slot />
    </Link>
</template>

<script setup>
defineProps({
    href: {
        type: String,
        required: true,
    },
    filled: {
        type: Boolean,
        default: false,
    }
});
import {Link} from "@inertiajs/vue3";
</script>
