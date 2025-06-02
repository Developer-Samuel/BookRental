// 📄 types/books/props.ts

import type { BookFormData } from './formData';
import type { TypeOption } from '../core/typeOptions';
import type { BorrowStatuses } from './borrowStatuses';

export interface Props {
  book?: Partial<BookFormData> | null;
  authorId?: number | null;
  types: TypeOption[];
  borrowStatuses: BorrowStatuses[];
  submitLabel?: string;
  errors?: Record<string, string>;
}
