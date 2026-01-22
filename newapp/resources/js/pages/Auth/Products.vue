<template>
  <AppLayoutAdmin>
    <div class="container my-5">
      <h2>Gestion Produits</h2>
      <button class="btn btn-success mb-3" @click="newProduct()">Ajouter un produit</button>

      <!-- Formulaire -->
      <div v-if="showForm" class="card p-3 mb-4">
        <ProductForm
          :options="options"
          :categories="categories"
          :form="currentProduct"
          :key="currentProduct ? currentProduct.id : 'new-product'"
          @close="showForm = false"
        />
      </div>

      <!-- Table produits -->
      <table class="table table-striped">
        <thead>
        <tr>
          <th>Nom</th>
          <th>Prix</th>
          <th>Stock</th>
          <th>Description</th>
          <th>Catégorie</th>
          <th>Option</th>
          <th>Archivé</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="product in products" :key="product.id">
          <td>{{ product.name }}</td>
          <td>{{ product.price }} €</td>
          <td>{{ product.stock }}</td>
          <td>
            {{ product.description.length > 50 ? product.description.slice(0, 50) + '...' : product.description }}
          </td>
          <td>{{ product.category?.name || '-' }}</td>
          <td>{{ product.option?.name || '-' }}</td>
          <td>{{ product.archived ? 'Oui' : 'Non' }}</td>
          <td>
            <img v-if="product.picture" :src="product.picture_url" alt="Image produit"
                 style="width: 50px; height: 50px; object-fit: cover;" />
            <span v-else>-</span>
          </td>

          <td>
            <button class="btn btn-sm btn-warning me-2" type="button" @click="edit(product)">Modifier</button>
            <button class="btn btn-sm btn-danger" type="button" @click="deleteProduct(product)">Supprimer</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";
import { Product, Category, Option } from "@/models";
import { ref } from "vue";
import ProductForm from "@/components/Form/ProductForm.vue";
import ProductRepository from "@/services/ProductRepository";
import { router } from '@inertiajs/vue3'

const props = defineProps<{
  products: Product[],
  categories: Category[],
  options: Option[],
}>()

const showForm = ref(false)

const currentProduct = ref<Product | undefined>(undefined)

function newProduct() {
  currentProduct.value = undefined

  showForm.value = true
}

function edit(product: Product) {
  currentProduct.value = product

  showForm.value = true
}

function deleteProduct(product: Product) {
  const index = props.products.findIndex((i: Product) => i.id === product.id)

  if (index !== -1) {
    ProductRepository.deleteProduct(product).then(() => {
      props.products.splice(index, 1)
      router.flash('toast', { message: 'Produit supprimé', type: 'success' })
    })
  }
}
</script>

<style scoped>

</style>