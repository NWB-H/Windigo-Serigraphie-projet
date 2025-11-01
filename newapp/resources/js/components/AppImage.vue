<template>
    <div>
        <img :src="resolvedSrc" :alt="alt" class="img" />
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const props = defineProps<{ url?: string | null, alt?: string }>()

const resolvedSrc = computed(() => props.src || '/images/placeholder.png')
</script>

<style scoped>
.img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
</style>
