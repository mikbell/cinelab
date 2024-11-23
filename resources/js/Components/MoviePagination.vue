<template>
    <div class="flex justify-center mt-6 space-x-2">
        <!-- Pulsante Precedente -->
        <button
            :disabled="props.page <= 1"
            @click="emitPageChange(props.page - 1)"
            class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
        >
            Precedente
        </button>

        <!-- Numeri di Pagina -->
        <button
            v-for="p in pages"
            :key="p"
            @click="emitPageChange(p)"
            :class="[
                'px-3 py-2 rounded-md',
                p === props.page
                    ? 'bg-blue-500 text-white'
                    : 'bg-gray-200 hover:bg-gray-300'
            ]"
        >
            {{ p }}
        </button>

        <!-- Pulsante Successivo -->
        <button
            :disabled="props.page >= props.totalPages"
            @click="emitPageChange(props.page + 1)"
            class="px-3 py-2 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
        >
            Successivo
        </button>
    </div>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    page: {
        type: Number,
        required: true,
    },
    totalPages: {
        type: Number,
        required: true,
    },
});

const emit = defineEmits(["page-change"]);

// Calcola l'intervallo di pagine da mostrare
const pages = computed(() => {
    const range = [];
    const start = Math.max(1, props.page - 2); // Mostra fino a 2 pagine prima
    const end = Math.min(props.totalPages, props.page + 2); // Mostra fino a 2 pagine dopo

    for (let i = start; i <= end; i++) {
        range.push(i);
    }

    return range;
});

const emitPageChange = (newPage) => {
    const targetPage = parseInt(newPage, 10); // Assicura che sia un numero
    if (targetPage > 0 && targetPage <= props.totalPages) {
        emit("page-change", targetPage); // Emette l'evento al genitore
    }
};
</script>
