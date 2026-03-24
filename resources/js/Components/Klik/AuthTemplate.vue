<script setup lang="ts"></script>

<template>
    <div class="flex flex-col h-screen">
        <div class="grid grid-cols-[0_auto] md:grid-cols-[auto_525px] grow flex-row">
            <div class="break-after-column text-center py-3 flex-row">
                <h1 class="text-xl">One <span class="font-bold">klik</span> from:</h1>
                <h1>Open source social media for sharing your creativity and moments</h1>
            </div>
            <div
                class="flex-col-2 dark:bg-gray-900 flex-row px-1 break-after-column bg-cover h-full border-l-3 border-gray-200 dark:border-gray-700 grid items-center"
            >
                <slot v-bind="$attrs" />
            </div>
        </div>
        <div class="border-t-[.2px] border-gray-200 dark:border-gray-700 shrink">
            <h1 class="text-[80%] dark:text-neutral-400 text-center">
                Klik - Karol Gocłowski &copy;
            </h1>
        </div>
    </div>
</template>
