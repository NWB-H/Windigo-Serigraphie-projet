<template>
    <AppLayout title="Boutique">
        <div class="container my-5">
            <h2 class="mb-4">Boutique</h2>
            <div class="row">
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="col-md-4 mb-4"
                >
                    <ProductCartItem :product="product" />
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Product } from "@/models/Product";
import ProductCartItem from "@/components/Shop/ProductCartItem.vue";

defineProps<{ products: Product[] }>()
</script>

<style scoped>
.card {
    transition: transform 0.2s ease-in-out;
}
.card:hover {
    transform: translateY(-5px);
}
.card img {
    max-height: 300px;
    object-fit: contain;
}
.card-body {
    padding: 1rem;
}
</style>
