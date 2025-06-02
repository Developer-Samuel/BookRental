<!-- 📄 Pages/Authors/Create.vue -->

<template>
  <div class="flex flex-col items-center gap-8">
    <Heading :title="'Create author'" />
    <div class="border border-gray-400 rounded-3xl w-full overflow-hidden">
      <AuthorForm
        @submit="handleCreate"
        :countries="countries"
        :genders="genders"
        :author="{}"
        :errors="errors"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Country } from '../../models/country';
import type { AuthorFormData } from '../../types/authors/formData';
import { useStore } from '../../composables/useStore';
import { Genders } from '../../types/core/genders';
import AuthorForm from '@/Components/Forms/Author/AuthorForm.vue';
import Heading from '@/Components/Common/Typography/Title.vue';

defineProps<{
  countries: Country[];
  genders: Genders;
}>();

const { handleCreate, errors } = useStore<AuthorFormData>('/authors', '/authors');

</script>
