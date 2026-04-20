<template>
    <div v-bind="$attrs">
        <img :src="resolvedSrc" :alt="alt" :class="[imgCssClass ? imgCssClass : 'img']" />
    </div>
</template>

<script setup lang="ts">
import { computed } from 'vue'

const { url = '/images/placeholder.png', imgFit = 'cover' } = defineProps<{ url?: string | null, alt?: string, imgFit?: string, imgCssClass?: string }>()

const resolvedSrc = computed(() => url ?? '/images/placeholder.png')
</script>

<style scoped>
.img {
    width: 100%;
    height: 100%;
    object-fit: v-bind(imgFit);
}
</style>
