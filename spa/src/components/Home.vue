<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { getProducts } from '@/_services/ProductService';
import type { Product } from '@/_models/Product';
import { useWorkshopStore } from '@/stores/Workshop';

const randomProducts = ref<Product[]>([]);
const workshopStore = useWorkshopStore();

onMounted(async () => {
  try {
    const products = await getProducts();
    const shuffled = [...products].sort(() => 0.5 - Math.random());
    randomProducts.value = shuffled.slice(0, 3);
  } catch (error) {
    console.error('Erreur récupération produits :', error);
  }

  workshopStore.fetchWorkshops();
});
</script>

<template>
  <div class="container my-5">

    <!-- A propos + Boutique + Nouveautés -->
    <div class="row mb-5">
      <!-- Colonne gauche : Description + Boutique -->
      <div class="col-lg-8 d-flex flex-column mb-4 mb-lg-0">
        <!-- Description -->
        <div class="row align-items-center mb-4">
          <div class="col-md-6 mb-3 mb-md-0">
            <img src="@/assets/apropos.png" class="img-fluid rounded shadow" alt="Atelier Windigo">
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
        <div>
          <h2 class="mb-4">Boutique</h2>
          <div class="row g-3">
            <div v-for="product in randomProducts" :key="product.id" class="col-md-4">
              <router-link :to="{ name: 'produit-detail', params: { id: product.id } }"
                class="text-decoration-none text-dark">
                <div class="card h-100 shadow-sm border-0 rounded-3">
                  <img v-if="product.picture_url" :src="product.picture_url" class="card-img-top" alt="product.name" />
                  <div class="card-body text-center">
                    <h5 class="card-title text-truncate">{{ product.name }}</h5>
                    <p class="fw-bold">{{ product.price }} €</p>
                  </div>
                </div>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <!-- Colonne droite : Nouveautés pleine hauteur -->
      <div class="col-lg-4 h-100 d-flex flex-column">
        <div class="bg-light p-3 rounded shadow-sm flex-grow-1 d-flex flex-column justify-content-start">
          <h2 class="mb-4">Nouveautés</h2>
          <div v-for="i in 3" :key="i" class="d-flex align-items-center mb-3">
            <img :src="`@/assets/nouveaute${i}.png`" class="img-thumbnail me-3"
              style="width:100px; height:100px; object-fit:cover;" alt="">
            <p class="mb-0 small">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor.
            </p>
          </div>
        </div>
      </div>
    </div>
    <!-- Ateliers + Portfolio -->
    <div class="row mb-5">
      <div class="col-lg-6 mb-4 mb-lg-0">
        <h2 class="mb-4">Nos ateliers proposés</h2>
        <div class="row g-3">
          <div v-for="workshop in workshopStore.workshops" :key="workshop.id" class="col-md-6">
            <div class="card h-100 shadow-sm border-0 rounded-3">
              <router-link :to="{ name: 'atelier-detail', params: { id: workshop.id } }"
                class="text-decoration-none text-dark">
                <img v-if="workshop.first_image_url" :src="workshop.first_image_url" class="card-img-top"
                  :alt="workshop.name" />
                <div class="card-body">
                  <h5 class="card-title">{{ workshop.name }}</h5>
                  <h6 class="card-subtitle mb-2 text-muted">{{ workshop.type }}</h6>
                  <p class="card-text mb-1"><strong>Prix :</strong> {{ workshop.price }} €</p>
                  <button class="btn btn-primary w-100 mt-2">Voir détails & Réserver</button>
                </div>
              </router-link>
            </div>
          </div>
        </div>
      </div>

      <div class="col-lg-6">
        <h2 class="mb-4">Portfolio</h2>
        <div id="carouselExample" class="carousel slide shadow-sm rounded overflow-hidden" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div v-for="(c, i) in [1, 2, 3, 4]" :key="i" :class="['carousel-item', { active: i === 0 }]">
              <img :src="`@/assets/carousel${c}.jpg`" class="d-block w-100" alt="">
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
      </div>
    </div>

    <!-- Avis -->
    <div class="mb-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <div class="mb-2">
            <span class="text-warning fs-4">★★★★★</span>
          </div>
          <h5 class="card-title">Topissime</h5>
          <h6 class="card-subtitle mb-2 text-muted">Sujet : Atelier</h6>
          <p class="card-text">
            Découverte de la sérigraphie à travers cet atelier convivial et intimiste. Clément est très sympa, le temps
            passe vite, et on repart avec un très joli T-shirt ! Au plaisir de revenir !
          </p>
        </div>
      </div>
    </div>

    <!-- Formulaire -->
    <div class="mb-5">
      <h2 class="mb-4">Contact</h2>
      <form>
        <div class="mb-3">
          <label for="email" class="form-label">Adresse email</label>
          <input type="email" class="form-control" id="email" placeholder="name@example.com">
        </div>
        <div class="mb-3">
          <label for="message" class="form-label">Demande</label>
          <textarea class="form-control" id="message" rows="3"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Envoyer</button>
      </form>
    </div>

  </div>
</template>

<style scoped>
.card-img-top {
  object-fit: cover;
  height: 200px;
}

.text-truncate {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.carousel-inner img {
  height: 300px;
  object-fit: cover;
}
</style>
