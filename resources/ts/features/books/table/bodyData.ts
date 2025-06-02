// 📄 features/books/table/bodyData.ts

import { Book } from '../../../models/book';
import { formatBookType } from '../../../utils/formatBookType';

export const getBodyData = (book: Book): { text: string; class?: string }[] => [
  { text: String(book.id) },
  { text: book.title },
  { text: formatBookType(book.type) },
  {
    text: book.is_borrowed ? 'Borrowed' : 'Available',
    class: `font-bold ${book.is_borrowed ? 'text-red-600' : 'text-green-600'}`,
  },
];