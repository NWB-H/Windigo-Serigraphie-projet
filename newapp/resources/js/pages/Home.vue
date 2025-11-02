<template>
    <AppLayout>
        <div class="container my-5">

            <!-- A propos + Boutique + Nouveautés -->
            <div class="row mb-5">
                <div class="col-lg-8 d-flex flex-column mb-4 mb-lg-0">
                    <!-- Description -->
                    <div class="row align-items-center mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <img src="/images/apropos.png" class="img-fluid rounded shadow" alt="Atelier Windigo">
                        </div>
                        <div class="col-md-6">
                            <h1 class="mb-3">Description</h1>
                            <p class="text-justify">
                                Windigo est un petit atelier de sérigraphie artisanale basé au Mans spécialisé dans l'impression sur
                                supports textiles et papiers.
                            </p>
                            <p class="text-justify">
                                Windigo propose une collection de vêtements et sacs imprimés et d'articles de papeterie, disponibles sur
                                Etsy.
                            </p>
                            <p class="text-justify">
                                Pour toute question particulière :
                                <a href="mailto:windigo.serigraphie@gmail.com">windigo.serigraphie@gmail.com</a>
                            </p>
                        </div>
                    </div>

                    <!-- Boutique -->
                    <div class="p-3 bg-light rounded shadow-sm mb-4" v-if="products.length > 0">
                        <h2 class="mb-4">Boutique</h2>
                        <div class="row g-3">
                            <div v-for="product in products" :key="product.id" class="col-md-4">
                                <Link :to="{ name: 'produit-detail', params: { id: product.id } }"
                                             class="text-decoration-none text-dark">
                                    <div class="card h-100 shadow-sm border-0 rounded-3 product-card bg-white">
                                        <div class="product-img-wrapper">
                                            <AppImage :alt="product.name" :url="product.picture_url" class="card-img-top product-img" />
                                        </div>
                                        <div class="card-body text-center">
                                            <h5 class="card-title text-truncate">{{ product.name }}</h5>
                                            <p class="fw-bold">{{ product.price }} €</p>
                                        </div>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Colonne droite : Nouveautés -->
                <div class="col-lg-4 h-100 d-flex flex-column">
                    <div class="bg-light p-3 rounded shadow-sm flex-grow-1 d-flex flex-column justify-content-start">
                        <h2 class="mb-4">Nouveautés</h2>
                        <div v-for="i in 3" :key="i" class="d-flex align-items-center mb-3">
                            <img :src="`/images/nouveaute${i}.png`" class="img-thumbnail me-3 nouveaute-img" alt="">
                            <p class="mb-0 small">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ateliers + Portfolio -->
            <div class="row mb-5">
                <div class="col-lg-6 mb-4 mb-lg-0" v-if="workshops.length > 0">
                    <h2 class="mb-4">Nos ateliers proposés</h2>
                    <div class="row g-3">
                        <div v-for="workshop in workshops" :key="workshop.id" class="col-md-6">
                            <div class="card h-100 shadow-sm border-0 rounded-3 workshop-card">
                                <Link :to="{ name: 'atelier-detail', params: { id: workshop.id } }"
                                             class="text-decoration-none text-dark d-flex flex-column h-100">
                                    <div class="workshop-img-wrapper">
                                        <AppImage :alt="workshop.name" :url="workshop.first_image_url" class="card-img-top workshop-img" />
                                    </div>
                                    <div class="card-body d-flex flex-column justify-content-between">
                                        <div>
                                            <h5 class="card-title">{{ workshop.name }}</h5>
                                            <h6 class="card-subtitle mb-2 text-muted">{{ workshop.type }}</h6>
                                            <p class="card-text mb-1"><strong>Prix :</strong> {{ workshop.price }} €</p>
                                        </div>
                                        <button class="btn btn-outline-primary w-100 mt-2">Voir détails & Réserver</button>
                                    </div>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Portfolio avec carousel dynamique -->
                <div class="col-lg-6" v-if="photos.length > 0">
                    <h2 class="mb-4">Portfolio</h2>
                    <Link to="/portfolio">
                        <div id="portfolioCarousel" class="carousel slide shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
                            <div class="carousel-inner">
                                <div v-for="(photo, i) in photos" :key="photo.id"
                                     :class="['carousel-item', { active: i === 0 }]">
                                    <img :src="photo.src" class="d-block w-100 carousel-img" :alt="photo.titre">
                                </div>
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#portfolioCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#portfolioCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        </div>
                    </Link>
                </div>
            </div>

            <!-- Contact -->
            <div class="mb-5 p-3 bg-light rounded shadow-sm">
                <ContactForm />
            </div>
        </div>
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from "@/layouts/AppLayout.vue";
import { Link } from "@inertiajs/vue3";
import { ref } from "vue";
import type { Product } from "@/models/Product";
import type { Workshop } from "@/models/Workshop";
import AppImage from "@/components/AppImage.vue";
import ContactForm from "@/components/Form/ContactForm.vue";

defineProps<{
    products: Product[],
    workshops: Workshop[],
}>()
const photos = ref([])
</script>

<style scoped>
.card-img-top {
    object-fit: cover;
}

.text-truncate {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* ---- Boutique ---- */
.product-card {
    display: flex;
    flex-direction: column;
    height: 320px;
}
.product-img-wrapper {
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}
.product-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ---- Ateliers ---- */
.workshop-card {
    display: flex;
    flex-direction: column;
    height: 360px;
}
.workshop-img-wrapper {
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-top-left-radius: 0.5rem;
    border-top-right-radius: 0.5rem;
}
.workshop-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* ---- Nouveautés ---- */
.nouveaute-img {
    width: 100px;
    height: 100px;
    object-fit: cover;
}

/* ---- Carousel ---- */
.carousel-img {
    height: 300px;
    object-fit: cover;
}
</style>
