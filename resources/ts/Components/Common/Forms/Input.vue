<!-- 📄 Components/Common/Forms/Input.vue -->

<template>
  <input
    :value="modelValue"
    :type="type"
    :id="id"
    :placeholder="placeholder"
    :class="customClass"
    @input="onInput"
  />
</template>

<script setup lang="ts">
withDefaults(defineProps<{
  modelValue: string | number;
  id: string;
  type?: string;
  placeholder?: string;
  customClass?: string;
}>(), {
  id: '',
  type: 'text',
  placeholder: '',
  customClass: 'rounded-lg border border-solid border-gray-300 w-full p-2 outline-0'
});

const emit = defineEmits(['update:modelValue']);

function onInput(event: Event) {
  const target = event.target as HTMLInputElement | null;
  if (target) {
    emit('update:modelValue', target.value);
  }
}
</script>
