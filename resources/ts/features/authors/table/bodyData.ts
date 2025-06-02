// 📄 features/authors/table/bodyData.ts

import type { Author } from '../../../models/author';
import { formatGender } from '../../../utils/formatGender';

export const getBodyData = (author: Author): { text: string; class?: string }[] => [
  { text: String(author.id) },
  { text: `${author.name} ${author.surname}` },
  { text: author.country ? author.country.nationality : '' },
  { text: formatGender(author.gender) },
  { text: author.birth_date ?? '' },
];
