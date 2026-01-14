<template>
  <div>
    <AppHeader />
      <div class="d-flex">
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
                class="btn btn-dark w-100 text-start d-flex align-items-center mb-2"
            >
              <i :class="link.icon + ' me-2'"></i>
              {{ link.name }}
            </button>
          </nav>
        </aside>

        <!-- Main content -->
        <main class="position-relative">
          <slot />
          <NotificationsContainer />
        </main>
      </div>
    <AppFooter />
  </div>
</template>

<script setup lang="ts">
import AppFooter from "@/components/AppFooter.vue";
import AppHeader from "@/components/AppHeader.vue";
import NotificationsContainer from "@/components/Notifications/NotificationsContainer.vue";

const links = [
  { name: 'Produits', icon: 'bi bi-box-seam' },
  { name: 'Ateliers', icon: 'bi bi-brush' },
  { name: 'Catégories', icon: 'bi bi-tags' },
  { name: 'Options', icon: 'bi bi-sliders' },
  { name: 'Portfolio', icon: '' },
]

</script>

<style>
main {
  flex: 1;
  justify-content: center;
  min-height: 80vh;
  font-family: 'Oswald', sans-serif;
  font-weight: 200; /* Extralight */
}
</style>

