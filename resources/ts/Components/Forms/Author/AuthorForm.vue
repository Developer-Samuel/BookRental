<!-- 📄 Components/Forms/Author/AuthorForm.vue -->

<template>
  <form @submit.prevent="submitForm" class="flex flex-col gap-6 p-8">
    <div class="flex flex-col gap-4">
      <div class="flex md:flex-row flex-col gap-4">
        <div class="w-full">
          <FormLabel
            id="name"
            label="Name:"
          />
          <FormInput
            v-model="form.name"
            id="name"
          />
          <div
            v-if="internalErrors.name"
            class="error text-red-600 font-semibold mt-1"
          >
            {{ internalErrors.name }}
          </div>
        </div>
        <div class="w-full">
          <FormLabel
            id="surname"
            label="Surname:"
          />
          <FormInput
            v-model="form.surname"
            id="surname"
          />
          <div
            v-if="internalErrors.surname"
            class="error text-red-600 font-semibold mt-1"
          >
            {{ internalErrors.surname }}
          </div>
        </div>
      </div>
      <div class="flex md:flex-row flex-col gap-4">
        <div class="w-full">
          <FormLabel
            id="country_id"
            label="Country:"
          />
          <FormSelect
            v-model="form.country_id"
            id="country_id"
            :options="countries"
            optionLabelKey="name"
            optionValueKey="id"
            placeholder="Select a country"
          />
          <div
            v-if="internalErrors.country_id"
            class="error text-red-600 font-semibold mt-1"
          >
            {{ internalErrors.country_id }}
          </div>
        </div>
        <div class="w-full">
          <FormLabel
            id="gender"
            label="Gender:"
          />
          <FormSelect
            v-model="form.gender"
            id="gender"
            :options="genders"
          />
          <div
            v-if="internalErrors.gender"
            class="error text-red-600 font-semibold mt-1"
          >
            {{ internalErrors.gender }}
          </div>
        </div>
      </div>
      <div>
        <FormLabel
          id="birth_date"
          label="Birth Date:"
        />
        <FormInput
          v-model="form.birth_date"
          type="date"
          id="birth_date"
        />
        <div
          v-if="internalErrors.birth_date"
          class="error text-red-600 font-semibold mt-1"
        >
          {{ internalErrors.birth_date }}
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
import type { Props } from '../../../types/authors/props';
import type { AuthorFormEmits } from '../../../features/authors/form/emits';
import type { AuthorFormData } from '../../../types/authors/formData';
import { useAuthorForm } from '../../../composables/form/authors/useAuthorForm';
import { useSubmitForm } from '../../../composables/form/useSubmitForm';
import { useValidationWatcher } from '../../../composables/form/useValidationWatcher';
import FormLabel from '@/Components/Common/Forms/Label.vue';
import FormInput from '@/Components/Common/Forms/Input.vue';
import FormSelect from '@/Components/Common/Forms/Select.vue';
import FormButton from '@/Components/Common/Button.vue';

const props = defineProps<Props>();
const emit = defineEmits<AuthorFormEmits>();

const author = props.author ?? {};

const form = useAuthorForm(author);

const { internalErrors } = useValidationWatcher<AuthorFormData>(() => props.errors);

const isSubmitting = ref(false);

function submitForm(event: Event) {
  useSubmitForm<AuthorFormData>(
    event,
    internalErrors,
    form,
    (data: AuthorFormData) => emit('submit', data),
    isSubmitting
  );
}
</script>
