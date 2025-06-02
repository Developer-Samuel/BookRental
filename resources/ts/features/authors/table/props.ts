// 📄 features/authors/table/props.ts

import type { Direction } from '../../../types/core/direction';
import type { Author } from '../../../models/author';

export interface AuthorTableProps {
  authors: Author[];
  tableClass?: string;
  orderBy?: string;
  direction?: Direction;
}
