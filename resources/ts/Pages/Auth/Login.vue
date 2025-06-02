<!-- 📄 Pages/Auth/Login.vue -->

<template>
  <div class="bg-blue-600 w-full">
    <div class="flex flex-col items-center justify-center py-8 min-h-screen h-auto lg:py-0 px-4 py-12">
      <div class="w-full bg-white rounded-2xl border border-solid border-gray-300 md:mt-0 md:max-w-xl xl:p-0">
        <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
          <Heading :title="'Log in to your account'" />
          <AuthForm
            @submit="handleCreate"
            :errors="errors"
          />
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { AuthFormData } from '../../types/auth/formData';
import { useStore } from '../../composables/useStore';
import AuthForm from '@/Components/Forms/Auth/AuthForm.vue';
import Heading from '@/Components/Common/Typography/Title.vue';

const { handleCreate, errors } = useStore<AuthFormData>('/login', '/authors');
</script>
