<template>
    <div>
        <select
            v-model="model"
            class="form-select p-2 border-2"
            :class="error ? 'border-red-500!' : ''"
        >
            <option disabled :value="0">-- {{ placeholder }} --</option>
            <option
                v-for="item in items"
                :key="value ? item[value] : item"
                :value="value ? item[value] : item"
            >
                {{ label ? item[label] : item }}
            </option>
        </select>

        <p v-if="error" class="text-red-500">{{ error }}</p>
    </div>
</template>

<script setup lang="ts" generic="U">
const model = defineModel();

defineProps<{
    placeholder: string;
    items: U[];
    value?: string;
    label?: string;
    error?: string;
}>();
</script>

<style scoped>
</style>
