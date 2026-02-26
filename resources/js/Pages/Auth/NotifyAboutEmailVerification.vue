<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import AuthTemplate from '../../Components/Klik/AuthTemplate.vue';
import { route } from 'ziggy-js';

</script>

<template>
    <AuthTemplate class="text-center">
        <div>
            <p class="text-2xl mb-30">Please verify your email!</p>

            <Link class="italic cursor-pointer" :href="route('auth.resendVerificationEmail')" method="post">Resend verification
                email</Link>
            <p v-if="usePage().flash['message']"> {{ usePage().flash['message'] }} </p>
        </div>
    </AuthTemplate>
</template>
