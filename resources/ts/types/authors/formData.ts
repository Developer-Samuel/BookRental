// 📄 types/authors/formData.ts

export interface AuthorFormData {
  id: number | null;
  country_id: number | string;
  name: string;
  surname: string;
  gender?: string;
  birth_date?: string;
}
