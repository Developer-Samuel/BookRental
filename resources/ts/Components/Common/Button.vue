<!-- 📄 Components/Common/Button.vue -->

<template>
  <button
    :type="type"
    @click="(event) => $emit('click', event)"
    :class="classes"
  >
    <slot>{{ label }}</slot>
  </button>
</template>

<script setup lang="ts">
defineProps({
  label: { type: String, required: false, default: '' },
  classes: { type: String, required: false, default: '' },
  type: { type: String as () => 'button' | 'submit', required: false, default: 'button' },
});
</script>