<script setup lang="ts">
import Button from '@/Components/Base/Button.vue';
import { router } from '@inertiajs/vue3';
import { route } from 'ziggy-js';

function logout() {
    router.delete(route('auth.logout'));
}
</script>

<template>
    <h1>Hi!</h1>

    <Button @click="logout" class="m-2">Log out</Button><br />

</template>
