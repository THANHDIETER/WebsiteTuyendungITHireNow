import { defineConfig } from 'vite'
import vue from '@vitejs/plugin-vue'
import laravel from 'laravel-vite-plugin'
import path from 'path'

export default defineConfig({
    resolve: {
        alias: {
            vue: 'vue/dist/vue.esm-bundler.js', // ✅ FIX lỗi template runtime
            '@': path.resolve(__dirname, 'resources/js'), // ✅ Optional: dùng @ để import nhanh
        },
    },
    plugins: [
        laravel({
            input: [
                'resources/js/app.js',
                'resources/sass/app.scss', // hoặc app.css nếu không dùng SCSS
            ],
            refresh: true,
        }),
        vue(),
    ],
})