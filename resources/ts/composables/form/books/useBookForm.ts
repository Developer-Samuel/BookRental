// 📄 composables/form/books/useBookForm.ts

import { reactive } from 'vue';
import { BookFormData } from '../../../types/books/formData';

export function useBookForm(book: Partial<BookFormData>) {
  const form = reactive<BookFormData>({
    id: book.id ?? null,
    author_id: book.author_id ?? 0,
    title: book.title ?? '',
    type: book.type ?? '',
    is_borrowed: book.is_borrowed ?? 0,
  });

  return form;
}