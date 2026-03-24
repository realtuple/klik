<script setup lang="ts">
    import { router } from '@inertiajs/vue3';
    import { route } from 'ziggy-js';
    import Logo from '@img/ui/barLogo.svg';
    import { ref } from 'vue';

    const expanded = ref(false);
</script>

<template>
    <div class="flex h-screen">
        <div class="grid grow">
            <div
                class="transition-all bg-gray-900 py-3 z-10 absolute h-full top-0 left-0"
                :class="expanded ? 'w-50' : 'w-12.5'"
                @mouseenter="expanded = true"
                @mouseleave="expanded = false"
            >
                <div class="flex">
                    <div class="pl-2.25 flex items-center">
                        <Logo
                            alt="Logo"
                            class="stroke-black dark:stroke-white cursor-pointer"
                            @click="router.get(route('homepage'))"
                        />
                        <h1
                            v-if="expanded"
                            class="pl-3 cursor-pointer"
                            @click="router.get(route('homepage'))"
                        >
                            Klik
                        </h1>
                    </div>
                </div>
            </div>
            <div class="flex-col-2 flex-row h-full p-2 pl-15">
                <slot v-bind="$attrs" />
            </div>
        </div>
    </div>
</template>
