<!-- 📄 Components/Common/Link.vue -->

<template>
  <a :href="href" :class="classes">
    <slot>{{ label }}</slot>
  </a>
</template>

<script setup lang="ts">
defineProps({
  href: { type: String, required: true },
  label: { type: String, required: false, default: '' },
  classes: { type: String, required: false, default: '' },
});
</script>
