<template>
  <AppImage :url="image" imgCssClass="size-[64px] rounded-4xl"/>
</template>

<script setup lang="ts">
import AppImage from "@/components/AppImage.vue";

defineProps<{ image?: string }>()
</script>

<style scoped>

</style>
