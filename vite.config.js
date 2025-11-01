import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from "@vitejs/plugin-vue";
import {wayfinder} from "@laravel/vite-plugin-wayfinder";

export default defineConfig({
    server: {
        host: true,               // écoute sur 0.0.0.0 dans le conteneur
        port: 5173,
        cors: true,
        hmr: { host: 'localhost', port: 5173 }, // HMR via localhost vu du navigateur
        strictPort: true,
    },
    plugins: [
        vue(),
        wayfinder({
            command: 'docker compose exec -T app php artisan wayfinder:generate --with-form',
        }),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),
    ],
});
