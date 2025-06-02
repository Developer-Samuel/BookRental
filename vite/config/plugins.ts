// 📄 vite/config/plugins.ts

import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';
import tailwindcss from '@tailwindcss/vite';

const plugins = [
  laravel({
    input: ['resources/css/app.css', 'resources/ts/app.ts'],
    refresh: true,
  }),
  vue(),
  tailwindcss(),
];

export default plugins;
