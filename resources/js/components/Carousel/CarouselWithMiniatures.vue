<template>
    <div>
        <div class="mb-3 text-center">
            <AppImage
                :url="images[selectedIndex]?.url"
                imgCssClass="main-image rounded h-[400px] w-full"
                alt="Produit selectionné"
            />
        </div>
        <div
            class="justify-content-center flex-wrap gap-2"
            v-if="images.length > 1"
        >
            <AppCarousel :images="images" @click="handleClick" />
        </div>
    </div>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import AppCarousel from '@/components/AppCarousel.vue';
import { Image } from '@/models';
import { ref } from 'vue';

const props = defineProps<{ images: Image[]; selectedImageUrl?: string }>();

const selectedIndex = ref<number>(
    props.selectedImageUrl
        ? props.images.findIndex(
              (img: Image) => img.url === props.selectedImageUrl,
          )
        : 0,
);

function handleClick(index: number) {
    selectedIndex.value = index;
}
</script>

<style scoped></style>
