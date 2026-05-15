<template>
    <div class="relative w-full">
        <div
            class="flex gap-2 overflow-hidden transition-transform duration-500 ease-in-out"
        >
            <TransitionGroup
                name="slide-horizontal"
                tag="div"
                class="flex w-full gap-2"
            >
                <AppImage
                    v-for="(image, index) in selectedImage"
                    @click="handleClick(index)"
                    :key="image.id"
                    :url="image.url"
                    imgCssClass="object-cover rounded h-[100px] w-full"
                    class="image-slide"
                />
            </TransitionGroup>
        </div>

        <button
            @click="prevSlide"
            class="absolute top-1/2 -left-4 -translate-y-1/2 rounded-full bg-black/50 px-3 py-2 text-white"
        >
            ‹
        </button>

        <button
            @click="nextSlide"
            class="absolute top-1/2 -right-4 -translate-y-1/2 rounded-full bg-black/50 px-3 py-2 text-white"
        >
            ›
        </button>
    </div>
</template>

<script setup lang="ts">
import { ref, computed, PropType } from 'vue';
import { Image } from '@/models/Product';
import AppImage from '@/components/AppImage.vue';

const { images, imagePerRow = 4 } = defineProps({
    images: {
        type: Array as PropType<Image[]>,
        required: true,
    },
    imagePerRow: {
        type: Number,
        validator(value: number): boolean {
            return value >= 4 && value <= 10;
        },
    },
});
const emits = defineEmits<{ (e: 'click'): number }>();

const currentIndex = ref(0);

const selectedImage = computed(() =>
    images.slice(currentIndex.value, currentIndex.value + imagePerRow),
);

const nextSlide = () => {
    currentIndex.value += imagePerRow;

    if (currentIndex.value >= images.length) {
        currentIndex.value = 0;
    }
};

const prevSlide = () => {
    currentIndex.value -= imagePerRow;

    if (currentIndex.value < 0) {
        currentIndex.value =
            Math.floor(images.length / imagePerRow) * imagePerRow;
    }
};

const handleClick = (index: number) => {
    emits('click', index + currentIndex.value);
};
</script>

<style scoped>
.image-slide {
    flex: 0 0 calc((100% - 24px) / 4);
}

.slide-horizontal-enter-active,
.slide-horizontal-leave-active {
    transition:
        transform 0.45s ease,
        opacity 0.45s ease;
}

.slide-horizontal-move {
    transition: transform 0.45s ease;
}

/* Nouvelle image */
.slide-horizontal-enter-from {
    opacity: 0;
    transform: translateX(80px);
}

/* Image supprimée */
.slide-horizontal-leave-to {
    opacity: 0;
    transform: translateX(-80px);
}

.slide-horizontal-enter-to,
.slide-horizontal-leave-from {
    opacity: 1;
    transform: translateX(0);
}
</style>
