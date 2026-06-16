<template>
    <div :class="[containerClass ? containerClass : 'my-3']">
        <div :class="[inputContainerClass ? inputContainerClass : '']" class="relative">
            <input
                v-model="model"
                v-bind="$attrs"
                placeholder=" "
                class="peer w-full rounded-lg border-2 px-2 py-2"
                :class="error ? 'border-red-500 text-red-500' : ''"
            />

            <label
                v-if="$attrs.id"
                :for="$attrs.id"
                class="absolute top-1/2 left-3 -translate-y-1/2 text-base transition-all duration-200 peer-focus:top-0 peer-focus:-translate-y-1/2 peer-focus:bg-white peer-focus:px-1 peer-focus:text-xs peer-[:not(:placeholder-shown)]:top-0 peer-[:not(:placeholder-shown)]:-translate-y-1/2 peer-[:not(:placeholder-shown)]:bg-white peer-[:not(:placeholder-shown)]:px-1 peer-[:not(:placeholder-shown)]:text-xs bg-inherit!"
                :class="error ? 'text-red-500' : 'text-gray-500'"
            >
                {{ $attrs.placeholder ? $attrs.placeholder : '' }}
            </label>
        </div>
        <div v-if="error" class="text-red-500">{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
const model = defineModel();

defineOptions({
    inheritAttrs: false,
});

/**
 * inputContainerClass: for label with same background color has parent
 */
defineProps<{ error?: string; containerClass?: string, inputContainerClass?: string }>();
</script>

<style scoped>
input[type='number'] {
    -moz-appearance: textfield; /* Firefox */
}
</style>
