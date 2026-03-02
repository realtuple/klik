import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import tailwindcss from '@tailwindcss/vite';
import vue from '@vitejs/plugin-vue';
import { fileURLToPath, URL } from 'node:url';
import svgLoader from 'vite-svg-loader';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
        tailwindcss(),
        vue(),
        svgLoader(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
    resolve: {
        alias: {
            '@': fileURLToPath(new URL('./resources/js', import.meta.url)),
            '@img': fileURLToPath(new URL('./resources/images', import.meta.url)),
        },
    },
});
