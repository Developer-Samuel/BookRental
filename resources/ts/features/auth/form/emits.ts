// 📄 features/auth/form/emits.ts

import { AuthFormData } from '../../../types/auth/formData';

export interface AuthFormEmits {
  (e: 'submit', data: AuthFormData): void;
}