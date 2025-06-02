<!-- 📄 Components/Common/Tables/Body/BodyRow.vue -->

<template>
  <tr class="odd:bg-white even:bg-gray-50">
    <BodyCol
      v-for="(col) in columns"
      :key="col.text"
      :class="col.class"
    >
      {{ col.text }}
    </BodyCol>
    <BodyActions :actions="actions" />
  </tr>
</template>

<script setup lang="ts">
import type { Action } from '../../../../types/core/action';
import BodyCol from './Row/BodyCol.vue';
import BodyActions from './Row/BodyActions.vue';

defineProps<{
  columns: { text: string; class?: string }[]
  actions: Action[];
}>();
</script>
