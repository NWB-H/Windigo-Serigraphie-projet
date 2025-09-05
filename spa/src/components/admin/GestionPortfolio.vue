<script setup lang="ts">
import { onMounted, ref } from "vue";
import { usePortfolioStore } from "@/stores/Portfolio";

const portfolioStore = usePortfolioStore();

const titre = ref("");
const file = ref<File | null>(null);

onMounted(() => {
  portfolioStore.fetchPhotos().then(() => {
   console.log(portfolioStore.photos.map(p => p.src));
  });
});


function onFileSelected(event: Event) {
  const input = event.target as HTMLInputElement;
  if (!input.files?.length) return;
  file.value = input.files[0];
}

function addPhoto() {
  if (!file.value) return;
  portfolioStore.addPhoto(titre.value, file.value);
  titre.value = "";
  file.value = null;
}

function removePhoto(id: number) {
  portfolioStore.deletePhoto(id);
}
</script>

<template>
  <div class="container py-4">
    <h2 class="mb-4">Gestion du Portfolio</h2>

    <div class="mb-3">
      <input type="text" v-model="titre" class="form-control mb-2" placeholder="Titre de l’image (optionnel)" />
      <input type="file" class="form-control mb-2" @change="onFileSelected" />
      <button class="btn btn-primary" @click="addPhoto">Ajouter</button>
    </div>

    <div v-if="portfolioStore.loading">Chargement...</div>
    <div v-if="portfolioStore.error" class="text-danger">{{ portfolioStore.error }}</div>

    <div class="row">
      <div v-for="photo in portfolioStore.photos" :key="photo.id" class="col-6 col-md-4 col-lg-3 mb-4">
        <div class="card h-100">
          <img :src="photo.src" class="card-img-top" alt="Portfolio" />
          <div class="card-body text-center">
            <p>{{ photo.titre }}</p>
            <button class="btn btn-danger btn-sm" @click="removePhoto(photo.id)">Supprimer</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
