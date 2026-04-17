<template>
    <li
        v-for="(image, key) in images"
        :key="image.url"
        class="container_product-form"
        @mouseenter="showActions = true"
        @mouseleave="showActions = false"
    >
        <AppImage :url="image.url" class="h-[150px] w-[150px] object-fill" />
        <Transition>
            <p
                class="absolute right-0 bottom-0 left-0 m-0 flex"
                v-if="showActions"
            >
                <button
                    class="flex flex-1 justify-center bg-blue-500 p-2 text-white hover:bg-blue-700"
                    type="button"
                    @click="$emit('star', key)"
                >
                    <StarIcon class="size-4" :color="image.isHighlighted ? 'yellow' : 'white'"/>
                </button>
                <button
                    class="flex flex-1 justify-center bg-red-500 p-2 text-white hover:bg-red-700"
                    type="button"
                    @click="$emit('delete', key)"
                >
                    <XMarkIcon class="size-4" />
                </button>
            </p>
        </Transition>
    </li>
</template>

<script setup lang="ts">
import XMarkIcon from '@/components/Icon/XMarkIcon.vue';
import StarIcon from '@/components/Icon/StarIcon.vue';
import AppImage from '@/components/AppImage.vue';
import { ref } from 'vue';
import { Image } from '@/models';

defineProps<{ images: Image[] }>();

defineEmits<{
    (e: 'delete', index: number): void,
    (e: 'star', index: number): void,
}>()

const showActions = ref(false);
</script>

<style scoped>
.container_product-form {
    position: relative;
}

.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
