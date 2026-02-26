<script setup lang="ts">
import { Form, Link, usePage } from '@inertiajs/vue3';
import Button from '../../Components/Base/Button.vue';
import Input from '../../Components/Base/Input.vue';
import AuthTemplate from '../../Components/Klik/AuthTemplate.vue';
import { route } from 'ziggy-js';

</script>

<template>
    <AuthTemplate>
        <Form class="text-center" :action="route('auth.forgotPassword')" method="post" #default="{ processing }">
            <h1 class="pt-4 text-lg">Forgot password!</h1>
            <Input name="email" type="email" placeholder="Email" required class="mt-5" />
            <p v-if="usePage().props.errors.email" class="mt-1 text-red-400"> {{ usePage().props.errors.email[0] }}</p>
            <Button type="submit" class="mt-5 w-[80%]" :disabled=processing> {{ processing ? "Processing..." : "Send reset password link to email!"
                }}</Button><br /><br />

            <Link class="italic mt-3" :href="route('auth.login')">Log in instead!</Link>
        </Form>
    </AuthTemplate>


</template>
