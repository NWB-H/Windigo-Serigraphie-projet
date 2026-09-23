<template>
    <div class="container my-5">
        <Link :href="route('shop')" class="btn btn-outline-primary mb-3">
            ← Retour à la boutique
        </Link>
        <h2 class="mb-4">{{ product.name }}</h2>

        <div class="row">
            <div class="col-md-6">
                <CarouselWithMiniatures
                    :images="product.images"
                    :selectedImageUrl="product.highlighted_image?.url ?? product.images[0]?.url"
                />
            </div>
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
import { Link } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Product } from '@/models/Product';
import AddToCart from '@/components/Shop/AddToCart.vue';
import BadgeStock from '@/components/Shop/BadgeStock.vue';
import CarouselWithMiniatures from '@/components/Carousel/CarouselWithMiniatures.vue';

const { product } = defineProps<{ product: Product }>();

defineOptions({
    layout: (props: { product: Product }) => [
        AppLayout,
        { title: props.product.name },
    ],
});
</script>
