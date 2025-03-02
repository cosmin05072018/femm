import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
        }),
        vue(),
    ],
    build: {
        manifest: true, // Adaugă această linie pentru a activa generarea manifestului
        outDir: 'public/build', // Asigură-te că fișierele de build sunt salvate în directorul corect
    }
});
