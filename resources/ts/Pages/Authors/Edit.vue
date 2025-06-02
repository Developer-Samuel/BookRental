<!-- 📄 Pages/Authors/Edit.vue -->

<template>
  <div class="flex flex-col items-center gap-8">
    <Heading :title="'Edit [' + fullName + ']'" />
    <div class="border border-gray-400 rounded-3xl w-full overflow-hidden">
      <AuthorForm
        @submit="handleUpdate"
        :countries="countries"
        :genders="genders"
        :author="author"
        :errors="errors"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Country } from '../../models/country';
import type { Genders } from '../../types/core/genders';
import type { AuthorFormData } from '../../types/authors/formData';
import { useUpdate } from '../../composables/useUpdate';

import AuthorForm from '@/Components/Forms/Author/AuthorForm.vue';
import Heading from '@/Components/Common/Typography/Title.vue';

const props = defineProps<{
  countries: Country[];
  genders: Genders;
  fullName: string;
  author: AuthorFormData;
}>();

const author = props.author;

const { handleUpdate, errors } = useUpdate<AuthorFormData>(
    '/authors/update',
    '/authors'
);
</script>
