<script setup lang="ts">
const props = defineProps<{
    processing?: boolean;
}>();
</script>

<template>
    <button
        class="appearance-none p-2 outline-none text-white bg-blue-600 cursor-pointer hover:bg-blue-700 disabled:bg-gray-600 disabled:hover:bg-gray-700 disabled:cursor-not-allowed transition-colors duration-200 rounded-xl"
        :class="props.processing ? 'cursor-progress bg-blue-700 hover:bg-blue-800' : ''" v-bind="$attrs">
        <slot />
    </button>
</template>
