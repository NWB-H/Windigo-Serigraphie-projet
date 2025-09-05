<template>
  <div class="d-flex vh-100">
    <!-- Sidebar -->
    <aside class="bg-dark text-white d-flex flex-column" style="width: 220px;">
      <div class="p-3 border-bottom border-secondary d-flex align-items-center">
        <i class="bi bi-gear-fill me-2"></i>
        <h1 class="h5 mb-0">Back Office</h1>
      </div>
      <nav class="flex-grow-1 p-2">
        <button
          v-for="link in links"
          :key="link.name"
          @click="currentTab = link.component"
          :class="[
            'btn w-100 text-start d-flex align-items-center mb-2',
            currentTab === link.component ? 'btn-secondary' : 'btn-dark',
          ]"
        >
          <i :class="link.icon + ' me-2'"></i>
          {{ link.name }}
        </button>
      </nav>
    </aside>

    <!-- Main content -->
    <main class="flex-fill p-4 bg-light overflow-auto">
      <component :is="currentTab" />
    </main>
  </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

// Import des composants admin
import GestionProduit from '@/components/admin/GestionProduit.vue'
import GestionAtelier from '@/components/admin/GestionAtelier.vue'
import GestionCategorie from '@/components/admin/GestionCategorie.vue'
import GestionOption from '@/components/admin/GestionOption.vue'
import GestionPortfolio from '@/components/admin/GestionPortfolio.vue'

// Liens avec icônes Bootstrap Icons
const links = [
  { name: 'Produits', component: GestionProduit, icon: 'bi bi-box-seam' },
  { name: 'Ateliers', component: GestionAtelier, icon: 'bi bi-brush' },
  { name: 'Catégories', component: GestionCategorie, icon: 'bi bi-tags' },
  { name: 'Options', component: GestionOption, icon: 'bi bi-sliders' },
  { name: 'Portfolio', component: GestionPortfolio, icon: '' },
]

const currentTab = ref(links[0].component)
</script>

<style scoped>
button {
  transition: background 0.2s, color 0.2s;
}
button:hover {
  background-color: #495057 !important;
}
</style>
