// 📄 features/authors/form/emits.ts

import { AuthorFormData } from '../../../types/authors/formData';

export interface AuthorFormEmits {
  (e: 'submit', data: AuthorFormData): void;
}
