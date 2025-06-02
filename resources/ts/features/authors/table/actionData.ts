// 📄 features/authors/table/actionData.ts

import type { Author } from '../../../models/author';
import type { Action } from '../../../types/core/action';

export const getActionData = (author: Author, onDelete: (id: number) => void): Action[] => [
  {
    type: 'link',
    label: `Books (${author.books_count ?? 0})`,
    href: `/books/${author.id}`,
    classes: 'bg-cyan-400 text-black hover:bg-cyan-500',
  },
  {
    type: 'link',
    label: 'Edit',
    href: `/authors/edit/${author.id}`,
    classes: 'bg-blue-600 hover:bg-blue-700',
  },
  {
    type: 'button',
    label: 'Delete',
    onClick: () => onDelete(author.id),
    classes: 'bg-red-600 hover:bg-red-700 cursor-pointer',
  },
];
