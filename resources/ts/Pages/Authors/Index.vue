<!-- 📄 Pages/Authors/Index.vue -->

<template>
  <div class="flex flex-col items-center gap-8">
    <Heading title="Authors" />
    <div class="flex justify-center my-2">
      <Link
        href="/authors/create"
        classes="bg-green-600 hover:bg-green-700 text-white text-lg font-medium rounded-xl px-4 py-1.5 transition-linear duration-500"
      >
        Create
      </Link>
    </div>
    <div class="border border-gray-400 rounded-3xl w-full overflow-x-auto overflow-y-hidden">
      <AuthorTable
        v-if="authors.length"
        :authors="authors"
        :orderBy="orderBy"
        :direction="direction"
        @delete="deleteAuthor"
        @sort="onSort"
      />
      <div v-else class="flex justify-center items-center">
        <p class="text-lg font-bold py-24">
            No authors found.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Author } from '../../models/author';
import { useSortAuthors } from '../../composables/table/authors/useSortAuthors';
import { useDelete } from '../../composables/useDelete';

import Heading from '@/Components/Common/Typography/Title.vue';
import Link from '@/Components/Common/Link.vue';
import AuthorTable from '@/Components/Tables/Authors/AuthorTable.vue';

const props = defineProps<{
  authors: Author[];
  tableClass?: string;
}>();

const { authors, orderBy, direction, onSort } = useSortAuthors(props.authors);

const deleteAuthor = async (id: number) => {
  await useDelete('/authors/destroy', id, (idToRemove) => {
    authors.value = authors.value.filter((author) => author.id !== idToRemove);
  });
};
</script>
