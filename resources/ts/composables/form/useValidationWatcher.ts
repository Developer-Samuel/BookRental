// 📄 composables/form/useValidationWatcher.ts

import { watch, ref } from 'vue';

export function useValidationWatcher<T extends Record<string, any>>(
  propsErrors: () => Partial<Record<keyof T, string>> | undefined
) {
  const internalErrors = ref<Partial<Record<keyof T, string>>>({});

  watch(
    propsErrors,
    (newErrors) => {
      if (newErrors) {
        internalErrors.value = { ...newErrors };
      } else {
        internalErrors.value = {};
      }
    },
    { immediate: true }
  );

  function clearErrors() {
    internalErrors.value = {};
  }

  return { internalErrors, clearErrors };
}