import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';
import path from 'node:path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/react-entries/about-hero.jsx',
                'resources/js/lanyard-entry.jsx',
                'resources/js/creator-lanyard-entry.jsx',
            ],
            refresh: true,
        }),
        react(),
    ],

    resolve: {
        alias: {
            '@': path.resolve(import.meta.dirname, 'resources/js'),
        },
    },

    assetsInclude: ['**/*.glb'],
});