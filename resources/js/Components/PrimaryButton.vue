<script setup>
import { Link } from "@inertiajs/vue3";

const props = defineProps({
    type: {
        type: String,
        default: "submit", // Valore di default per i button
    },
    as: {
        type: String,
        default: "button", // Specifica se è un "button" o un "link"
        validator: (value) => ["button", "link"].includes(value),
    },
    href: {
        type: String,
        default: "",
    },
    classes: {
        type: String,
        default:
            "inline-flex items-center px-4 py-2 text-xs font-semibold tracking-widest text-white uppercase transition duration-150 ease-in-out bg-gray-800 border border-transparent rounded-md hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-50",
    },
    disabled: {
        type: Boolean,
        default: false, // Gestisce lo stato disabilitato
    },
});
</script>

<template>
    <template v-if="as === 'button'">
        <button
            :type="type"
            :class="[props.classes, disabled ? 'opacity-50 cursor-not-allowed' : '']"
            :disabled="disabled"
        >
            <slot />
        </button>
    </template>
    <template v-else-if="as === 'link'">
        <Link
            :href="disabled ? '#' : href"
            :class="[
                props.classes,
                disabled
                    ? 'opacity-50 cursor-not-allowed pointer-events-none'
                    : '',
            ]"
        >
            <slot />
        </Link>
    </template>
</template>
