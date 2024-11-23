<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Container from '@/Components/Container.vue';
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="py-4 text-2xl font-bold text-center text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <Container>
                <div class="overflow-hidden bg-white shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </Container>
        </div>
    </AppLayout>
</template>
