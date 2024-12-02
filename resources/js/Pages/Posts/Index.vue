<template>
    <AppLayout title="Posts">
        <!-- Header -->
        <template #header>
            <h2
                class="text-3xl font-bold text-center text-gray-900"
                v-text="selectedTopic ? selectedTopic.name : 'Tutti i post'"
            ></h2>

            <p
                v-if="selectedTopic"
                class="mt-1 text-sm text-center text-gray-600"
            >
                {{ selectedTopic.description }}
            </p>
        </template>

        <!-- Lista dei post -->
        <Container>
            <form @submit.prevent="search" class="mb-4">
                <div>
                    <div class="flex mt-1 space-x-2">
                        <TextInput
                            v-model="searchForm.query"
                            class="w-full"
                            id="query"
                            name="query"
                        />
                        <SecondaryButton type="submit">Cerca</SecondaryButton>
                        <DangerButton v-if="searchForm.query" @click="clearSearch">Cancella</DangerButton>
                    </div>
                </div>
            </form>

            <menu class="flex pb-4 mb-4 space-x-1 overflow-auto">
                <li>
                    <Pill
                        :href="
                            route('posts.index', { query: searchForm.query })
                        "
                        :filled="!selectedTopic"
                        >Tutti i post
                    </Pill>
                </li>

                <li v-for="topic in topics" :key="topic.id">
                    <Pill
                        :href="
                            route('posts.index', {
                                topic: topic.slug,
                                query: searchForm.query,
                            })
                        "
                        :filled="topic.id === selectedTopic?.id"
                        >{{ topic.name }}
                    </Pill>
                </li>
            </menu>

            <ul class="space-y-6">
                <li
                    v-for="post in posts.data"
                    :key="post.id"
                    class="flex flex-col items-baseline justify-between p-6 transition-shadow duration-200 bg-white rounded-lg shadow-md md:flex-row group hover:shadow-lg"
                >
                    <Link :href="post.routes.show">
                        <h2
                            class="text-xl font-bold text-gray-800 transition duration-150 group-hover:text-blue-600"
                        >
                            {{ post.title }}
                        </h2>
                        <p class="mt-2 text-sm text-gray-600">
                            {{ formattedDate(post) }} by
                            <span class="font-semibold text-gray-700">{{
                                post.user.name
                            }}</span>
                        </p>
                    </Link>

                    <Pill :href="route('posts.index', post.topic.slug)"
                        >{{ post.topic.name }}
                    </Pill>
                </li>
            </ul>
        </Container>

        <!-- Paginazione -->
        <Pagination :meta="posts.meta" class="mt-6" />
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import Pagination from "@/Components/Pagination.vue";
import Container from "@/Components/Container.vue";
import Pill from "@/Components/Pill.vue";
import { relativeDate } from "@/Utilities/date";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";

const props = defineProps({
    posts: Object,
    topics: Object,
    selectedTopic: Object,
    query: String,
});

const formattedDate = (post) => relativeDate(post.created_at);

const searchForm = useForm({
    query: props.query,
    page: 1,
});

const page = usePage();

const search = () => {
    searchForm.get(page.url);
};

const clearSearch = () => {
    searchForm.query = '';
    search();
}
</script>
