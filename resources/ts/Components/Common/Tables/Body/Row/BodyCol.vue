<!-- 📄 Components/Common/Tables/Body/Row/BodyCol.vue -->

<template>
  <td :class="['px-6 py-4', $attrs.class || 'text-gray-900']">
    <slot />
  </td>
</template>
