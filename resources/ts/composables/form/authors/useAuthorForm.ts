// 📄 composables/form/authors/useAuthorForm.ts

import { reactive } from 'vue';
import { AuthorFormData } from '../../../types/authors/formData';

export function useAuthorForm(author: Partial<AuthorFormData> | null = null) {
  const form = reactive<AuthorFormData>({
    id: author?.id ?? null,
    country_id: author?.country_id ?? '',
    name: author?.name ?? '',
    surname: author?.surname ?? '',
    gender: author?.gender ?? 'male',
    birth_date: author?.birth_date ?? ''
  });

  return form;
}