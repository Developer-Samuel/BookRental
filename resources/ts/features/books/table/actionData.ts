// 📄 features/books/table/actionData.ts

import { Book } from '../../../models/book';
import { Action } from '../../../types/core/action';

export const getActionData = (book: Book, onDelete: (id: number) => void): Action[] => [
  {
    type: 'link',
    label: 'Edit',
    href: `/books/edit/${book.id}`,
    classes: 'bg-blue-600 hover:bg-blue-700',
  },
  {
    type: 'button',
    label: 'Delete',
    onClick: () => onDelete(book.id),
    classes: 'bg-red-600 hover:bg-red-700 cursor-pointer',
  },
];
