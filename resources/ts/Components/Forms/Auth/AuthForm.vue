<!-- 📄 Components/Forms/Auth/AuthForm.vue -->

<template>
  <form @submit.prevent="submitForm" class="space-y-4 md:space-y-6 text-black">
    <div class="w-full">
      <FormLabel
        id="email"
        label="Email:"
        class="block mb-2 text-sm font-medium"
      />
      <FormInput
        v-model="form.email"
        id="email"
        placeholder="email@example.com"
        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 outline-0"
      />
      <div
        v-if="internalErrors.email"
        class="error text-red-600 font-semibold mt-1"
      >
        {{ internalErrors.email }}
      </div>
    </div>
    <div class="w-full">
      <FormLabel
        id="password"
        label="Password:"
        class="block mb-2 text-sm font-medium"
      />
      <FormInput
        v-model="form.password"
        type="password"
        id="password"
        placeholder="********"
        class="bg-gray-50 border border-gray-300 text-gray-900 rounded-lg focus:ring-blue-600 focus:border-blue-600 block w-full p-2.5 outline-0"
      />
      <div
        v-if="internalErrors.password"
        class="error text-red-600 font-semibold mt-1"
      >
        {{ internalErrors.password }}
      </div>
    </div>

    <FormButton
      type="submit"
      label="Log in"
      classes="w-full text-white bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center mt-4 transition-linear duration-500 cursor-pointer"
    />
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { reactive } from 'vue';
import type { AuthFormEmits } from '../../../features/auth/form/emits';
import type { AuthFormData } from '../../../types/auth/formData';
import type { Props } from '../../../types/auth/props';
import { useSubmitForm } from '../../../composables/form/useSubmitForm';
import { useValidationWatcher } from '../../../composables/form/useValidationWatcher';
import FormLabel from '@/Components/Common/Forms/Label.vue';
import FormInput from '@/Components/Common/Forms/Input.vue';
import FormButton from '@/Components/Common/Button.vue';

const props = defineProps<Props>();
const emit = defineEmits<AuthFormEmits>();

const form = reactive<AuthFormData>({
  email: '',
  password: '',
});

const { internalErrors } = useValidationWatcher<AuthFormData>(() => props.errors);

const isSubmitting = ref(false);

function submitForm(event: Event) {
  useSubmitForm<AuthFormData>(
    event,
    internalErrors,
    form,
    (data: AuthFormData) => emit('submit', data),
    isSubmitting
  );
}
</script>
