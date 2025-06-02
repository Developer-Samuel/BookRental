// 📄 types/core/action.ts

export type Action = {
  type: 'link' | 'button';
  label: string;
  href?: string;
  onClick?: () => void;
  classes?: string;
};
