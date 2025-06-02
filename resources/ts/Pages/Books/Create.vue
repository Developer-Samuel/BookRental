<!-- 📄 Pages/Books/Create.vue -->

<template>
  <div class="flex flex-col items-center gap-8">
    <Heading :title="'Create book'" />
    <div class="border border-gray-400 rounded-3xl w-full overflow-hidden">
      <BookForm
        @submit="wrappedHandleCreate"
        :book="{}"
        :authorId="authorId"
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
import { useStore } from '../../composables/useStore';
import BookForm from '@/Components/Forms/Book/BookForm.vue';
import Heading from '@/Components/Common/Typography/Title.vue';

const { authorId, types, borrowStatuses } = defineProps<{
  authorId: number;
  types: TypeOption[];
  borrowStatuses: BorrowStatuses[];
}>();

const { handleCreate, errors } = useStore<Omit<BookFormData, 'authorId'>>(
  '/books',
  `/books/${authorId}`
);

function wrappedHandleCreate(data: Omit<BookFormData, 'authorId'>) {
  handleCreate({
    ...data,
    author_id: authorId,
  } as any);
}
</script>
