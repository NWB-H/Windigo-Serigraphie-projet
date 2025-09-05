<script setup lang="ts">
import { onMounted } from 'vue';
import { useWorkshopStore } from '@/stores/Workshop';

const workshopStore = useWorkshopStore();

onMounted(() => {
  workshopStore.fetchWorkshops();
});

const formatDate = (dateStr: string) => {
  const d = new Date(dateStr);
  return d.toLocaleDateString('fr-FR', {
    weekday: 'short',
    day: '2-digit',
    month: 'short',
    year: 'numeric'
  });
};
</script>

<template>
  <div class="container my-5">
    <h2 class="mb-4 text-center">Nos Ateliers</h2>

    <!-- Chargement -->
    <div v-if="workshopStore.loading" class="text-center my-5">
      <div class="spinner-border" role="status">
        <span class="visually-hidden">Chargement...</span>
      </div>
    </div>

    <!-- Erreur -->
    <div v-else-if="workshopStore.error" class="alert alert-danger text-center">
      {{ workshopStore.error }}
    </div>

    <!-- Liste des ateliers -->
    <div v-else class="row g-4">
      <div v-for="workshop in workshopStore.workshops" :key="workshop.id" class="col-12 col-md-6 col-lg-4">
        <RouterLink :to="{ name: 'atelier-detail', params: { id: workshop.id } }">
          <div class="card h-100 shadow-sm">
            <!-- Image principale via accessor -->
            <div v-if="workshop.first_image_url" class="mb-3">
              <img :src="workshop.first_image_url" :alt="workshop.name" class="card-image" />
            </div>

            <div class="card-body d-flex flex-column">
              <h5 class="card-title">{{ workshop.name }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">{{ workshop.type }}</h6>
              <p class="card-text mb-1"><strong>Prix :</strong> {{ workshop.price }} €</p>
              <p class="card-text mb-2"><strong>Durée :</strong> {{ workshop.duration }} min</p>
              <p class="card-text mb-2"><strong>Âge minimum :</strong> {{ workshop.age }} ans</p>

              <RouterLink class="btn btn-primary mt-3 w-100"
                :to="{ name: 'atelier-detail', params: { id: workshop.id } }">
                Voir détails & Réserver
              </RouterLink>
            </div>
          </div>
        </RouterLink>
      </div>
    </div>
  </div>
</template>

<style scoped>
.card {
  border-radius: 12px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

.card-image {
  width: 100%;
  max-height: 180px;
  object-fit: cover;
  border-radius: 8px;
}
</style>
