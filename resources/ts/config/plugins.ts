// 📄 config/plugins.ts

import Toast from "vue3-toastify";
import { toastOptions } from './toastOptions';

export const plugins = [
  { plugin: Toast, options: toastOptions },
];