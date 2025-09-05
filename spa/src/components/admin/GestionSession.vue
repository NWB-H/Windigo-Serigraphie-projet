<template>
  <div class="container mt-4">
    <!-- Header avec bouton retour -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2>Sessions de l’atelier : {{ workshopStore.currentWorkshop?.name }}</h2>
      <router-link to="/admin" class="btn btn-secondary">
        ← Retour aux ateliers
      </router-link>
    </div>

    <!-- Indicateur total sessions et places disponibles -->
    <div class="mb-3">
      <span class="badge bg-info me-2">
        Total sessions : {{ workshopStore.sessions.length }}
      </span>
      <span class="badge bg-success">
        Total places disponibles : {{ totalRemainingPlaces }}
      </span>
    </div>

    <!-- Table des sessions -->
    <div class="card mb-4">
      <div class="card-header">Liste des sessions</div>
      <div class="card-body p-0">
        <table class="table table-striped mb-0">
          <thead>
            <tr>
              <th>#</th>
              <th>Date</th>
              <th>Capacité</th>
              <th>Places restantes</th>
              <th class="text-end">Actions</th>
            </tr>
          </thead>
          <tbody v-if="workshopStore.workshopSession?.workshop_sessions">
            <tr v-for="s in workshopStore.workshopSession?.workshop_sessions" :key="s.id">
              <td>{{ s.session_number }}</td>
              <td>{{ new Date(s.date).toLocaleString() }}</td>
              <td>{{ s.capacity }}</td>
              <td>{{ s.remaining_places }}</td>
              <td class="text-end">
                <button class="btn btn-sm btn-warning me-2" @click="editSession(s)">
                  Modifier
                </button>
                <button class="btn btn-sm btn-danger" @click="deleteSession(s.id)">
                  Supprimer
                </button>
              </td>
            </tr>
            <tr v-if="!workshopStore.sessions.length">
              <td colspan="5" class="text-center text-muted">
                Aucune session pour cet atelier.
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Formulaire création/édition -->
    <div class="card">
      <div class="card-header">
        {{ editingSession ? "Modifier la session" : "Ajouter une nouvelle session" }}
      </div>
      <div class="card-body">
        <form @submit.prevent="saveSession">
          <div class="mb-3">
            <label class="form-label">Date</label>
            <input type="datetime-local" class="form-control" v-model="form.date" required />
          </div>
          <div class="mb-3">
            <label class="form-label">Capacité</label>
            <input type="number" class="form-control" v-model="form.capacity" required min="1" />
          </div>
          <button type="submit" class="btn btn-primary">
            {{ editingSession ? "Mettre à jour" : "Créer" }}
          </button>
          <button type="button" v-if="editingSession" class="btn btn-secondary ms-2" @click="resetForm">
            Annuler
          </button>
        </form>
      </div>
    </div>

    <!-- Message de chargement / erreur -->
    <div v-if="workshopStore.loading" class="mt-3 alert alert-info">Chargement...</div>
    <div v-if="workshopStore.error" class="mt-3 alert alert-danger">{{ workshopStore.error }}</div>
  </div>
</template>

<script setup lang="ts">
import { onMounted, reactive, ref, computed } from "vue"
import { useRoute } from "vue-router"
import { useWorkshopStore } from "@/stores/Workshop"

const workshopStore = useWorkshopStore()
const route = useRoute()
const workshopId = Number(route.params.id)

const form = reactive({
  date: "",
  capacity: 1
})

const editingSession = ref<null | number>(null)

// Computed pour total places restantes
const totalRemainingPlaces = computed(() =>
  workshopStore.sessions.reduce((sum, s) => sum + (s.remaining_places ?? 0), 0)
)

onMounted(async () => {
  await workshopStore.fetchWorkshopById(workshopId)
})

// Réinitialiser le formulaire
function resetForm() {
  editingSession.value = null
  form.date = ""
  form.capacity = 1
}

// Sauvegarder / créer une session
async function saveSession() {
  const payload = {
    ...form,
    date: form.date.replace('T', ' ') // format Laravel
  }

  try {
    if (editingSession.value) {
      await workshopStore.updateSession(workshopId, editingSession.value, payload)
    } else {
      await workshopStore.createSession(workshopId, payload)
    }
    await workshopStore.fetchWorkshopById(workshopId)
    resetForm()
  } catch (err: any) {
    workshopStore.error = err.response?.data?.message || "Erreur lors de la sauvegarde"
  }
}

// Éditer une session existante
function editSession(session: any) {
  editingSession.value = session.id
  form.date = session.date.replace(' ', 'T')
  form.capacity = session.capacity
}

// Supprimer une session
async function deleteSession(id: number) {
  if (confirm("Supprimer cette session ?")) {
    try {
      await workshopStore.deleteSession(workshopId, id)
      workshopStore.sessions = workshopStore.sessions.filter(s => s.id !== id)
    } catch (err: any) {
      workshopStore.error = err.response?.data?.message || "Erreur lors de la suppression"
    }
  }
}
</script>
