<template>
    <div class="my-3" :class="[containerClass ? containerClass : null]">
        <input
            v-model="model"
            v-bind="$attrs"
            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
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

defineProps<{ error?: string, containerClass?: string }>()
</script>

<style scoped>
.error {
  color: #b00020;
  font-size: 0.9em;
  margin-top: 0.25em;
}
</style>
