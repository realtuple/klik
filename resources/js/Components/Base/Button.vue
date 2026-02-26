<template>
    <button
        class="appearance-none
            p-2
            outline-none
            text-white
            bg-blue-600
            hover:bg-blue-700
            disabled:bg-gray-600
            disabled:hover:bg-gray-700
            transition-colors duration-200
            rounded-xl"
        v-bind="$attrs"><slot /></button>
</template>
