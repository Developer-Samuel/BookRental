<!-- 📄 Includes/Header.vue -->

<template>
  <header class="fixed top-0 flex justify-between items-center w-full h-[60px] bg-black text-white px-4 z-[1000]">
    <Link
      href="/authors"
      classes="text-lg font-bold hover:underline"
    >
      Authors
    </Link>
    <button
      @click="logout"
      class=" bg-blue-600 hover:bg-blue-700 rounded-xl text-white text-md font-bold px-4 py-1 transition-linear duration-500 cursor-pointer"
    >
      Log Out
    </button>
  </header>
</template>

<script lang="ts" setup>
import { useLogout } from '../composables/auth/useLogout';
import Link from '@/Components/Common/Link.vue';

const { handleLogout } = useLogout();

const logout = async (): Promise<void> => {
  await handleLogout()
};
</script>
