<template>
  <AppLayoutAdmin>
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
        <tr v-for="workshop in workshops" :key="workshop.id">
          <td class="border px-2 py-1">{{ workshop.id }}</td>
          <td class="border px-2 py-1">{{ workshop.name }}</td>
          <td class="border px-2 py-1">{{ workshop.type }}</td>
          <td class="border px-2 py-1">{{ workshop.price }} €</td>
          <td class="border px-2 py-1">{{ workshop.duration }} min</td>
          <td class="border px-2 py-1">{{ workshop.age }} ans</td>

          <!-- Image principale -->
          <td class="border px-2 py-1">
            <AppImage :url="workshop.first_image_url" :alt="workshop.name" imgCssClass="table-image"  />
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
            <button @click="deleteWorkshop(workshop)" class="px-2 py-1 bg-red-500 text-white rounded">🗑️</button>
            <RouterLink :to="{ name: 'admin.workshop.sessions', params: { id: workshop.id } }"
                        class="px-2 py-1 bg-blue-500 text-white rounded">
              📅 Sessions
            </RouterLink>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </AppLayoutAdmin>
</template>

<script setup lang="ts">
import {Workshop} from "@/models";
import AppImage from "@/components/AppImage.vue";
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";

defineProps<{ workshops: Workshop[] }>()

function editWorkshop(workshop: Workshop) {}
function deleteWorkshop(workshop: Workshop) {}
</script>

<style scoped>
.table-image {
  width: 60px;
  height: 60px;
  object-fit: cover;
  border-radius: 6px;
}
</style>