<template>
  <div class="p-4">
    <h2 class="text-xl font-semibold mb-4">Gestion des Ateliers</h2>

    <!-- Table des ateliers -->
    <table class="w-full border border-gray-300 mb-6">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-2 py-1">ID</th>
          <th class="border px-2 py-1">Nom</th>
          <th class="border px-2 py-1">Type</th>
          <th class="border px-2 py-1">Prix</th>
          <th class="border px-2 py-1">Durée</th>
          <th class="border px-2 py-1">Age</th>
          <th class="border px-2 py-1">Image</th>
          <th class="border px-2 py-1">Description</th>
          <th class="border px-2 py-1">Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="workshop in store.workshops" :key="workshop.id">
          <td class="border px-2 py-1">{{ workshop.id }}</td>
          <td class="border px-2 py-1">{{ workshop.name }}</td>
          <td class="border px-2 py-1">{{ workshop.type }}</td>
          <td class="border px-2 py-1">{{ workshop.price }} €</td>
          <td class="border px-2 py-1">{{ workshop.duration }} min</td>
          <td class="border px-2 py-1">{{ workshop.age }} ans</td>

          <!-- Image principale -->
          <td class="border px-2 py-1">
            <img v-if="workshop.first_image_url" :src="workshop.first_image_url" class="table-image" />
            <span v-else>Aucune</span>
          </td>

          <!-- Description tronquée -->
          <td class="border px-2 py-1">
            {{ workshop.description
              ? (workshop.description.length > 100
                ? workshop.description.substring(0, 100) + '...'
                : workshop.description)
              : 'Aucune description' }}
          </td>
          <td class="border px-2 py-1 space-x-2">
            <button @click="editWorkshop(workshop)" class="px-2 py-1 bg-yellow-400 rounded">✏️</button>
            <button @click="deleteWorkshop(workshop.id)" class="px-2 py-1 bg-red-500 text-white rounded">🗑️</button>
            <RouterLink :to="{ name: 'admin.workshop.sessions', params: { id: workshop.id } }"
              class="px-2 py-1 bg-blue-500 text-white rounded">
              📅 Sessions
            </RouterLink>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Formulaire de création / édition -->
    <form @submit.prevent="saveWorkshop" class="space-y-3">
      <input v-model="form.name" placeholder="Nom" class="border p-2 w-full" required />
      <input v-model="form.type" placeholder="Type" class="border p-2 w-full" required />
      <input v-model.number="form.price" type="number" placeholder="Prix" class="border p-2 w-full" required />
      <input v-model.number="form.duration" type="number" placeholder="Durée (min)" class="border p-2 w-full"
        required />
      <input v-model.number="form.age" type="number" placeholder="Age minimum" class="border p-2 w-full" required />

      <!-- Description -->
      <textarea v-model="form.description" placeholder="Description" class="border p-2 w-full" rows="4"></textarea>

      <!-- Upload images multiples -->
      <div>
        <label class="block mb-1 font-medium">Images (plusieurs possibles)</label>
        <input type="file" multiple @change="handleFilesChange" class="border p-1 w-full" />
      </div>

      <!-- Aperçu images existantes et nouvelles -->
      <div class="flex flex-wrap gap-2 mt-2">
        <!-- Images existantes -->
        <div v-for="(img, index) in visibleImages" :key="'existing-' + index" class="relative">
          <img :src="`http://localhost:8000/storage/${img}`" class="table-image border" />
          <button type="button" @click="removedImages.push(img)"
            class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">x</button>
        </div>

        <!-- Nouvelles images sélectionnées -->
        <div v-for="(img, index) in previewImages" :key="'preview-' + index" class="relative">
          <img :src="img" class="table-image border" />
          <button type="button" @click="removePreviewImage(index)"
            class="absolute top-0 right-0 bg-red-600 text-white rounded-full w-5 h-5 text-xs flex items-center justify-center">x</button>
        </div>
      </div>

      <div class="space-x-2 mt-2">
        <button class="px-4 py-2 bg-blue-600 text-white rounded" :disabled="store.loading">
          {{ form.id ? "Mettre à jour" : "Créer" }}
        </button>
        <button type="button" @click="resetForm" class="px-4 py-2 bg-gray-300 rounded">Annuler</button>
      </div>
    </form>

    <div v-if="store.loading" class="mt-4 text-blue-600">Chargement...</div>
    <div v-if="store.error" class="mt-4 text-red-600">{{ store.error }}</div>
  </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted, computed } from 'vue'
import { useWorkshopStore } from '@/stores/Workshop'
import type { Workshop } from '@/_models/Workshop'

const store = useWorkshopStore()

const form = reactive<Workshop>({
  id: 0,
  name: '',
  type: '',
  price: 0,
  duration: 0,
  age: 0,
  description: '',
  images: [] as string[], // <-- préciser le type
})

const previewImages = ref<string[]>([])
const files = ref<File[]>([])
const removedImages = ref<string[]>([])

onMounted(() => store.fetchWorkshops(true))

const handleFilesChange = (event: Event) => {
  const target = event.target as HTMLInputElement
  if (!target.files) return
  files.value = Array.from(target.files)
  previewImages.value = files.value.map(f => URL.createObjectURL(f))
}

const removePreviewImage = (index: number) => {
  files.value.splice(index, 1)
  previewImages.value.splice(index, 1)
}

// computed pour filtrer les images existantes à afficher
const visibleImages = computed(() => {
  return (form.images || []).filter(img => !removedImages.value.includes(img))
})

const saveWorkshop = async () => {
  store.loading = true
  try {
    const formData = new FormData()
    formData.append('name', form.name)
    formData.append('type', form.type)
    formData.append('price', String(form.price))
    formData.append('duration', String(form.duration))
    formData.append('age', String(form.age))
    formData.append('description', form.description || '')

    files.value.forEach(f => formData.append('images[]', f))
    removedImages.value.forEach(img => formData.append('removed_images[]', img))

    if (form.id) {
      await store.updateWorkshop(form.id, formData)
    } else {
      await store.createWorkshop(formData)
    }

    resetForm()
  } catch (err: any) {
    store.error = err.message
  } finally {
    store.loading = false
  }
}

const editWorkshop = (workshop: Workshop) => {
  Object.assign(form, workshop)
  previewImages.value = []
  files.value = []
  removedImages.value = []
}

const resetForm = () => {
  form.id = 0
  form.name = ''
  form.type = ''
  form.price = 0
  form.duration = 0
  form.age = 0
  form.description = ''
  form.images = []
  previewImages.value = []
  files.value = []
  removedImages.value = []
}

const deleteWorkshop = async (id: number) => {
  if (confirm("Voulez-vous vraiment supprimer cet atelier ?")) {
    store.loading = true
    try {
      await store.deleteWorkshop(id)
      store.workshops = store.workshops.filter(w => w.id !== id)
    } catch (err: any) {
      store.error = err.message
    } finally {
      store.loading = false
    }
  }
}
</script>

<style scoped>
.table-image {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 6px;
}
</style>
