// 📄 composables/useStore.ts

import { ref } from 'vue';
import { toast } from 'vue3-toastify';
import { Inertia } from '@inertiajs/inertia';
import { handleAxiosFormError } from './form/useFormErrors';
import axios from 'axios';

export function useStore<T>(endpoint: string, redirectUrl: string) {
  const errors = ref<Record<string, string>>({});

  async function handleCreate(data: T): Promise<void> {
    errors.value = {};

    try {
      const response = await axios.post(endpoint, data);

      Inertia.visit(redirectUrl, {
        preserveState: true,
        onSuccess: () => {
          toast.success(response.data.message);
        },
      });
    } catch (error) {
      handleAxiosFormError(error, (formatted) => (errors.value = formatted));
    }
  }

  return {
    handleCreate,
    errors,
  };
}