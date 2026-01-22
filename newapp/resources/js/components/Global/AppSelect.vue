<template>
  <div>
    <select v-model="model" class="form-select mb-2">
      <option disabled :value="0">-- {{ placeholder }} --</option>
      <option v-for="item in items" :key="item[value]" :value="item[value]">{{ item[label] }}</option>
    </select>
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

</style>