<template>
  <div class="preview-image" @click="handleClick">
    <PlusIcon :color="color" class="w-[56px] h-[56px]" />
    <input type="file" ref="input" @change="handleFileChange">
  </div>  
</template>

<script setup lang="ts">
import { ref, useTemplateRef } from "vue";
import PlusIcon from "@/components/Icon/PlusIcon.vue";

const input = useTemplateRef('input')
const emits = defineEmits<{ (e: 'image:loaded', image: File): void }>()
const img = ref(null)
const color = ref('#59535382')

function handleFileChange(e: Event) {
  e.preventDefault()
  const file = (e.target as HTMLInputElement).files?.[0]
  if (file) {
    emits('image:loaded', file)
  }
}

function handleClick() {
  input.value.click()
}
</script>

<style scoped>
.preview-image {
  display: flex;
  justify-content: center;
  align-items: center;
  border: 5px dashed v-bind(color);
}

.preview-image:hover {
  cursor: pointer;
}

input {
  display: none;
}

img {
  width: 100%;
  height: 100%;
}
</style>