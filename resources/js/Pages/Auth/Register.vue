<script setup>
import { ref } from "vue";
import { Head, Link, useForm } from "@inertiajs/vue3";
import AuthenticationCard from "@/Components/AuthenticationCard.vue";
import AuthenticationCardLogo from "@/Components/AuthenticationCardLogo.vue";
import Checkbox from "@/Components/Checkbox.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import TextInput from "@/Components/TextInput.vue";
import AppLayout from "@/Layouts/AppLayout.vue";

const form = useForm({
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
    terms: false,
});

// Stati per la visibilità delle password
const showPassword = ref(false);
const showConfirmPassword = ref(false);

// Funzioni per alternare la visibilità delle password
const togglePasswordVisibility = () => {
    showPassword.value = !showPassword.value;
};

const toggleConfirmPasswordVisibility = () => {
    showConfirmPassword.value = !showConfirmPassword.value;
};

// Submit del form
const submit = () => {
    form.post(route("register"), {
        onFinish: () => form.reset("password", "password_confirmation"),
    });
};
</script>

<template>
    <AppLayout title="Register">
        <AuthenticationCard>
            <template #logo>
                <AuthenticationCardLogo />
            </template>

            <form @submit.prevent="submit">
                <div>
                    <InputLabel for="name" value="Name" />
                    <TextInput
                        id="name"
                        v-model="form.name"
                        type="text"
                        class="block w-full mt-1"
                        required
                        autofocus
                        autocomplete="name"
                    />
                    <InputError class="mt-2" :message="form.errors.name" />
                </div>

                <div class="relative mt-4">
                    <InputLabel for="email" value="Email" />
                    <TextInput
                        id="email"
                        v-model="form.email"
                        type="email"
                        class="block w-full mt-1"
                        required
                        autocomplete="username"
                    />
                    <InputError class="mt-2" :message="form.errors.email" />
                </div>

                <div class="relative mt-4">
                    <InputLabel for="password" value="Password" />
                    <TextInput
                        id="password"
                        v-model="form.password"
                        :type="showPassword ? 'text' : 'password'"
                        class="block w-full mt-1"
                        required
                        autocomplete="new-password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 text-gray-500 right-3 focus:outline-none"
                        @click="togglePasswordVisibility"
                    >
                        <svg
                            v-if="showPassword"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M13.875 18.825a6.876 6.876 0 01-8.85-8.85M9 5c2.7 0 5.247 1.2 7.5 3.45C19.8 10.8 21 13.35 21 16"
                            />
                            <path d="M3 3l18 18" />
                        </svg>
                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M1 12s4.5-7.5 11-7.5 11 7.5 11 7.5-4.5 7.5-11 7.5S1 12 1 12z"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                    <InputError class="mt-2" :message="form.errors.password" />
                </div>

                <div class="relative mt-4">
                    <InputLabel
                        for="password_confirmation"
                        value="Confirm Password"
                    />
                    <TextInput
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        :type="showConfirmPassword ? 'text' : 'password'"
                        class="block w-full mt-1"
                        required
                        autocomplete="new-password"
                    />
                    <button
                        type="button"
                        class="absolute inset-y-0 text-gray-500 right-3 focus:outline-none"
                        @click="toggleConfirmPasswordVisibility"
                    >
                        <svg
                            v-if="showConfirmPassword"
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M13.875 18.825a6.876 6.876 0 01-8.85-8.85M9 5c2.7 0 5.247 1.2 7.5 3.45C19.8 10.8 21 13.35 21 16"
                            />
                            <path d="M3 3l18 18" />
                        </svg>
                        <svg
                            v-else
                            xmlns="http://www.w3.org/2000/svg"
                            class="w-5 h-5"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                        >
                            <path
                                d="M1 12s4.5-7.5 11-7.5 11 7.5 11 7.5-4.5 7.5-11 7.5S1 12 1 12z"
                            />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                    <InputError
                        class="mt-2"
                        :message="form.errors.password_confirmation"
                    />
                </div>

                <div
                    v-if="$page.props.jetstream.hasTermsAndPrivacyPolicyFeature"
                    class="mt-4"
                >
                    <InputLabel for="terms">
                        <div class="flex items-center">
                            <Checkbox
                                id="terms"
                                v-model:checked="form.terms"
                                name="terms"
                                required
                            />
                            <div class="ms-2">
                                I agree to the
                                <Link
                                    href="route('terms.show')"
                                    class="text-sm underline"
                                >
                                    Terms of Service
                                </Link>
                                and
                                <Link
                                    href="route('policy.show')"
                                    class="text-sm underline"
                                >
                                    Privacy Policy
                                </Link>
                            </div>
                        </div>
                    </InputLabel>
                    <InputError class="mt-2" :message="form.errors.terms" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <Link
                        :href="route('login')"
                        class="text-sm text-gray-600 underline rounded-md hover:text-gray-900 focus:outline-none"
                    >
                        Already registered?
                    </Link>
                    <PrimaryButton class="ms-4" :disabled="form.processing">
                        Register
                    </PrimaryButton>
                </div>
            </form>
        </AuthenticationCard>
    </AppLayout>
</template>
