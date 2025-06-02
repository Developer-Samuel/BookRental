// 📄 composables/table/authors/useSortAuthors.ts

import { useSorting } from '../useSorting';
import { parseDate } from '../../../utils/formatDate';
import type { Author } from '../../../models/author';

function authorSortFn(a: Author, b: Author, orderBy: string): number {
  let valA: any = '';
  let valB: any = '';

  switch (orderBy) {
    case 'id':
      valA = a.id;
      valB = b.id;
      break;
    case 'name':
      valA = (a.name + ' ' + a.surname).toLowerCase();
      valB = (b.name + ' ' + b.surname).toLowerCase();
      break;
    case 'nationality':
      valA = a.country?.name?.toLowerCase() || '';
      valB = b.country?.name?.toLowerCase() || '';
      break;
    case 'gender':
      valA = a.gender.toLowerCase();
      valB = b.gender.toLowerCase();
      break;
    case 'birth date':
      valA = parseDate(a.birth_date || '');
      valB = parseDate(b.birth_date || '');
      break;
    default:
      return 0;
  }

  if (valA < valB) return -1;
  if (valA > valB) return 1;
  return 0;
}

export function useSortAuthors(initialAuthors: Author[]) {
  const { items: authors, orderBy, direction, onSort, setItems: setAuthors } =
    useSorting<Author>(initialAuthors, 'id', authorSortFn);

  return {
    authors,
    orderBy,
    direction,
    onSort,
    setAuthors,
  };
}