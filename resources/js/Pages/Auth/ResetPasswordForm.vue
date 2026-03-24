<script setup lang="ts">
    import { Form, usePage } from '@inertiajs/vue3';
    import Button from '@/Components/Base/Button.vue';
    import Input from '@/Components/Base/Input.vue';
    import AuthTemplate from '@/Components/Klik/AuthTemplate.vue';
    import { route } from 'ziggy-js';
</script>

<template>
    <AuthTemplate>
        <div
            class="flex-col-2 dark:bg-gray-900 flex-row px-1 break-after-column bg-cover h-full border-l-3 border-gray-200 dark:border-gray-700 grid items-center"
        >
            <Form
                class="text-center"
                :action="route('auth.resetPassword')"
                method="post"
                #default="{ processing }"
            >
                <h1 class="pt-4 text-lg">Log in to Klik:</h1>
                <input type="hidden" name="token" :value="usePage().props['token']" />
                <Input name="email" type="email" placeholder="Email" required class="mt-5" />
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
                    {{ usePage().props.errors.password[0] }}
                </p>
                <Button type="submit" class="mt-5 w-[80%]" :processing="processing">
                    {{ processing ? 'Processing...' : 'Log in' }}</Button
                ><br /><br />
            </Form>
        </div>
    </AuthTemplate>
</template>
