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
                <div>
                    <InputLabel for="title" value="Title" class="sr-only" />
                    <TextInput
                        id="title"
                        v-model="form.title"
                        placeholder="Title"
                        type="text"
                        class="block w-full mt-1"
                        required
                        autofocus
                        autocomplete="title"
                    />
                    <InputError class="mt-2" :message="form.errors.title" />
                </div>

                <div class="mt-4">
                    <InputLabel for="content" value="Content" class="sr-only" />
                    <TextArea
                        id="content"
                        v-model="form.content"
                        placeholder="Content"
                        class="block w-full mt-1"
                        required
                        autocomplete="content"
                    ></TextArea>
                    <InputError class="mt-2" :message="form.errors.content" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton
                        type="submit"
                        class="ml-4"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                    >
                        Save
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
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { useForm } from "@inertiajs/vue3";

const form = useForm({
    title: "",
    content: "",
});

const createPost = () => {
    form.post(route("posts.store"));
};
</script>
