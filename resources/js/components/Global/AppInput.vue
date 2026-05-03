<template>
    <div class="my-3" :class="[containerClass ? containerClass : null]">
        <input
            v-model="model"
            v-bind="$attrs"
            :class="[$attrs.class ? $attrs.class : 'w-full rounded-lg border border-[#bfa79a] bg-[#f7f3f0] px-4 py-2 text-gray-800 placeholder-gray-500 shadow-sm transition outline-none focus:border-[#a18678] focus:ring-2 focus:ring-[#a18678]/40 disabled:cursor-not-allowed disabled:bg-[#e8ddd6] disabled:text-gray-500']"
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
