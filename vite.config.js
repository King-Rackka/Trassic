import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import react from '@vitejs/plugin-react';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/js/react-entries/about-hero.jsx',
                'resources/js/lanyard-entry.jsx', // ← entry baru khusus React island
            ],
            refresh: true,
        }),
        react(),
    ],
    assetsInclude: ['**/*.glb'],
});