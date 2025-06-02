<!-- 📄 Components/Common/Tables/Head/HeadCol.vue -->
<template>
  <th
    @click="emitSort"
    :class="[colClass, 'px-6 py-3']"
  >
    {{ label }}
    <div v-if="sortable" class="inline-block text-xs ml-2">
      <span :class="[ascClass, 'relative bottom-[1px]']">
        &#9650;
      </span>
      <span :class="[descClass, 'relative bottom-[1px]']">
        &#9660;
      </span>
    </div>
  </th>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Direction } from '../../../../types/core/direction';
import type { HeadTableProps } from '../../../../features/common/table/head/props';

const props = defineProps<HeadTableProps>();

const colClass = props.label.toLowerCase() === 'actions' ? 'text-right' : 'cursor-pointer';

const emit = defineEmits(['sort']);

const emitSort = () => {
  if (!props.sortable || props.label.toLowerCase() === 'actions') return;

  let newDirection: Direction = 'asc';
  if (props.orderBy === props.label.toLowerCase() && props.direction === 'asc') {
    newDirection = 'desc';
  }

  emit('sort', {
    orderBy: props.label.toLowerCase(),
    direction: newDirection
  });
};

const ascClass = computed(() => {
  return [
    'text-xs',
    props.active && props.direction === 'asc' ? 'text-blue-600' : 'text-gray-400',
  ];
});

const descClass = computed(() => {
  return [
    'text-xs',
    props.active && props.direction === 'desc' ? 'text-blue-600' : 'text-gray-400',
  ];
});
</script>
