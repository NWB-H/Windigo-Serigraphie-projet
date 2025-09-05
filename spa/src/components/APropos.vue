<template>
    <div class="container my-5">
        <div class="row">
            <!-- Colonne gauche -->
            <div class="col-lg-6">
                <!-- À propos de l'entreprise -->
                <section class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h2 class="mb-4">À propos de l’entreprise</h2>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 mb-3 mb-md-0">
                            <img :src="''" alt="Entreprise" class="img-fluid rounded shadow-sm">
                        </div>
                        <div class="col-12 col-md-6">
                            <p></p>
                        </div>
                    </div>
                </section>

                <!-- À propos de la sérigraphie -->
                <section class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h2 class="mb-4">À propos de la sérigraphie</h2>
                    <p></p>
                    <img :src="''" alt="Sérigraphie" class="img-fluid rounded shadow-sm mt-3">
                    <button class="btn btn-primary btn-lg mt-3" @click="router.push('/ateliers')">
                        Découvrir la sérigraphie
                    </button>
                </section>
            </div>

            <!-- Colonne droite -->
            <div class="col-lg-6">
                <!-- À propos de moi -->
                <section class="mb-5 p-4 bg-light rounded shadow-sm">
                    <h2 class="mb-4">À propos de moi</h2>
                    <div class="row align-items-center">
                        <div class="col-12 col-md-6 order-2 order-md-1">
                            <p></p>
                        </div>
                        <div class="col-12 col-md-6 order-1 order-md-2 mb-3 mb-md-0">
                            <img :src="''" alt="Moi" class="img-fluid rounded shadow-sm">
                        </div>
                    </div>
                </section>
                <section class="mb-5 p-4 bg-light rounded shadow-sm">
                    <!-- Galerie -->
                    <div class="row mt-3 g-2">
                        <!-- <div v-for="" :key="''" class="col-4">
                            <img :src="''" class="img-fluid rounded shadow-sm">
                        </div> -->
                    </div>

                    <button class="btn btn-primary btn-lg mt-3" @click="router.push('/portfolio')">
                        Découvrir les créations
                    </button>
                </section>

                <!-- Produits / Boutique -->
                <section class="p-4 bg-light rounded shadow-sm">
                    <h2 class="mb-4">Boutique</h2>
                    <div class="row g-3">
                        <div v-for="product in randomProducts" :key="product.id" class="col-md-4">
                           <router-link :to="{ name: 'produit-detail', params: { id: product.id } }">
                            <div class="card h-100 shadow-sm">
                                <img v-if="product.picture_url" :src="product.picture_url" class="card-img-top"
                                    alt="product.name" />
                                <div class="card-body text-center">
                                    <h5 class="card-title text-truncate">{{ product.name }}</h5>
                                </div>
                            </div>
                             </router-link>
                        </div>
                    </div>
                    <button class="btn btn-primary btn-lg mt-3" @click="router.push('/boutique')">
                        Découvrir les articles
                    </button>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import type { Product } from '@/_models/Product';
import { getProducts } from '@/_services/ProductService';
import router from '@/router';
import { onMounted, ref } from 'vue';

const randomProducts = ref<Product[]>([]);

onMounted(async () => {
  try {
    const products = await getProducts();
    const shuffled = [...products].sort(() => 0.5 - Math.random());
    randomProducts.value = shuffled.slice(0, 3);
  } catch (error) {
    console.error('Erreur récupération produits :', error);
  }
});
</script>

<style scoped>
h2 {
    font-weight: 600;
}

p {
    line-height: 1.6;
}

.btn-primary {
    border-radius: 0.5rem;
    padding: 0.75rem 1.5rem;
}
</style>
