// 📄 composables/table/useSorting.ts

import { ref } from 'vue';
import type { Direction } from '../../types/core/direction';

export function useSorting<T>(
  initialItems: T[],
  defaultOrderBy: string,
  sortFn: (a: T, b: T, orderBy: string) => number
) {
  const items = ref<T[]>([...initialItems]);
  const orderBy = ref<string>(defaultOrderBy);
  const direction = ref<Direction>('asc');

  items.value.sort((a, b) => {
    const res = sortFn(a as T, b as T, orderBy.value);
    return direction.value === 'asc' ? res : -res;
  });

  const onSort = (payload: { orderBy: string; direction: Direction }) => {
    orderBy.value = payload.orderBy;
    direction.value = payload.direction;

    items.value.sort((a, b) => {
      const res = sortFn(a as T, b as T, orderBy.value);
      return direction.value === 'asc' ? res : -res;
    });
  };

  const setItems = (newItems: T[]) => {
    items.value = [...newItems];
  };

  return {
    items,
    orderBy,
    direction,
    onSort,
    setItems,
  };
}
