<template>
    <AppLayout>
        <Head :title="product.name" />
        <div class="container my-5">
            <Link :href="route('shop')" class="btn btn-outline-primary mb-3">← Retour à la boutique</Link>

            <h2 class="mb-4">{{ product.name }}</h2>

            <div class="row">
                <!-- Galerie images -->
                <div class="col-md-6">
                    <!-- Image principale -->
                    <div class="mb-3 text-center">
                        <AppImage :src="currentImage" class="w-100 rounded main-image" :alt="product.name" />
                    </div>

                    <!-- Miniatures -->
                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                        <div v-for="(img, index) in product.images" :key="index" class="thumbnail-wrapper" @click="selectedIndex = index">
                            <AppImage :src="img" class="thumbnail" :class="{ active: index === selectedIndex }" />
                        </div>
                    </div>
                </div>

                <!-- Infos produit -->
                <div class="col-md-6">
                    <p class="fw-bold fs-4">{{ product.price }} €</p>
                    <p v-if="product.stock !== undefined">Stock : {{ product.stock }}</p>
                    <p class="mb-3">{{ product.description }}</p>

                    <div class="mb-3">
                        <label class="form-label">Quantité</label>
                        <input type="number" min="1" :max="product.stock" v-model.number="quantity" class="form-control" />
                    </div>

                    <button class="btn btn-primary w-100" @click="needImplementationNotification()">Ajouter au panier</button>
                </div>
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import AppImage from "@/components/AppImage.vue";
import { useNotificationStore } from "@/stores/Notifications";
import { Product } from "@/models/Product";
import { ref, computed } from "vue";
import { Head, Link } from "@inertiajs/vue3";

const props = defineProps<{ product: Product }>()

const { needImplementationNotification } = useNotificationStore()

const quantity = ref(0)
const selectedIndex = ref(0)

const currentImage = computed(() => {
    if (props.product.images && props.product.images[selectedIndex]) {
        return props.product.images[selectedIndex]
    }

    return null;
})
</script>
