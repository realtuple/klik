import js from '@eslint/js';
import globals from 'globals';
import tseslint from 'typescript-eslint';
import pluginVue from 'eslint-plugin-vue';
import markdown from '@eslint/markdown';
import prettier from 'eslint-config-prettier';
import { defineConfig } from 'eslint/config';

export default defineConfig([
    {
        ignores: ['vendor/**', 'node_modules/**', 'public/**'],
    },
    {
        files: ['**/*.{js,mjs,cjs,ts,mts,cts,vue}'],
        plugins: { js },
        extends: ['js/recommended'],
        languageOptions: { globals: globals.browser },
    },
    tseslint.configs.recommended,
    {
        files: ['**/*.vue'],
        languageOptions: { parserOptions: { parser: tseslint.parser } },
    },
    ...pluginVue.configs['flat/essential'].map((config) => ({
        ...config,
        files: ['**/*.vue'],
    })),
    {
        rules: {
            'vue/multi-word-component-names': 'off',
        },
    },
    {
        files: ['**/*.md'],
        plugins: { markdown },
        language: 'markdown/gfm',
        extends: ['markdown/recommended'],
    },
    prettier,
]);
