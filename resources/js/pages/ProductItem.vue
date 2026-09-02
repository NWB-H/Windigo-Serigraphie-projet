<template>
    <div class="container my-5">
        <Link :href="route('shop')" class="btn btn-outline-primary mb-3"
            >← Retour à la boutique</Link
        >

        <h2 class="mb-4">{{ product.name }}</h2>

        <div class="row">
            <!-- Galerie images -->
            <div class="col-md-6">
                <!-- Image principale -->
                <div class="mb-3 text-center">
                    <AppImage
                        :url="
                            product.images[selectedIndex]
                                ? product.images[selectedIndex].url
                                : product.highlighted_image?.url
                        "
                        imgCssClass="main-image rounded h-[400px] w-full"
                        alt="Produit selectionné"
                    />
                </div>

                <!-- Miniatures -->
                <div
                    class="justify-content-center flex-wrap gap-2"
                    v-if="product.images.length > 1"
                >
                    <AppCarousel
                        :images="product.images"
                        @click="handleClick"
                    />
                </div>
            </div>

            <!-- Infos produit -->
            <div class="col-md-6">
                <p class="fw-bold fs-4">{{ product.price }} €</p>
                <p v-if="product.stock !== undefined">
                    Stock : {{ product.stock }}
                    <BadgeStock :product />
                </p>
                <p class="mb-3">{{ product.description }}</p>
                <AddToCart :product="product" />
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';
import AppImage from '@/components/AppImage.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product } from '@/models/Product';
import AppCarousel from '@/components/AppCarousel.vue';
import AddToCart from '@/components/Shop/AddToCart.vue';
import BadgeStock from '@/components/Shop/BadgeStock.vue';
import { Image } from '@/models';

const { product } = defineProps<{ product: Product }>();

defineOptions({
    layout: (props: { product: Product }) => [
        AppLayout,
        { title: props.product.name },
    ],
});

const selectedIndex = ref<number>(
    product.images.findIndex((img: Image) => img.url === product.picture_url),
);

function handleClick(index: number) {
    selectedIndex.value = index;
}
</script>
