import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import { bunny } from 'laravel-vite-plugin/fonts';
import tailwindcss from '@tailwindcss/vite';

export default defineConfig({
    plugins: [
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/css/auth-login-v1.css',
                'resources/js/pages/LoginPage.js',
                'resources/css/auth-register.css',
                'resources/js/pages/RegisterPage.js',
                'resources/css/auth-forgot-password.css',
                'resources/js/pages/ForgotPasswordPage.js',
                'resources/js/pages/input-pagination-test.js',
                'resources/js/pages/offcanvas-demo.js',
            ],
            refresh: true,
            fonts: [
                bunny('Instrument Sans', {
                    weights: [400, 500, 600],
                }),
            ],
        }),
        tailwindcss(),
    ],
    server: {
        watch: {
            ignored: ['**/storage/framework/views/**'],
        },
    },
});
