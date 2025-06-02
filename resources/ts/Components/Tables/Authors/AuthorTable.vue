<!-- 📄 Components/Tables/Authors/AuthorTable.vue -->

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
        v-for="author in authors"
        :key="author.id"
        :author="author"
        :columns="getBodyData(author)"
        :actions="getActionData(author, onDelete)"
        @delete="() => onDelete(author.id)"
      />
    </tbody>
  </table>
</template>

<script setup lang="ts">
import { ref, watch } from 'vue';
import type { Direction } from '../../../types/core/direction';
import type { AuthorTableProps } from '../../../features/authors/table/props';
import type { TableEmits } from '../../../features/common/table/emits';
import type { Author } from '../../../models/author';

import { sortableColumns } from '../../../features/authors/table/columns';
import { getBodyData } from '../../../features/authors/table/bodyData';
import { getActionData } from '../../../features/authors/table/actionData';

import HeadRow from '@/Components/Common/Tables/Head/HeadRow.vue';
import BodyRow from '@/Components/Common/Tables/Body/BodyRow.vue';

const props = defineProps<AuthorTableProps>();
const emit = defineEmits<TableEmits>();

const localAuthors = ref<Author[]>([...props.authors]);

watch(() => props.authors, (newAuthors) => {
  localAuthors.value = [...newAuthors];
});

const onDelete = (id: number) => {
  localAuthors.value = localAuthors.value.filter(author => author.id !== id);
  emit('delete', id);
};

const onSort = (payload: { orderBy: string; direction: Direction }) => {
  emit('sort', payload);
};
</script>
