// 📄 utils/formatBookType.ts

export function formatBookType(type: string): string {
  const formatted = type.replace(/-/g, ' ');
  return formatted.charAt(0).toUpperCase() + formatted.slice(1).toLowerCase();
}
