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
        : 'border-transparent text-gray-300 hover:text-gray-200 hover:border-gray-200 focus:text-gray-200 focus:border-gray-200';
});
</script>

<template>
    <Link :href="href" class="inline-flex items-center px-1 pt-1 text-sm font-medium leading-5 transition duration-150 ease-in-out border-b-2 focus:outline-none" :class="classes">
        <slot />
    </Link>
</template>
