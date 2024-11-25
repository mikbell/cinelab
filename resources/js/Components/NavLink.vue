<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
    href: String,
    active: Boolean,
});

const classes = computed(() => {
    return props.active
        ? 'border-white text-white'
        : 'border-transparent text-gray-300 hover:text-white hover:border-white';
});
</script>

<template>
    <Link :href="href" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out border-b-2 focus:outline-none" :class="classes">
        <slot />
    </Link>
</template>
