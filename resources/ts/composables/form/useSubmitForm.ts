// 📄 composables/form/useSubmitForm.ts

import { Ref } from 'vue';

export function useSubmitForm<T>(
  event: Event,
  internalErrors: Ref<Partial<Record<keyof T, string | undefined>>>,
  formData: T,
  emitSubmit: (data: T) => void,
  isSubmitting: Ref<boolean>,
 callback?: () => void
): void {
  event.preventDefault();

  if (isSubmitting.value) return;

  isSubmitting.value = true;

  for (const key in internalErrors.value) {
    delete internalErrors.value[key];
  }

  emitSubmit({ ...formData });

  setTimeout(() => {
    isSubmitting.value = false;
    if (callback) callback();
  }, 1000);
}