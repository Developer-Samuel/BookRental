// 📄 models/author.ts

import type { Country } from './country';

export interface Author {
  id: number;
  name: string;
  surname: string;
  country: Country | null;
  gender: string;
  birth_date?: string | null;
  books_count?: number;
}