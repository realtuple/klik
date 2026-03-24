<script setup lang="ts">
    import { Form, Link, usePage } from '@inertiajs/vue3';
    import Button from '../../Components/Base/Button.vue';
    import Input from '../../Components/Base/Input.vue';
    import AuthTemplate from '../../Components/Klik/AuthTemplate.vue';
    import { route } from 'ziggy-js';
</script>

<template>
    <AuthTemplate>
        <Form
            class="text-center"
            :action="route('auth.createAccount')"
            method="post"
            #default="{ processing }"
        >
            <h1 class="pt-4 text-lg">Register in Klik:</h1>
            <Input
                name="display_name"
                type="text"
                placeholder="Display name"
                required
                class="mt-5"
            />
            <p v-if="usePage().props.errors.display_name" class="mt-1 text-red-400">
                {{ usePage().props.errors.display_name[0] }}
            </p>
            <Input name="username" type="text" placeholder="Username" required class="mt-2" />
            <p v-if="usePage().props.errors.username" class="mt-1 text-red-400">
                {{ usePage().props.errors.username[0] }}
            </p>
            <Input name="email" type="email" placeholder="Email" required class="mt-2" />
            <p v-if="usePage().props.errors.email" class="mt-1 text-red-400">
                {{ usePage().props.errors.email[0] }}
            </p>
            <Input
                name="password"
                type="password"
                placeholder="Password"
                minlength="8"
                class="mt-2"
                required
            />
            <p v-if="usePage().props.errors.password" class="mt-1 text-red-400">
                {{ usePage().props.errors.password[0] }}
            </p>
            <Input
                name="password_confirmation"
                type="password"
                placeholder="Repeat Password"
                minlength="8"
                class="mt-2"
                required
            />
            <p v-if="usePage().props.errors.password_confirmation" class="mt-1 text-red-400">
                {{ usePage().props.errors.password_confirmation[0] }}
            </p>
            <Input name="date" type="date" placeholder="Date of birth" required class="mt-2" />
            <p v-if="usePage().props.errors.date" class="mt-1 text-red-400">
                {{ usePage().props.errors.date }}
            </p>
            <Button type="submit" class="mt-5 w-[80%]" :processing="processing">{{
                processing ? 'Processing...' : 'Register account'
            }}</Button
            ><br /><br />

            <Link class="italic mt-3" :href="route('auth.login')">Log in instead!</Link>
        </Form>
    </AuthTemplate>
</template>
