// 📄 composables/table/books/useSortBooks.ts

import { useSorting } from '../useSorting';
import type { Book } from '../../../models/book';

function bookSortFn(a: Book, b: Book, orderBy: string): number {
  let valA: any = '';
  let valB: any = '';

  switch (orderBy) {
    case 'id':
      valA = a.id;
      valB = b.id;
      break;
    case 'title':
      valA = a.title.toLowerCase();
      valB = b.title.toLowerCase();
      break;
    case 'type':
      valA = a.type.toLowerCase();
      valB = b.type.toLowerCase();
      break;
    case 'borrowed':
      valA = a.is_borrowed ? 1 : 0;
      valB = b.is_borrowed ? 1 : 0;
      break;
    default:
      return 0;
  }

  if (valA < valB) return -1;
  if (valA > valB) return 1;
  return 0;
}

export function useSortBooks(initialBooks: Book[]) {
  const { items: books, orderBy, direction, onSort, setItems: setBooks } =
    useSorting<Book>(initialBooks, 'id', bookSortFn);

  return {
    books,
    orderBy,
    direction,
    onSort,
    setBooks,
  };
}