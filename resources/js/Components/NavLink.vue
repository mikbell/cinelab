<script setup>
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return [
        "inline-flex items-center px-3 pt-1 pb-2 text-sm font-medium leading-5 border-b-2 transition duration-150 ease-in-out focus:outline-none",
        props.active
            ? "border-white text-white"
            : "border-transparent text-gray-300 hover:text-white hover:border-white",
    ].join(" ");
});
</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
