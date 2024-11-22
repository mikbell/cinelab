<template>
    <div class="flex justify-center mt-6">
        <button
            :disabled="page <= 1"
            @click="emitPageChange(page - 1)"
            class="px-4 py-2 mx-1 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
        >
            Precedente
        </button>
        <span class="px-4 py-2 mx-1 bg-white rounded-md shadow">
            Pagina {{ page }} di {{ totalPages }}
        </span>
        <button
            :disabled="page >= totalPages"
            @click="emitPageChange(page + 1)"
            class="px-4 py-2 mx-1 bg-gray-200 rounded-md hover:bg-gray-300 disabled:opacity-50"
        >
            Successivo
        </button>
    </div>
</template>

<script setup>
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

const emitPageChange = (newPage) => {
    const currentPage = parseInt(props.page, 10); // Assicura che la pagina corrente sia un numero
    const targetPage = parseInt(newPage, 10); // Assicura che la nuova pagina sia un numero

    if (targetPage > 0 && targetPage <= props.totalPages) {
        emit("page-change", targetPage); // Emette l'evento al genitore
    }
};
</script>
