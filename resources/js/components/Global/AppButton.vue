<template>
    <button
        type="submit"
        v-bind="$attrs"
        :class="[
            $attrs.class ??
                'w-100 rounded bg-[#a78770] px-6 py-2 font-semibold text-white shadow-sm transition hover:bg-[#8f6e58] focus:ring-2 focus:ring-[#8f6e58]/40 focus:outline-none active:scale-95 disabled:cursor-not-allowed disabled:opacity-50',
        ]"
        :disabled="loading || disabled"
    >
        <slot></slot>
    </button>
</template>

<script setup lang="ts">
defineOptions({ inheritAttrs: false });

const { loading = false, disabled = false } = defineProps<{
    loading?: boolean;
    disabled?: boolean;
}>();
</script>

<style scoped></style>
