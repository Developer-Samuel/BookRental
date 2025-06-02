<!-- 📄 Pages/Books/Edit.vue -->

<template>
  <div class="flex flex-col items-center gap-8">
    <Heading :title="'Edit [' + book.title + ']'" />
    <div class="border border-gray-400 rounded-3xl w-full overflow-hidden">
      <BookForm
        @submit="handleUpdate"
        :book="book"
        :author-id="book.author_id"
        :types="types"
        :borrowStatuses="borrowStatuses"
        :errors="errors"
      />
    </div>
  </div>
</template>

<script setup lang="ts">
import type { TypeOption } from '../../types/core/typeOptions';
import type { BorrowStatuses } from '../../types/books/borrowStatuses';
import type { BookFormData } from '../../types/books/formData';
import { useUpdate } from '../../composables/useUpdate';
import BookForm from '@/Components/Forms/Book/BookForm.vue';
import Heading from '@/Components/Common/Typography/Title.vue';

const props = defineProps<{
  book: {
    id: number;
    author_id: number;
    title: string;
    type: string;
    is_borrowed: number;
  };
  types: TypeOption[];
  borrowStatuses: BorrowStatuses[];
}>();

const { handleUpdate, errors } = useUpdate<BookFormData>(
    '/books/update',
    `/books/${props.book.author_id}`
);
</script>
