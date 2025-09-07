<script setup lang="ts">
import { onMounted } from "vue";
import { usePortfolioStore } from "@/stores/Portfolio";
import { useHead } from "@vueuse/head";

useHead({
  title: 'Portfolio | Windigo',
  meta: [
    { name: 'description', content: "Parcourez notre portfolio de sérigraphie artisanale : projets créatifs, textiles personnalisés et créations uniques Windigo." },
    { property: 'og:title', content: 'Portfolio | Windigo' },
    { property: 'og:description', content: "Découvrez les réalisations artisanales de notre atelier de sérigraphie : t-shirts, textiles et créations graphiques." },
    { property: 'og:url', content: 'https://windigo.com/portfolio' }
  ],
  link: [
    { rel: 'canonical', href: 'https://windigo.com/portfolio' }
  ]
})

const portfolioStore = usePortfolioStore();

onMounted(() => {
  portfolioStore.fetchPhotos();
});
</script>

<template>
  <div class="container py-4">
    <h2 class="mb-4">Portfolio</h2>

    <div v-if="portfolioStore.loading">Chargement...</div>
    <div v-if="portfolioStore.error" class="text-danger">{{ portfolioStore.error }}</div>

    <div class="row">
      <div v-for="photo in portfolioStore.photos" :key="photo.id" class="col-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100">
          <img :src="photo.src" class="card-img-top" alt="Portfolio" />
          <div class="card-body">
            <p class="card-text text-center">{{ photo.titre }}</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
