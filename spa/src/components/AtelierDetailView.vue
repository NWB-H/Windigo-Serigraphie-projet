<script setup lang="ts">
import { onMounted, ref, nextTick } from 'vue'
import { useRoute } from 'vue-router'
import { useWorkshopStore } from '@/stores/Workshop'
import AppToast from '@/components/AppToast.vue'
import router from '@/router'

const route = useRoute()
const workshopStore = useWorkshopStore()
const workshop = ref<any>(null)

// état du toast
const toastMessage = ref<string | null>(null)
const toastType = ref<'success' | 'danger'>('success')

// ref sur le conteneur des miniatures
const thumbnailsContainer = ref<HTMLElement | null>(null)

// récupération atelier + synchronisation carrousel
onMounted(async () => {
  await workshopStore.fetchWorkshopById(Number(route.params.id))
  workshop.value = workshopStore.currentWorkshop

  await nextTick() // attendre que le DOM soit rendu

  const carouselEl = document.getElementById("workshopCarousel")
  if (carouselEl && thumbnailsContainer.value) {
    const thumbs = Array.from(thumbnailsContainer.value.querySelectorAll('.thumbnail'))

    // mettre la première miniature active
    thumbs.forEach((t, i) => t.classList.toggle('active', i === 0))

    // écoute du carrousel pour changer la miniature active
    carouselEl.addEventListener('slid.bs.carousel', (event: any) => {
      const index = event.to
      thumbs.forEach((t, i) => t.classList.toggle('active', i === index))
      // centrage retiré
    })
  }
})

const formatDate = (dateStr: string): string => {
  const d = new Date(dateStr)
  return d.toLocaleDateString('fr-FR', { weekday: 'long', day: '2-digit', month: 'long', year: 'numeric' })
}

const handleBooking = async (sessionId: number) => {
  const result = await workshopStore.bookSession(sessionId)
  if (result) {
    toastMessage.value = "Votre réservation a bien été enregistrée ✅"
    toastType.value = "success"
  } else {
    toastMessage.value = workshopStore.error || "Une erreur est survenue ❌"
    toastType.value = "danger"
  }
}
</script>

<template>
  <div class="container my-5" v-if="workshop">
    <div class="row mb-4">

      <div class="col-md-6">
        <button class="btn btn-outline-primary mb-3" @click="router.push('/ateliers')">
          ← Retour à la boutique
        </button>

        <!-- Carrousel principal -->
        <div v-if="workshop.images?.length" id="workshopCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <div v-for="(img, index) in workshop.images" :key="index"
              :class="['carousel-item', { active: index === 0 }]">
              <img :src="`http://localhost:8000/storage/${img}`" class="d-block w-100 rounded" />
            </div>
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#workshopCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#workshopCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>
        </div>
        <!-- Miniatures -->
        <div v-if="workshop.images?.length > 1" ref="thumbnailsContainer"
          class="mt-3 d-flex flex-wrap gap-2 justify-content-center">
          <img v-for="(img, index) in workshop.images" :key="'thumb-' + index"
            :src="`http://localhost:8000/storage/${img}`" class="thumbnail"
            style="width: 80px; height: 80px; object-fit: cover; cursor: pointer;" :data-bs-target="'#workshopCarousel'"
            :data-bs-slide-to="index" />
        </div>

        <div v-else class="border rounded p-3 text-center text-muted">Aucune image disponible</div>
      </div>

      <div class="col-md-6">
        <h2>{{ workshop.name }}</h2>
        <h5 class="text-muted">{{ workshop.type }}</h5>
        <p><strong>Prix :</strong> {{ workshop.price }} €</p>
        <p><strong>Durée :</strong> {{ workshop.duration }} min</p>
        <p><strong>Âge minimum :</strong> {{ workshop.age }} ans</p>
        <p class="mt-3">{{ workshop.description }}</p>
      </div>
    </div>

    <h4 class="mt-5">Sessions disponibles</h4>
    <!-- Sessions -->
    <div v-if="workshop.workshop_sessions?.length" class="mt-auto">
      <h6>Sessions :</h6>
      <ul class="list-group list-group-flush">
        <li v-for="session in workshop.workshop_sessions" :key="session.id"
          class="list-group-item d-flex justify-content-between align-items-center">
          {{ formatDate(session.date) }} - N°{{ session.session_number }}
          <span class="badge bg-primary rounded-pill">{{ session.remaining_places }} places</span>
          <button @click="handleBooking(session.id)"> Reserver </button>
        </li>
      </ul>
    </div>
    <p v-else>Aucune session prévue pour le moment.</p>
  </div>

  <!-- Toast réutilisable -->
  <AppToast v-model="toastMessage" :type="toastType" />
</template>

<style scoped>
.carousel-item img {
  height: 300px;
  object-fit: cover;
}

.card {
  border-radius: 12px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
}

/* Miniatures */
.thumbnail {
  border: 2px solid transparent;
  border-radius: 6px;
  transition: border-color 0. ease, transform 0.2s ease, box-shadow 0.3s ease;
}

.thumbnail:hover {
  transform: scale(1.05);
}

.thumbnail.active {
  border-color: #0d6efd;
  box-shadow: 0 0 6px rgba(13, 110, 253, 0.5);
}
</style>
