<template>
    <ConfirmationModal :show="state.show">
        <template #title>{{ state.title }} </template>

        <template #content> {{ state.message }} </template>

        <template #footer>
            <SecondaryButton ref="cancelButtonRef" @click="cancel"> Annulla </SecondaryButton>
            <PrimaryButton @click="confirm" class="ms-3">Conferma</PrimaryButton>
        </template>
    </ConfirmationModal>
</template>

<script setup>
import ConfirmationModal from "./ConfirmationModal.vue";
import SecondaryButton from "./SecondaryButton.vue";
import PrimaryButton from "./PrimaryButton.vue";
import { useConfirm } from "@/Utilities/Composables/useConfirm";
import { nextTick, ref, watchEffect } from "vue";

const { state, confirm, cancel } = useConfirm();

const cancelButtonRef = ref(null);

watchEffect(async () => {
    if(state.show) {
        await nextTick();
        cancelButtonRef?.value.$el.focus();
    }
})
</script>
