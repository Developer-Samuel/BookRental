// config/resolvePage.ts

import type { DefineComponent } from 'vue';

const pages = import.meta.glob<{ default: DefineComponent }>('../Pages/**/*.vue');

export async function resolvePage(name: string) {
  const path = Object.keys(pages).find(path => path.endsWith(`${name}.vue`));

  if (!path) {
    throw new Error(`Page not found: ${name}`);
  }

  const module = await pages[path]() as { default: DefineComponent };
  return module.default;
}
