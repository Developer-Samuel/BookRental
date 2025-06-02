// 📄 features/books/table/props.ts

import type { Direction } from '../../../types/core/direction';
import type { Book } from '../../../models/book';

export interface BookTableProps {
  books: Book[];
  tableClass?: string;
  orderBy?: string;
  direction?: Direction;
}
