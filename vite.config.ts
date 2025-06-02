// 📄 vite.config.ts

import { defineConfig } from 'vite';
import plugins from './vite/config/plugins';
import resolveConfig from './vite/config/resolve';
import serverConfig from './vite/config/server';

export default defineConfig({
  plugins,
  resolve: resolveConfig,
  server: serverConfig,
});
