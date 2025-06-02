<!-- 📄 Layout/App.vue -->

<template>
  <HeaderComponent />
  <main class="relative top-[60px] flex justify-center w-full min-h-[calc(100%-60px)] h-auto py-4">
    <div class="2xl:w-[1300px] w-full p-4">
      <slot></slot>
    </div>
  </main>
</template>

<script setup lang="ts">
import HeaderComponent from '@/Includes/Header.vue';
</script>