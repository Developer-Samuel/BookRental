// 📄 types/books/formData.ts

export interface BookFormData {
  id: number | null;
  author_id: number | null;
  title: string;
  type: string;
  is_borrowed: number;
}
