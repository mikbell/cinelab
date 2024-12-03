<template>
    <div>
        <h3 class="text-2xl font-bold text-gray-800">{{ title }}</h3>
        <slot />
    </div>
</template>

<script setup>
defineProps({
    title: {
        type: String,
        required: true,
    },
});
</script>
