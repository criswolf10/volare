import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
            ],
            refresh: true,
        }),
    ],
    server: {
        host: true,  // Permitir conexiones desde la red local
        hmr: {
            host: '192.168.100.62',// Cambia esto a tu IP local para permitir conexiones desde la red local
        },
    },
});
