// 📄 composables/form/useFormErrors.ts

import { AxiosError } from 'axios';
import { toast } from 'vue3-toastify';

export function handleAxiosFormError(
  error: unknown,
  setErrors: (errors: Record<string, string>) => void
): void {
  const axiosError = error as AxiosError<{ errors?: Record<string, string[]>; message?: string }>;
  const response = axiosError.response;

  if (response?.status === 422) {
    const responseErrors = response.data.errors;

    if (responseErrors) {
      const formattedErrors: Record<string, string> = {};
      for (const key in responseErrors) {
        formattedErrors[key] = responseErrors[key][0];
      }
      setErrors(formattedErrors);
    } else {
      const message = response.data?.message || 'Validation error.';
      toast.error(message);
    }
  } else {
    const message = response?.data?.message || 'Error occurred.';
    toast.error(message);
  }
}