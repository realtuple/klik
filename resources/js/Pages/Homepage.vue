<script setup lang="ts">
    import Button from '@/Components/Base/Button.vue';
    import AppLayout from '@/Components/Klik/AppLayout.vue';
    import { router, usePage } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';

    function logout() {
        router.delete(route('auth.logout'));
    }

    function redirectToProfile() {
        router.get(route('profile.show', usePage().props.current_profile.username));
    }
</script>

<template>
    <AppLayout>
        <h1>Hi!</h1>

        <Button @click="logout" class="m-2">Log out</Button>
        <Button @click="redirectToProfile" class="m-2">Your profile</Button><br />
    </AppLayout>
</template>
