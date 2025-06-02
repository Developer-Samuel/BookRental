// 📄 models/book.ts

export interface Book {
  id: number;
  title: string;
  type: string;
  is_borrowed: boolean;
}
