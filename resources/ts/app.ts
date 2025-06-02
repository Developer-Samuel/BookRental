// 📄 app.ts

// Importing necessary libraries for Vue and Inertia.js
import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3';

// Dynamically resolves and imports Vue components for Inertia.js routing
import { resolvePage } from './config/resolvePage';

// Import config files
import './config/styles';
import { plugins } from './config/plugins';
import { getLayoutForPage } from './config/layoutConfig';

// Creating the Inertia app
createInertiaApp({
  resolve: async (name: string) => {
    const page = await resolvePage(name);
    page.layout = getLayoutForPage(name);
    return page;
  },
  setup({ el, app, props }) {
    const vueApp = createApp({ render: () => h(app, props) });

    plugins.forEach(({ plugin, options }) => {
      vueApp.use(plugin, options);
    });

    vueApp.mount(el);
  }
});
