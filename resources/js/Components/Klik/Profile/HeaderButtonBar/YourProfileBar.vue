<script lang="ts" setup>
    import Button from '@/Components/Base/Button.vue';
    import { router } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';

    function moveToEditProfile() {
        router.get(route('profile.edit'));
    }
</script>

<template>
    <Button class="w-full bg-zinc-600 hover:bg-zinc-700" @click="moveToEditProfile"
        >Edit profile</Button
    >
</template>
