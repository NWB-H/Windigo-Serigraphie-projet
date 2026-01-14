<template>
  <AppLayoutAdmin>
    <div class="container my-5">
      <h2>Gestion Produits</h2>
      <button class="btn btn-success mb-3">Ajouter un produit</button>

      <!-- Formulaire -->
      <div v-if="true === false" class="card p-3 mb-4">
        <input v-model="editingProduct!.name" class="form-control mb-2" placeholder="Nom" />
        <input type="number" v-model.number="editingProduct!.price" class="form-control mb-2" placeholder="Prix (1-50)" />
        <input type="number" v-model.number="editingProduct!.stock" class="form-control mb-2" placeholder="Stock" />
        <textarea v-model="editingProduct!.description" class="form-control mb-2" placeholder="Description"></textarea>

        <!-- Archived -->
        <div class="form-check mb-2">
          <input type="checkbox" v-model="editingProduct!.archived" class="form-check-input" id="archived" />
          <label class="form-check-label" for="archived">Archivé</label>
        </div>

        <!-- Category -->
        <select v-model="editingProduct!.category" class="form-select mb-2">
          <option disabled value="">-- Choisir une catégorie --</option>
          <option v-for="c in categories" :key="c.id" :value="c">{{ c.name }}</option>
        </select>

        <!-- Option -->
        <select v-model="editingProduct!.option" class="form-select mb-2">
          <option disabled value="">-- Choisir une option --</option>
          <option v-for="o in options" :key="o.id" :value="o">{{ o.name }}</option>
        </select>

        <!-- Picture -->
        <input type="file" class="form-control mb-2"
               @change="e => editingProduct!.picture = (e.target as HTMLInputElement).files?.[0] || null" />
        <div v-if="editingProduct?.picture" class="mb-2 d-flex align-items-center">
          <img :src="typeof editingProduct.picture === 'string' ? editingProduct.picture : ''" alt="Aperçu"
               style="width: 100px; height: 100px; object-fit: cover; margin-right: 10px;" />
          <button type="button" class="btn btn-sm btn-danger" @click="removeImage">
            Supprimer l'image
          </button>

        </div>


        <button class="btn btn-primary me-2" @click="saveProduct">Enregistrer</button>
        <button class="btn btn-secondary" @click="cancelEdit">Annuler</button>
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
            <button class="btn btn-sm btn-warning me-2">Modifier</button>
            <button class="btn btn-sm btn-danger">Supprimer</button>
          </td>
        </tr>
        </tbody>
      </table>
    </div>
  </AppLayoutAdmin>
</template>

<script setup lang="ts">
import AppLayoutAdmin from "@/layouts/AppLayoutAdmin.vue";
import { Product } from "@/models/Product";

defineProps<{ products: Product[] }>()
</script>

<style scoped>

</style>