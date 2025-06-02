// 📄 features/books/table/columns.ts

export const columns = ['ID', 'Title', 'Type', 'Borrowed', 'Actions'];

export const sortableColumns = columns.map(label => ({
  label,
  sortable: label.toLowerCase() !== 'actions'
}));
