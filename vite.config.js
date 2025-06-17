import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import path from 'path';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/librairies/fontawesome-free-6.1.1-web/css/all.min.css',
                'resources/css/app.css', 
                'resources/css/global.css', 
                'resources/js/app.js',
                'resources/css/responsive.css',
                'resources/css/plugins.min.css',
                'resources/css/kaiadmin.min.css',
                'resources/css/demo.css',
                'resources/css/login.css',
                'resources/css/sidebar.css',
                'resources/librairies/setting-demo.js',
            ],
            refresh: true,
        }),
    ],
    resolve: {
        alias: {
            '~bootstrap' : path.resolve(__dirname, 'node_modules/bootstrap'),
            '~aos' : path.resolve(__dirname, 'node_modules/aos'),
            '~jquery' : path.resolve(__dirname, 'node_modules/jquery'),
        }
    }
});
