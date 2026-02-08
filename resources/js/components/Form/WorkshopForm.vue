<script setup lang="ts">

</script>

<template>
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
        <img :src="`https://back.windigoprint.com/storage/${img}`" class="table-image border" />
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
</template>

<style scoped>

</style>