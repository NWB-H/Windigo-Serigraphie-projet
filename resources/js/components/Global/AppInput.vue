<template>
    <div class="my-3" :class="[containerClass ? containerClass : null]">
        <input
            v-model="model"
            v-bind="$attrs"
            class="bg-neutral-secondary-medium border-default-medium text-heading rounded-base focus:ring-brand focus:border-brand placeholder:text-body block w-full border px-3 py-2.5 text-sm shadow-xs"
        />
        <div v-if="error" class="error">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
const model = defineModel();

defineOptions({
    inheritAttrs: false,
});

defineProps<{ error?: string; containerClass?: string }>();
</script>

<style scoped>
.error {
    color: #b00020;
    font-size: 0.9em;
    margin-top: 0.25em;
}
</style>
