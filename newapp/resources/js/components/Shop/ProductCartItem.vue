<template>
    <div class="card h-100 p-3 shadow-sm border-0 rounded-3">
        <div class="mb-3">
            <Link :href="route('productItem', { id: product.id })">
                <AppImage
                    :src="product.picture_url"
                    :alt="product.name"
                    class="img-fluid rounded-3 shadow-sm"
                />
            </Link>
        </div>
        <div class="card-body d-flex flex-column">
            <h5 class="card-title text-truncate">{{ product.name }}</h5>
            <p class="fw-bold">{{ product.price }} €</p>
            <p v-if="product.stock !== undefined">Stock : {{ product.stock }}</p>
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
import AppImage from "@/components/AppImage.vue";
import { Link } from "@inertiajs/vue3";
import type { Product } from "@/models/Product";
import { ref } from "vue";
import {useCartStore} from "@/stores/Cart";

defineProps<{ product: Product }>()

const { addItem } = useCartStore()

const quantity = ref(1)
</script>

<style scoped>

</style>
