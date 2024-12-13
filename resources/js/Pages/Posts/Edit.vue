<template>
    <AppLayout title="Crea Post">
        <!-- Header -->

        <Container>
            <PageHeading> Edita Post: {{ post.title }} </PageHeading>
            <form @submit.prevent="updatePost">
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
                    <MarkdownEditor v-model="form.content"> </MarkdownEditor>
                    <InputError class="mt-2" :message="form.errors.content" />
                </div>

                <!-- Pulsante di invio -->
                <div class="flex items-center justify-end mt-6">
                    <DangerButton @click="deletePost"> Elimina </DangerButton>

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
import DangerButton from "@/Components/DangerButton.vue";
import { useForm } from "@inertiajs/vue3";
import MarkdownEditor from "@/Components/MarkdownEditor.vue";
import PageHeading from "@/Components/PageHeading.vue";
import { useConfirm } from "@/Utilities/Composables/useConfirm";

const { confirmation } = useConfirm();

const props = defineProps({
    post: Object,
    topics: {
        type: Array,
        default: () => [],
    },
});

// Stato del form
const form = useForm({
    title: props.post.title,
    topic_id: props.post.topic_id,
    content: props.post.content,
});

// Funzione per eliminare il post
const deletePost = async () => {
    if (!(await confirmation("Vuoi eliminare il post?"))) {
        return;
    }

    form.delete(route("posts.destroy", props.post.id));
};

// Funzione per modificare il post
const updatePost = () => {
    form.patch(route("posts.update", props.post.id));
};
</script>
