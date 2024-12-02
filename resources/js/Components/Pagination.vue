<template>
    <div class="flex items-center justify-between px-4 py-3 sm:px-6">
        <!-- Mobile View -->
        <div class="flex justify-between flex-1 sm:hidden">
            <Link
                :href="previousUrl"
                class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                :class="{
                    'opacity-50 pointer-events-none': !meta.prev_page_url,
                }"
                :only="only"
            >
                <ChevronLeftIcon class="w-5 h-5 mr-2" />
                Previous
            </Link>
            <Link
                :href="nextUrl"
                class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:ring-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed"
                :class="{
                    'opacity-50 pointer-events-none': !meta.next_page_url,
                }"
                :only="only"
            >
                Next
                <ChevronRightIcon class="w-5 h-5 ml-2" />
            </Link>
        </div>

        <!-- Desktop View -->
        <div
            class="hidden mx-auto sm:flex-1 sm:flex sm:flex-col sm:items-center sm:justify-center"
        >
            <!-- Results Summary -->
            <div>
                <p class="text-sm text-gray-700">
                    Showing
                    <span class="font-medium">{{ meta.from }}</span>
                    to
                    <span class="font-medium">{{ meta.to }}</span>
                    of
                    <span class="font-medium">{{ meta.total }}</span>
                    results
                </p>
            </div>

            <!-- Pagination Navigation -->
            <div>
                <nav
                    class="inline-flex -space-x-px bg-white rounded-md shadow-sm isolate"
                    aria-label="Pagination"
                >
                    <!-- Page Links -->
                    <Link
                        v-for="link in meta.links"
                        :key="link.label"
                        :href="link.url"
                        class="relative inline-flex items-center px-4 py-2 text-sm font-medium transition-colors duration-150 border border-gray-300 focus:z-20 focus:outline-offset-0"
                        :class="{
                            'z-10 bg-blue-600 text-white focus:ring-2 focus:ring-indigo-500':
                                link.active,
                            'text-gray-700 hover:bg-gray-50': !link.active,
                        }"
                        v-html="link.label"
                        preserve-scroll="true"
                        aria-current="page"
                        :aria-disabled="!link.url"
                        :only="only"
                    ></Link>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Link } from "@inertiajs/vue3";
import { ChevronLeftIcon, ChevronRightIcon } from "@heroicons/vue/20/solid";
import { computed } from "vue";

const props = defineProps({
    meta: {
        type: Object,
        required: true,
    },
    only: {
        type: Array,
        default: () => [],
    },
});

const only = computed(() =>
    props.only.length === 0 ? [] : [...props.only, "jetstream"]
);
const previousUrl = computed(() => props.meta.links[0].url);
const nextUrl = computed(() => [...props.meta.links].reverse()[0].url);
</script>
