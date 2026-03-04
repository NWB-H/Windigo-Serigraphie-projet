<template>
  <div>
    <select v-model="model" class="form-select mb-2">
      <option disabled :value="0">-- {{ placeholder }} --</option>
      <option v-for="item in items" :key="item[value]" :value="item[value]">{{ item[label] }}</option>
    </select>
    <p v-if="error" class="error">{{ error }}</p>
  </div>
</template>

<script setup lang="ts" generic="U">
const model = defineModel()

defineProps<{
  placeholder: string,
  items: U[],
  value: string,
  label: string,
  error?: string,
}>()
</script>

<style scoped>
.error {
  color: #b00020;
  font-size: 0.9em;
  margin-top: 0.25em;
}
</style>