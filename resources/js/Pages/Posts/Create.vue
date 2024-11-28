<template>
    <AppLayout title="Crea Post">
        <!-- Header -->
        <template #header>
            <h2 class="text-3xl font-bold text-center text-gray-900">
                Crea Post
            </h2>
        </template>

        <Container>
            <form @submit.prevent="createPost">
                <!-- Input per il titolo -->
                <div>
                    <InputLabel for="title" value="Title" class="sr-only" />
                    <TextInput
                        id="title"
                        v-model="form.title"
                        placeholder="Titolo del post"
                        type="text"
                        class="block w-full mt-1"
                        required
                        autofocus
                        autocomplete="title"
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <!-- Selezione del topic -->
                <div class="mt-3">
                    <InputLabel for="topic_id" value="Topic" />
                    <select
                        id="topic_id"
                        v-model="form.topic_id"
                        class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                    >
                        <option value="" disabled>Seleziona un topic</option>
                        <option
                            v-for="topic in topics"
                            :key="topic.id"
                            :value="topic.id"
                        >
                            {{ topic.name }}
                        </option>
                    </select>
                    <InputError class="mt-2" :message="form.errors.topic_id" />
                </div>

                <!-- Editor Markdown per il contenuto -->
                <div class="mt-6">
                    <InputLabel for="content" value="Content" class="sr-only" />
                    <MarkdownEditor v-model="form.content">
                        <!-- Toolbar personalizzata -->
                        <template #toolbar="{ editor }">
                            <li v-if="!isInProduction()">
                                <button
                                    @click="autofill"
                                    type="button"
                                    class="px-3 py-2 rounded-md hover:bg-gray-100"
                                    title="Autocompleta"
                                >
                                    <i class="ri-article-line"></i>
                                    <span class="ml-1 text-sm">Autofill</span>
                                </button>
                            </li>
                        </template>
                    </MarkdownEditor>
                    <InputError class="mt-2" :message="form.errors.content" />
                </div>

                <!-- Pulsante di invio -->
                <div class="flex items-center justify-end mt-6">
                    <PrimaryButton
                        type="submit"
                        :class="{ 'opacity-50': form.processing }"
                        :disabled="form.processing"
                    >
                        Salva
                    </PrimaryButton>
                </div>
            </form>
        </Container>
    </AppLayout>
</template>

<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Container from "@/Components/Container.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import { isInProduction } from "@/Utilities/environment.js";
import axios from "axios";

const props = defineProps({
    topics: {
        type: Array,
        default: () => [],
    },
});

// Stato del form
const form = useForm({
    title: "",
    topic_id: props.topics.length ? props.topics[0].id : "", // Seleziona il primo topic come default
    content: "",
});

// Funzione per creare il post
const createPost = () => {
    form.post(route("posts.store"));
};

// Funzione di autocompletamento (solo in ambiente non di produzione)
const autofill = async () => {
    if (isInProduction()) return;

    try {
        const response = await axios.get("/local/post-content");
        form.title = response.data.title;
        form.content = response.data.content;
    } catch (error) {
        console.error("Errore durante l'autofill:", error);
    }
};
</script>
