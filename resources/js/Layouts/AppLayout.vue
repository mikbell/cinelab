<script setup>
import { ref } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";

defineProps({
    title: String,
});

// Ottieni i dati della pagina da Inertia
const page = usePage();
const user = page.props?.auth?.user || null; // Fallback a null se l'utente non è autenticato
const username = user ? user.name : "Guest";
const showingNavigationDropdown = ref(false);

// Funzione di logout
const logout = () => {
    router.post(route("logout"));
};

// Collegamenti di navigazione
const navLinks = [
    {
        name: "Dashboard",
        href: route("dashboard"),
        active: route().current("dashboard"),
    },
    {
        name: "Film",
        href: route("movies.index"),
        active: route().current("movies.index"),
    },
    {
        name: "Forum",
        href: route("posts.index"),
        active: route().current("posts.index"),
    },

];
</script>

<template>
    <div>
        <!-- Titolo della pagina -->
        <Head :title="title" />

        <!-- Banner -->
        <Banner />

        <div class="min-h-screen bg-gradient-to-br from-gray-100 to-gray-200">
            <nav class="shadow-md bg-gradient-to-b from-red-500 to-red-800">
                <!-- Menu di navigazione principale -->
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex items-center">
                            <!-- Logo -->
                            <div class="shrink-0">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="w-auto h-9" />
                                </Link>
                            </div>

                            <!-- Collegamenti di navigazione -->
                            <div class="hidden space-x-8 ms-10 sm:flex">
                                <NavLink
                                    v-for="link in navLinks"
                                    :key="link.name"
                                    :href="link.href"
                                    :active="link.active"
                                >
                                    {{ link.name }}
                                </NavLink>
                            </div>
                        </div>

                        <!-- Dropdown impostazioni -->
                        <div class="hidden sm:flex sm:items-center">
                            <div class="relative">
                                <!-- Se l'utente è autenticato -->
                                <Dropdown v-if="user" align="right" width="48">
                                    <template #trigger>
                                        <button
                                            class="flex items-center space-x-2 text-sm text-gray-600 transition focus:outline-none"
                                        >
                                            <img
                                                v-if="
                                                    page.props.jetstream
                                                        .managesProfilePhotos
                                                "
                                                class="w-8 h-8 border rounded-full shadow-lg"
                                                :src="user.profile_photo_url"
                                                :alt="username"
                                            />
                                            <span v-else class="font-medium">
                                                {{ username }}
                                            </span>
                                            <svg
                                                xmlns="http://www.w3.org/2000/svg"
                                                fill="none"
                                                viewBox="0 0 24 24"
                                                stroke="currentColor"
                                                class="w-5 h-5 text-white"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 9l-7 7-7-7"
                                                />
                                            </svg>
                                        </button>
                                    </template>

                                    <template #content>
                                        <span class="px-2 text-sm text-gray-500">{{ username }}</span>
                                        <DropdownLink
                                            :href="route('profile.show')"
                                        >
                                            Profile
                                        </DropdownLink>
                                        <DropdownLink
                                            v-if="
                                                page.props.jetstream
                                                    .hasApiFeatures
                                            "
                                            :href="route('api-tokens.index')"
                                        >
                                            API Tokens
                                        </DropdownLink>
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>

                                <!-- Se l'utente è ospite -->
                                <div v-else class="flex space-x-4">
                                    <NavLink :href="route('login')">
                                        Log in
                                    </NavLink>
                                    <NavLink :href="route('register')">
                                        Register
                                    </NavLink>
                                </div>
                            </div>
                        </div>

                        <!-- Menu hamburger per dispositivi mobili -->
                        <div class="sm:hidden">
                            <button
                                class="p-2 text-gray-400 rounded-md hover:bg-gray-100 hover:text-gray-600"
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                            >
                                <svg
                                    class="w-6 h-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        v-if="!showingNavigationDropdown"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        v-else
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Menu di navigazione responsivo -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink
                            v-for="link in navLinks"
                            :key="link.name"
                            :href="link.href"
                            :active="link.active"
                        >
                            {{ link.name }}
                        </ResponsiveNavLink>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Contenuto principale -->
            <main class="py-6">
                <slot />
            </main>

            <!-- Footer -->
            <footer class="bg-white shadow">
                <div class="px-4 py-6 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <p>Powered by the <Link href="https://www.themoviedb.org/" class="underline">TMDB</Link> API</p>
                    <p>&copy; {{ new Date().getFullYear() }}</p>
                </div>
            </footer>
        </div>
    </div>
</template>
