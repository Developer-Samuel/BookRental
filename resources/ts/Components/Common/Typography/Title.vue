<!-- 📄 Components/Common/Typography/Title.vue -->

<template>
  <div :class="['text-2xl font-bold', customClass]">
    {{ title }}
  </div>
</template>

<script setup lang="ts">
defineProps({
  title: {
    type: String,
    required: true,
  },
  customClass: {
    type: String,
    required: false,
    default: '',
  },
});
</script>
