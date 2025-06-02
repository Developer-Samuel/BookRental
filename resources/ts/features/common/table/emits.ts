// 📄 features/common/table/emits.ts

import type { Direction } from '../../../types/core/direction';

export interface TableEmits {
  (e: 'delete', id: number): void;
  (e: 'sort', payload: {
    orderBy: string;
    direction: Direction
  }): void;
}
