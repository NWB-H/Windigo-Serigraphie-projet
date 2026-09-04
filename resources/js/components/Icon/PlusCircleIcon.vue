<template>
    <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        :stroke="color"
        v-bind="$attrs"
    >
        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
        />
    </svg>
</template>

<script setup lang="ts">
const { color = 'currentColor' } = defineProps<{ color?: string }>();
</script>

<style scoped></style>
