<template>
    <AppLayout>
        <div class="container my-5">
            <h2 class="mb-4">Boutique</h2>
            <div class="row">
                <div
                    v-for="product in products"
                    :key="product.id"
                    class="col-md-4 mb-4"
                >
                    <Link :href="route('home')">
                        <div class="card h-100 p-3 shadow-sm border-0 rounded-3">
                            <div class="mb-3">
                                <AppImage
                                    :src="product.picture_url"
                                    :alt="product.name"
                                    class="img-fluid rounded-3 shadow-sm"
                                />
                            </div>
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title text-truncate">{{ product.name }}</h5>
                                <p class="fw-bold">{{ product.price }} €</p>
                                <p v-if="product.stock !== undefined">Stock : {{ product.stock }}</p>
                                <input
                                    type="number"
                                    min="1"
                                    :max="product.stock"
                                    class="form-control mb-2"
                                />
                                <button
                                    class="btn btn-primary w-100"
                                >
                                    Ajouter au panier
                                </button>
                            </div>
                        </div>
                    </Link>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { Product } from "@/models/Product";
import AppImage from "@/components/AppImage.vue";

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
