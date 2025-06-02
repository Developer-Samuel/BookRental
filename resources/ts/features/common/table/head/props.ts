// 📄 features/common/table/head/props.ts

import type { Direction } from '../../../../types/core/direction';

export interface HeadTableProps {
  label: string;
  sortable?: boolean;
  active?: boolean;
  orderBy?: string;
  direction?: Direction;
}
