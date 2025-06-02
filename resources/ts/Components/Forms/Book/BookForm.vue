<!-- 📄 Components/Forms/Book/BookForm.vue -->

<template>
  <form @submit.prevent="submitForm" class="flex flex-col gap-6 p-8">
    <div class="flex flex-col gap-4">
      <div class="w-full">
        <FormLabel
          id="title"
          label="Title:"
        />
        <FormInput
          v-model="form.title"
          id="title"
        />
        <div
          v-if="internalErrors.title"
          class="error text-red-600 font-semibold mt-1"
        >
          {{ internalErrors.title }}
        </div>
      </div>
      <div class="flex md:flex-row flex-col gap-4">
        <div class="w-full">
          <FormLabel
            id="type"
            label="Type:"
          />
          <FormSelect
            v-model="form.type"
            id="type"
            :options="types"
            optionLabelKey="name"
            optionValueKey="value"
            placeholder="Select a type"
          />
          <div
            v-if="internalErrors.type"
            class="error text-red-600 font-semibold mt-1"
          >
            {{ internalErrors.type }}
          </div>
        </div>
        <div class="w-full">
          <FormLabel
            id="is_borrowed"
            label="Is borrowed:"
          />
          <FormSelect
            v-model="form.is_borrowed"
            id="is_borrowed"
            :options="borrowStatuses"
            optionLabelKey="name"
            optionValueKey="value"
          />
          <div
            v-if="internalErrors.is_borrowed"
            class="error text-red-600 font-semibold mt-1"
          >
            {{ internalErrors.is_borrowed }}
          </div>
        </div>
      </div>
    </div>
    <div class="flex justify-center mt-4">
      <FormButton
        type="submit"
        label="Save"
        classes="bg-blue-600 text-white text-lg font-bold rounded-xl hover:bg-blue-700 px-6 py-1.5 transition-linear duration-500 cursor-pointer"
      />
    </div>
  </form>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import type { Props } from '../../../types/books/props';
import type { BookFormEmits } from '../../../features/books/form/emits';
import type { BookFormData } from '../../../types/books/formData';
import { useBookForm } from '../../../composables/form/books/useBookForm';
import { useSubmitForm } from '../../../composables/form/useSubmitForm';
import { useValidationWatcher } from '../../../composables/form/useValidationWatcher';
import FormLabel from '@/Components/Common/Forms/Label.vue';
import FormInput from '@/Components/Common/Forms/Input.vue';
import FormSelect from '@/Components/Common/Forms/Select.vue';
import FormButton from '@/Components/Common/Button.vue';

const props = defineProps<Props>();
const emit = defineEmits<BookFormEmits>();

const book = props.book ?? {};

const form = useBookForm(book);

const { internalErrors } = useValidationWatcher<BookFormData>(() => props.errors);

const isSubmitting = ref(false);

function submitForm(event: Event) {
  useSubmitForm<BookFormData>(
    event,
    internalErrors,
    form,
    (data: BookFormData) => emit('submit', data),
    isSubmitting
  );
}
</script>
