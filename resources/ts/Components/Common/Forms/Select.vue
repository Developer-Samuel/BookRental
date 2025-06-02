<!-- 📄 Components/Common/Forms/Select.vue -->

<template>
  <select
    :id="id"
    :class="customClass"
    :value="modelValue"
    @change="onChange"
  >
    <option
      v-if="placeholder"
      disabled
      :value="emptyValue"
    >
      {{ placeholder }}
    </option>

    <template v-if="isArray">
      <option
        v-for="option in optionsArray"
        :key="optionKey(option)"
        :value="optionValue(option)"
      >
        {{ optionLabel(option) }}
      </option>
    </template>

    <template v-else>
      <option
        v-for="(label, value) in optionsObject"
        :key="value"
        :value="value"
      >
        {{ label }}
      </option>
    </template>
  </select>
</template>

<script setup lang="ts">
import { computed } from 'vue';
import { Option } from '../../../types/core/option';

const props = withDefaults(defineProps<{
  modelValue: string | number | null;
  id: string;
  options: Option[] | Record<string, string>;
  optionLabelKey?: string;
  optionValueKey?: string;
  placeholder?: string;
  customClass?: string;
  emptyValue?: string | number | null;
}>(), {
  optionLabelKey: 'name',
  optionValueKey: 'id',
  placeholder: '',
  customClass: 'rounded-lg border border-solid border-gray-300 w-full p-2 outline-0',
  emptyValue: '',
});

const emit = defineEmits<{
  (e: 'update:modelValue', value: string | number | null): void;
}>();

const isArray = computed(() => Array.isArray(props.options));

const optionsArray = computed(() => (isArray.value ? props.options as Option[] : []));
const optionsObject = computed(() => (!isArray.value ? props.options as Record<string, string> : {}));

function optionLabel(option: Option): string {
  return String(option[props.optionLabelKey!] ?? '');
}

function optionValue(option: Option): string | number {
  return option[props.optionValueKey!] ?? '';
}

function optionKey(option: Option): string | number {
  return option[props.optionValueKey!] ?? JSON.stringify(option);
}

function onChange(event: Event) {
  const target = event.target as HTMLSelectElement;
  let value: string | number | null = target.value;

  if (value === String(props.emptyValue)) {
    value = null;
  }

  emit('update:modelValue', value);
}
</script>
