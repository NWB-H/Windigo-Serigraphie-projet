<template>
    <div class="my-3">
        <input
            v-model="model"
            v-bind="$attrs"
        />
      <div
          v-if="error"
          class="error"
      >{{ error }}</div>
    </div>
</template>

<script setup lang="ts">
const model = defineModel()

defineOptions({
  inheritAttrs: false
})

defineProps<{ error: string }>()
</script>

<style scoped>
.error {
  color: #b00020;
  font-size: 0.9em;
  margin-top: 0.25em;
}
</style>
