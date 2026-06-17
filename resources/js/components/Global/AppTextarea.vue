<template>
    <div class="relative my-2">
        <div class="relative">
            <textarea
                v-model="model"
                v-bind="$attrs"
                placeholder=""
                class="peer w-full rounded-lg border-2 border-gray-300 px-2 py-2"
                :class="error ? 'border-red-500 text-red-500' : ''"
            ></textarea>
            <label
                v-if="$attrs.id"
                :for="$attrs.id"
                class="absolute top-1/2 left-3 -translate-y-1/2 text-base transition-all duration-200 peer-focus:top-0 peer-focus:-translate-y-1/2 peer-focus:bg-white peer-focus:px-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:-translate-y-1/2 peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:px-1 peer-[:not(:placeholder-shown)]:text-xs"
                :class="error ? 'text-red-500' : 'text-gray-500'"
            >
                {{ $attrs.placeholder ? $attrs.placeholder : '' }}
            </label>
        </div>
        <div v-if="error" class="text-red-500">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
defineProps<{ error?: string }>();

defineOptions({
    inheritAttrs: false,
});

const model = defineModel();
</script>

<style scoped>
.error {
    color: #b00020;
    font-size: 0.9em;
    margin-top: 0.25em;
}
</style>
