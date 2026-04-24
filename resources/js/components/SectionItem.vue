<template>
    <div>
        <section class="bg-light mb-5 rounded p-4 shadow-sm">
            <slot name="header">
                <h2 class="mb-4">{{ header }}</h2>
            </slot>
            <slot name="body">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-md-0 col-12 mb-3">
                        <AppImage
                            :src="image?.url"
                            :alt="image?.text"
                            class="img-fluid rounded shadow-sm"
                        />
                    </div>
                    <div class="col-md-6 col-12">
                        <p>{{ text }}</p>
                    </div>
                </div>
            </slot>
        </section>
    </div>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';

interface Image {
    url?: string;
    text: string;
}

defineProps<{ header: string; text?: string; image?: Image }>();
</script>

<style scoped></style>
