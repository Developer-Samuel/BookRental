<!-- 📄 Components/Common/Tables/Head/HeadRow.vue -->

<template>
  <tr class="text-md text-gray-700 bg-gray-50 select-none">
    <HeadCol
      v-for="col in columns"
      :key="col.label"
      :label="col.label"
      :sortable="col.sortable"
      :orderBy="orderBy"
      :direction="direction"
      :active="orderBy === col.label.toLowerCase()"
      @sort="$emit('sort', $event)"
    />
  </tr>
</template>

<script setup lang="ts">
import type { Direction } from '../../../../types/core/direction';
import HeadCol from './HeadCol.vue';

defineProps<{
  columns: { label: string, sortable?: boolean }[],
  orderBy: string,
  direction: Direction
}>();
</script>
