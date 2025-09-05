<script setup lang="ts">
import { onMounted, ref } from 'vue';
import { useProductStore } from '@/stores/Product';
import { useCartStore } from '@/stores/Cart';
import { getProducts } from '@/_services/ProductService';
import { setCart } from '@/_services/CartService';
import AppToast from '@/components/AppToast.vue';

const productStore = useProductStore();
const cartStore = useCartStore();
const quantities = ref<{ [key: number]: number }>({});
const toastMessage = ref<string | null>(null);
const toastType = ref<'success' | 'danger'>('success');

onMounted(async () => {
  try {
    const data = await getProducts();
    // Assurer que data est un tableau
    const productsArray = Array.isArray(data) ? data : [];
    productStore.setProducts(productsArray);
    productsArray.forEach(p => (quantities.value[p.id] = 1));
  } catch (error) {
    console.error('Erreur récupération produits :', error);
  }
});

async function handleAddToCart(productId: number) {
  try {
    const currentItem = cartStore.items.find(i => i.product_id === productId);
    const currentQuantity = currentItem?.quantity ?? 0;
    const quantityToAdd = quantities.value[productId] || 1;
    const newQuantity = currentQuantity + quantityToAdd;

    await setCart(productId, newQuantity);

    toastMessage.value = 'Produit ajouté au panier 🛒';
    toastType.value = 'success';
  } catch (error) {
    console.error('Erreur ajout au panier :', error);
    toastMessage.value = "Impossible d'ajouter le produit au panier";
    toastType.value = 'danger';
  }
}

</script>

<template>
  <div class="container my-5">
    <h2 class="mb-4">Boutique</h2>
    <div class="row">
      <div
        v-for="product in productStore.products"
        :key="product.id"
        class="col-md-4 mb-4"
      >
      <RouterLink :to="{ name: 'produit-detail', params: { id: product.id } }">
        <div class="card h-100 p-3 shadow-sm border-0 rounded-3">
          <div v-if="product.picture" class="mb-3">
            <img
              :src="product.picture_url"
              :alt="product.name"
              class="img-fluid rounded-3 shadow-sm"
            />
          </div>
          <div class="card-body d-flex flex-column">
            <h5 class="card-title text-truncate">{{ product.name }}</h5>
            <p class="fw-bold">{{ product.price }} €</p>
            <p v-if="product.stock !== undefined">Stock : {{ product.stock }}</p>
            <input
              type="number"
              min="1"
              :max="product.stock"
              v-model.number="quantities[product.id]"
              class="form-control mb-2"
            />
            <button
              class="btn btn-primary w-100"
              @click="handleAddToCart(product.id)"
            >
              Ajouter au panier
            </button>
          </div>
        </div>
        </RouterLink>
      </div>
      
    </div>
  </div>
  <AppToast v-model="toastMessage" :type="toastType" />
</template>

<style scoped>
.card {
  transition: transform 0.2s ease-in-out;
}
.card:hover {
  transform: translateY(-5px);
}
.card img {
  max-height: 300px;
  object-fit: contain;
}
.card-body {
  padding: 1rem;
}
</style>
