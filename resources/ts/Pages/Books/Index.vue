<!-- 📄 Pages/Books/Index.vue -->

<template>
  <div class="flex flex-col items-center gap-8">
    <Heading title="Books" />
    <div class="flex justify-center my-2">
      <Link
        :href="`/books/create/${props.authorId}`"
        classes="bg-green-600 hover:bg-green-700 text-white text-lg font-medium rounded-xl px-4 py-1.5 transition-linear duration-500"
      >
        Create
      </Link>
    </div>
    <div class="border border-gray-400 rounded-3xl w-full overflow-x-auto overflow-y-hidden">
      <BookTable
        v-if="books.length"
        :books="books"
        :orderBy="orderBy"
        :direction="direction"
        @delete="deleteBook"
        @sort="onSort"
      />
      <div v-else class="flex justify-center items-center">
        <p class="text-lg font-bold py-24">
            No books found.
        </p>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import type { Book } from '../../models/book';
import { useSortBooks } from '../../composables/table/books/useSortBooks';
import { useDelete } from '../../composables/useDelete';
import Heading from '@/Components/Common/Typography/Title.vue';
import Link from '@/Components/Common/Link.vue';
import BookTable from '@/Components/Tables/Books/BookTable.vue';

const props = defineProps<{
  authorId: number;
  books: Book[];
  tableClass?: string;
}>();

const { books, orderBy, direction, onSort } = useSortBooks(props.books);

const deleteBook = async (id: number) => {
  await useDelete('/books/destroy', id, (idToRemove) => {
    books.value = books.value.filter((book) => book.id !== idToRemove);
  });
};
</script>
