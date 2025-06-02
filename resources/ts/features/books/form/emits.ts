// 📄 features/books/form/emits.ts

import { BookFormData } from '../../../types/books/formData';

export interface BookFormEmits {
    (e: 'submit', data: BookFormData): void;
}