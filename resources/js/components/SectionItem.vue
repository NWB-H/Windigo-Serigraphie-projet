<template>
    <div>
        <section class="mb-5 p-4 bg-light rounded shadow-sm">
            <slot name="header">
                <h2 class="mb-4">{{ header }}</h2>
            </slot>
            <slot name="body">
                <div class="row align-items-center">
                    <div class="col-12 col-md-6 mb-3 mb-md-0">
                        <AppImage :src="image?.url" :alt="image?.text" class="img-fluid rounded shadow-sm" />
                    </div>
                    <div class="col-12 col-md-6">
                        <p>{{ text }}</p>
                    </div>
                </div>
            </slot>
        </section>
    </div>
</template>

<script setup lang="ts">
import AppImage from "@/components/AppImage.vue";

interface Image {
    url?: string
    text: string
}

defineProps<{ header: string, text?: string, image?: Image }>()
</script>

<style scoped>

</style>
