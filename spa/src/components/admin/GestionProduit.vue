<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useProductStore } from '@/stores/Product';
import type { Product } from '@/_models/Product';

// services
import { getCategories } from '@/_services/CategoryService';
import { getOptions } from '@/_services/OptionService';

const store = useProductStore();
const showForm = ref(false);
const editingProduct = ref<Product | null>(null);

const categories = ref<any[]>([]);
const options = ref<any[]>([]);

// Formulaire initial pour nouvel ajout
function getEmptyProduct(): Product {
  return {
    id: 0,
    name: '',
    price: 0,
    stock: 0,
    description: '',
    archived: false,
    picture: null,
    category: undefined,
    option: undefined
  };
}

function removeImage() {
  if (!editingProduct.value) return;

  // Supprime l'image côté formulaire
  editingProduct.value.picture = null;

  // Si c'est un produit existant, mets à jour dans le store pour que le tableau reflète le changement
  if (editingProduct.value.id > 0) {
    const index = store.products.findIndex(p => p.id === editingProduct.value!.id);
    if (index !== -1) {
      store.products[index].picture = null;
    }
  }
}


onMounted(async () => {
  await store.fetchAdminProducts();

  // récupération des catégories et options
  categories.value = await getCategories();
  options.value = await getOptions();
});

function startEdit(product?: Product) {
  if (product) {
    editingProduct.value = { ...product };
  } else {
    editingProduct.value = getEmptyProduct();
  }
  showForm.value = true;
}

function cancelEdit() {
  editingProduct.value = null;
  showForm.value = false;
}

async function saveProduct() {
  if (!editingProduct.value) return;

  try {
    const formData = new FormData();
    formData.append('name', editingProduct.value.name);
    formData.append('price', String(Math.floor(editingProduct.value.price)));
    formData.append('stock', String(editingProduct.value.stock));
    formData.append('description', editingProduct.value.description);
    formData.append('archived', editingProduct.value.archived ? '1' : '0');
    formData.append('option_id', String(editingProduct.value.option?.id ?? ''));
    formData.append('category_id', String(editingProduct.value.category?.id ?? ''));

    // Si picture est null, on envoie une clé vide pour signaler la suppression
    if (editingProduct.value.picture instanceof File) {
      formData.append('picture', editingProduct.value.picture);
    } else if (editingProduct.value.picture === null) {
      formData.append('picture', ''); // Laravel recevra '' => suppression
    }

    if (editingProduct.value.id && editingProduct.value.id > 0) {
      await store.updateAdminProduct(editingProduct.value.id, formData);
    } else {
      await store.createAdminProduct(formData);
    }

    showForm.value = false;
    editingProduct.value = null;
  } catch (error: any) {
    console.error('Erreur sauvegarde produit :', error.response?.data || error);
  }
}

async function deleteProduct(id: number) {
  if (!confirm('Voulez-vous vraiment supprimer ce produit ?')) return;
  try {
    await store.deleteAdminProduct(id);
  } catch (error) {
    console.error('Erreur suppression produit :', error);
  }
}
</script>

<template>
  <div class="container my-5">
    <h2>Gestion Produits</h2>
    <button class="btn btn-success mb-3" @click="startEdit()">Ajouter un produit</button>

    <!-- Formulaire -->
    <div v-if="showForm" class="card p-3 mb-4">
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
        <tr v-for="product in store.products" :key="product.id">
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
            <button class="btn btn-sm btn-warning me-2" @click="startEdit(product)">Modifier</button>
            <button class="btn btn-sm btn-danger" @click="deleteProduct(product.id)">Supprimer</button>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>
