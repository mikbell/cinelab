<script setup>
import { ref } from "vue";
import { Head, Link, router, usePage } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import ConfirmationModalWrapper from "@/Components/ConfirmationModalWrapper.vue";

defineProps({
    title: String,
});

const page = usePage();
const user = usePage().props.auth?.user || null;
if (!user) {
    console.log("L'utente non è autenticato.");
}
const username = user ? user.name : "Guest";
const showingNavigationDropdown = ref(false);

const logout = () => {
    router.post(route("logout"));
};

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
            <!-- Barra di navigazione -->
            <nav
                class="sticky top-0 z-50 shadow-md bg-gradient-to-r from-blue-500 via-purple-500 to-pink-500"
            >
                <div class="px-4 mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <!-- Logo e collegamenti -->
                        <div class="flex items-center">
                            <Link :href="route('dashboard')" class="shrink-0">
                                <ApplicationMark class="w-auto h-9" />
                            </Link>
                            <div class="hidden space-x-8 ms-10 sm:flex">
                                <NavLink
                                    v-for="link in navLinks"
                                    :key="link.name"
                                    :href="link.href"
                                    :active="link.active"
                                    class="transition-colors duration-200 hover:text-white"
                                >
                                    {{ link.name }}
                                </NavLink>
                            </div>
                        </div>

                        <!-- Dropdown utente -->
                        <div class="hidden sm:flex sm:items-center">
                            <Dropdown v-if="user" align="right" width="48">
                                <template #trigger>
                                    <button
                                        class="flex items-center text-sm font-medium text-white hover:text-gray-300"
                                    >
                                        <img
                                            v-if="
                                                page.props.jetstream
                                                    .managesProfilePhotos
                                            "
                                            class="w-8 h-8 rounded-full shadow-md"
                                            :src="user.profile_photo_url"
                                            :alt="username"
                                        />
                                        <span v-else>{{ username }}</span>
                                        <svg
                                            xmlns="http://www.w3.org/2000/svg"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor"
                                            class="w-5 h-5 ml-2"
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
                                    <DropdownLink :href="route('profile.show')"
                                        >Profilo</DropdownLink
                                    >
                                    <DropdownLink
                                        :href="route('favorites.index')"
                                        >Film Preferiti</DropdownLink
                                    >
                                    <DropdownLink :href="route('posts.create')"
                                        >Crea Post</DropdownLink
                                    >
                                    <form @submit.prevent="logout">
                                        <DropdownLink as="button"
                                            >Log Out</DropdownLink
                                        >
                                    </form>
                                </template>
                            </Dropdown>
                            <div v-else>
                                <NavLink
                                    :href="route('login')"
                                    class="hover:text-gray-300"
                                    >Log in</NavLink
                                >
                                <NavLink
                                    :href="route('register')"
                                    class="ml-4 hover:text-gray-300"
                                    >Register</NavLink
                                >
                            </div>
                        </div>

                        <!-- Hamburger menu -->
                        <div class="flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="p-2 text-white rounded-md hover:bg-gray-100 hover:text-gray-600"
                            >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                    stroke="currentColor"
                                    class="w-6 h-6"
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

                <!-- Menu responsivo -->
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

                    <div v-if="user" class="pt-4 pb-3 border-t border-gray-200">
                        <div class="flex items-center px-4">
                            <div
                                v-if="page.props.jetstream.managesProfilePhotos"
                                class="flex-shrink-0 mr-3"
                            >
                                <img
                                    class="w-10 h-10 rounded-full shadow-md"
                                    :src="user.profile_photo_url"
                                    :alt="username"
                                />
                            </div>

                            <div>
                                <div class="text-base font-medium text-white">
                                    {{ username }}
                                </div>
                                <div class="text-sm font-medium text-white">
                                    {{ user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('profile.show')"
                                :active="route().current('profile.show')"
                            >
                                Profilo
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('favorites.index')"
                                :active="route().current('favorites.index')"
                            >
                                Film Preferiti
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('posts.create')"
                                :active="route().current('posts.create')"
                            >
                                Crea Post
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>

                    <div v-else class="pt-4 pb-3 border-t border-gray-200">
                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('login')"
                                :active="route().current('login')"
                            >
                                Log in
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('register')"
                                :active="route().current('register')"
                            >
                                Register
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Contenuto principale -->
            <main class="min-h-screen">
                <slot />
            </main>

            <!-- Footer -->
            <footer class="shadow bg-gradient-to-t from-gray-200 to-gray-100">
                <div
                    class="px-4 py-6 mx-auto text-center max-w-7xl sm:px-6 lg:px-8"
                >
                    <p class="text-sm text-gray-600">
                        Powered by the
                        <a
                            target="_blank"
                            href="https://www.themoviedb.org/"
                            class="font-medium text-blue-600 hover:underline"
                        >
                            TMDB
                        </a>
                        API
                    </p>
                    <p class="text-sm text-gray-600">
                        &copy; {{ new Date().getFullYear() }} CineLab
                    </p>
                </div>
            </footer>
        </div>

        <ConfirmationModalWrapper />
    </div>
</template>
