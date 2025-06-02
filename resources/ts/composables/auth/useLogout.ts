// 📄 composables/auth/useLogout.ts

import { ref } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import { toast } from 'vue3-toastify';
import { handleAxiosFormError } from '../form/useFormErrors';
import axios from 'axios';

export function useLogout() {
  const errors = ref<Record<string, string>>({});

  async function handleLogout(): Promise<void> {
    errors.value = {};

    try {
      await axios.post('/logout');

      Inertia.visit('/login', {
        replace: true,
        onSuccess: () => {
          toast.success('You have been successfully logged out.');
        }
      });
    } catch (error) {
      handleAxiosFormError(error, (formatted) => (errors.value = formatted));
    }
  }

  return {
    handleLogout,
    errors,
  };
}