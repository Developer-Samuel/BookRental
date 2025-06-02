// 📄 utils/formatDate.ts

export function parseDate(str: string): Date {
  const [d, m, y] = str.split('.').map(Number);
  return new Date(y, m - 1, d);
}
