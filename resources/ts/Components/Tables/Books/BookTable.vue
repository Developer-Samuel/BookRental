<!-- 📄 Components/Tables/Books/BookTable.vue -->

<template>
  <table class="w-full text-left text-gray-500">
    <thead>
      <HeadRow
        :columns="sortableColumns"
        :orderBy="orderBy"
        :direction="direction"
        @sort="onSort"
      />
    </thead>
    <tbody>
      <BodyRow
        v-for="book in books"
        :key="book.id"
        :book="book"
        :columns="getBodyData(book)"
        :actions="getActionData(book, onDelete)"
        @delete="() => onDelete(book.id)"
      />
    </tbody>
  </table>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import type { Direction } from '../../../types/core/direction';
import type { BookTableProps } from '../../../features/books/table/props';
import type { TableEmits } from '../../../features/common/table/emits';

import { Book } from '../../../models/book';
import { sortableColumns } from '../../../features/books/table/columns';
import { getBodyData } from '../../../features/books/table/bodyData';
import { getActionData } from '../../../features/books/table/actionData';

import HeadRow from '@/Components/Common/Tables/Head/HeadRow.vue';
import BodyRow from '@/Components/Common/Tables/Body/BodyRow.vue';

const props = defineProps<BookTableProps>();
const emit = defineEmits<TableEmits>();

const localBooks = ref<Book[]>([...props.books]);

watch(() => props.books, (newBooks) => {
  localBooks.value = [...newBooks];
});

const onDelete = (id: number) => {
  localBooks.value = localBooks.value.filter(book => book.id !== id);
  emit('delete', id);
};

const onSort = (payload: { orderBy: string; direction: Direction }) => {
  emit('sort', payload);
};
</script>
