<template>
  <AppLayoutAdmin>
    <div class="container my-5">
      <p class="flex gap-2">
        <h2>Gestion des Catégories</h2>
        <button @click.prevent="newCategory" class="btn btn-success">Nouvelle catégorie</button>
      </p>

      <div v-if="showForm" class="card p-3 mb-4">
        <CategoryForm
          :form="currentProduct"
          :key="currentProduct ? currentProduct.id : 'new-category'"
          @reset="showForm = false"
        />
      </div>

      <table class="table table-striped">
        <thead>
          <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="category in categories" :key="category.id">
            <td>{{ category.id }}</td>
            <td>{{ category.name }}</td>
            <td class="flex gap-2">
              <button @click.prevent="edit(category)" class="px-2 py-1 bg-yellow-400 rounded">✏️</button>
              <button @click.prevent="deleteCategory(category)" class="px-2 py-1 bg-red-500 text-white rounded">🗑️</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";
import { Category } from "@/models";
import CategoryForm from "@/components/Form/CategoryForm.vue";
import { ref } from "vue";
import {router} from "@inertiajs/vue3";
import CategoryRepository from "@/services/CategoryRepository";

const props = defineProps<{ categories: Category[] }>()

const showForm = ref(false)

const currentProduct = ref<Category | undefined>()

function newCategory()
{
  currentProduct.value = undefined
  showForm.value = true
}

function edit(category: Category) {
  currentProduct.value = category
  showForm.value = true
}

function deleteCategory(category: Category) {
  const index = props.categories.findIndex((i: Category) => i.id === category.id)

  if (index !== -1) {
    CategoryRepository.deleteCategory(category).then(() => {
      props.categories.splice(index, 1)
      router.flash('toast', { message: 'Categorie supprimé avec succès', type: 'success'})
    })
  }
}
</script>

<style scoped>

</style>