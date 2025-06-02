<!-- 📄 Components/Common/Tables/Body/Row/Actions/ActionItem.vue -->
<template>
  <ActionLink
    v-if="action.type === 'link'"
    :href="action.href"
    :label="action.label"
    :classes="computedClasses"
  />
  <ActionButton
    v-else-if="action.type === 'button'"
    @click="$emit('click')"
    :label="action.label"
    :classes="computedClasses"
  />
</template>

<script setup lang="ts">
import { computed } from 'vue';
import type { Action } from '../../../../../../types/core/action';
import ActionLink from '@/Components/Common/Link.vue';
import ActionButton from '@/Components/Common/Button.vue';

const props = defineProps<{
  action: Action
}>();

const computedClasses = computed(() =>
  `text-sm font-medium rounded-xl px-3 py-1 transition-linear duration-500 ${props.action.classes || ''}`
);
</script>
