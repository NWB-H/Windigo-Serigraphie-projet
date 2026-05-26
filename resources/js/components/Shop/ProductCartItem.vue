<template>
    <div class="card rounded-3 h-100 border-0 p-3 shadow-sm">
        <div class="mb-3">
            <Link :href="route('productItem', { id: product.id })">
                <AppImage
                    :url="product.picture_url ?? null"
                    :alt="product.name"
                    img-css-class="rounded-3 shadow-sm h-[385px] w-[385px] max-w-[385px] max-h-[385px]"
                />
            </Link>
        </div>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title text-truncate">{{ product.name }}</h5>
            <p class="fw-bold">{{ product.price }} €</p>
            <p v-if="product.stock !== undefined">
                Stock : {{ product.stock }}
            </p>
            <button
                class="btn btn-primary w-100"
                @click.prevent="addItem(product)"
            >
                Ajouter au panier
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import type { Product } from '@/models/Product';
import { useCartStore } from '@/stores/Cart';
import { Link } from '@inertiajs/vue3';

defineProps<{ product: Product }>();

const { addItem } = useCartStore();
</script>

<style scoped></style>
