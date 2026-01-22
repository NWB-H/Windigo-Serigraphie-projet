<template>
    <div>
      <textarea
        v-model="model"
        v-bind="$attrs"
      ></textarea>
      <div
          v-if="error"
          class="error"
      >{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
defineProps<{ error?: string }>()

defineOptions({
  inheritAttrs: false
})

const model = defineModel()
</script>

<style scoped>
.error {
  color: #b00020;
  font-size: 0.9em;
  margin-top: 0.25em;
}
</style>