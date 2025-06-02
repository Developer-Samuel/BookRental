// 📄 utils/formatGender.ts

export function formatGender(gender: string): string {
  if (!gender) return '';
  return gender.charAt(0).toUpperCase() + gender.slice(1).toLowerCase();
}
