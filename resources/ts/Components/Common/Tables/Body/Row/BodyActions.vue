<!-- 📄 Components/Common/Tables/Body/Row/BodyActions.vue -->

<template>
  <td class="text-right px-6 py-4">
    <div class="flex justify-end items-center gap-2 text-white">
      <ActionItem
        v-for="(action) in actions"
        :key="action.label"
        :action="action"
        @click="action.onClick"
      />
    </div>
  </td>
</template>

<script setup lang="ts">
import type { Action } from '../../../../../types/core/action';
import ActionItem from './Actions/ActionItem.vue';

defineProps<{
  actions: Action[];
}>();
</script>
