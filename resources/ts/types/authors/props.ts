// 📄 types/authors/props.ts

import type { AuthorFormData } from './formData';
import type { Country } from '../../models/country';

export interface Props {
  author?: Partial<AuthorFormData> | null;
  countries: Country[];
  genders: Record<string, string>;
  submitLabel?: string;
  errors?: Record<string, string>;
}
