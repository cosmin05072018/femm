import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/js/app.js'],
            refresh: true,
            manifest: true,  // Adaugă această linie pentru a asigura generarea manifestului
        }),
        vue(),
    ],
    build: {
        outDir: 'public/build', // Asigură-te că fișierele de build sunt în directorul corect
        emptyOutDir: true, // Curăță directorul de build înainte de fiecare build
        rollupOptions: {
            output: {
                entryFileNames: 'assets/[name]-[hash].js',
                chunkFileNames: 'assets/[name]-[hash].js',
                assetFileNames: 'assets/[name]-[hash][extname]',
            },
        },
    },
});
