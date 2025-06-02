// 📄 features/authors/table/columns.ts

export const columns = ['ID', 'Name', 'Nationality', 'Gender', 'Birth Date', 'Actions'];

export const sortableColumns = columns.map(label => ({
  label,
  sortable: label.toLowerCase() !== 'actions'
}));
