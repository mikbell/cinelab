<script setup>
import { computed } from 'vue';

const model = defineModel('checked');

const props = defineProps({
    value: {
        type: String,
        default: null,
    },
});

const proxyChecked = computed({
    get() {
        return props.checked;
    },

    set(val) {
        emit('update:checked', val);
    },
});
</script>


<template>
    <input
        v-model="model"
        type="checkbox"
        :value="value"
        class="text-indigo-600 border-gray-300 rounded shadow-sm focus:ring-indigo-500"
    >
</template>
