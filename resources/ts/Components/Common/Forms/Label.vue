<!-- 📄 Components/Common/Forms/Label.vue -->

<template>
  <label :for="id" :class="customClass">
    {{ label }}
  </label>
</template>

<script setup lang="ts">
defineProps({
  id: {
    type: String,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
  customClass: {
    type: String,
    default: 'block font-medium mb-1',
  },
});
</script>
