<script setup lang="ts">
import { onMounted } from "vue";
import { usePortfolioStore } from "@/stores/Portfolio";

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
