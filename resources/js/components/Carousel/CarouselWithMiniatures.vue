<template>
    <div
        class="@container flex h-full max-h-150 w-full flex-col gap-2 @lg:gap-3"
    >
        <div class="min-h-0 flex-8">
            <AppImage
                :url="images[selectedIndex]?.url"
                class="h-full w-full"
                imgCssClass="main-image rounded w-full h-full"
                alt="Produit selectionné"
            />
        </div>
        <div class="min-h-0 flex-2" v-if="images.length > 1">
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
