<script setup>
import { Link } from "@inertiajs/vue3";

defineProps({
    type: {
        type: String,
        default: "button", // Valore di default per i button
    },
    as: {
        type: String,
        default: "button", // Specifica se è un "button" o un "link"
        validator: (value) => ["button", "link"].includes(value),
    },
    href: {
        type: String,
        default: "",
        required: (props) => props.as === "link", // Obbligatorio se `as` è "link"
    },
    classes: {
        type: String,
        default:
            "inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150",
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
            :class="[classes, disabled ? 'opacity-50 cursor-not-allowed' : '']"
            :disabled="disabled"
        >
            <slot />
        </button>
    </template>
    <template v-else-if="as === 'link'">
        <Link
            :href="disabled ? '#' : href"
            :class="[classes, disabled ? 'opacity-50 cursor-not-allowed pointer-events-none' : '']"
        >
            <slot />
        </Link>
    </template>
</template>
