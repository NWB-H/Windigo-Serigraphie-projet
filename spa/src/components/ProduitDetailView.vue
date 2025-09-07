<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useCartStore } from '@/stores/Cart';
import { getProduct } from '@/_services/ProductService';
import { setCart } from '@/_services/CartService';
import AppToast from '@/components/AppToast.vue';
import { useHead } from '@vueuse/head';

const route = useRoute();
const router = useRouter();
const cartStore = useCartStore();

const product = ref<any>(null);
const quantity = ref<number>(1);
const toastMessage = ref<string | null>(null);
const toastType = ref<'success' | 'danger'>('success');

// Index de l'image sélectionnée pour la galerie
const selectedIndex = ref(0);

onMounted(async () => {
  const id = Number(route.params.id);
  try {
    product.value = await getProduct(id);

    useHead({
      title: `${product.value.name} | Windigo`,
      meta: [
        { name: 'description', content: product.value.description?.substring(0, 155) },
        { property: 'og:title', content: `${product.value.name} | Windigo` },
        { property: 'og:description', content: product.value.description },
        { property: 'og:image', content: product.value.picture_url || product.value.images_urls?.[0] },
        { property: 'og:url', content: `https://windigo.com/produit/${product.value.id}` }
      ],
      link: [
        { rel: 'canonical', href: `https://windigo.com/produit/${product.value.id}` }
      ]
    })

    // Normaliser les images pour toujours avoir un tableau d'URLs
    product.value.images_urls = [];
    if (product.value.images && product.value.images.length) {
      product.value.images_urls = product.value.images.map((img: any) =>
        typeof img === 'string' ? img : ''
      );
    } else if (product.value.picture_url) {
      product.value.images_urls = [product.value.picture_url];
    }
  } catch (error) {
    console.error('Erreur récupération produit :', error);
  }
});

const handleAddToCart = async (productId: number) => {
  try {
    const currentItem = cartStore.items.find(i => i.product_id === productId);
    const currentQuantity = currentItem?.quantity ?? 0;
    const newQuantity = currentQuantity + quantity.value;
    await setCart(productId, newQuantity);

    toastMessage.value = 'Produit ajouté au panier 🛒';
    toastType.value = 'success';
  } catch (error) {
    console.error('Erreur ajout au panier :', error);
    toastMessage.value = "Impossible d'ajouter le produit au panier";
    toastType.value = 'danger';
  }
};
</script>

<template>
  <div class="container my-5" v-if="product">
    <button class="btn btn-outline-primary mb-3" @click="router.push('/boutique')">
      ← Retour à la boutique
    </button>

    <h2 class="mb-4">{{ product.name }}</h2>

    <div class="row">
      <!-- Galerie images -->
      <div class="col-md-6" v-if="product.images_urls.length">
        <!-- Image principale -->
        <div class="mb-3 text-center">
          <img :src="product.images_urls[selectedIndex]" class="w-100 rounded main-image" :alt="product.name" />
        </div>

        <!-- Miniatures -->
        <div class="d-flex justify-content-center gap-2 flex-wrap">
          <div v-for="(img, index) in product.images_urls" :key="index" class="thumbnail-wrapper" @click="selectedIndex = index">
            <img :src="img" class="thumbnail" :class="{ active: index === selectedIndex }" />
          </div>
        </div>
      </div>

      <!-- Infos produit -->
      <div class="col-md-6">
        <p class="fw-bold fs-4">{{ product.price }} €</p>
        <p v-if="product.stock !== undefined">Stock : {{ product.stock }}</p>
        <p class="mb-3">{{ product.description }}</p>

        <div class="mb-3">
          <label class="form-label">Quantité</label>
          <input type="number" min="1" :max="product.stock" v-model.number="quantity" class="form-control" />
        </div>

        <button class="btn btn-primary w-100" @click="handleAddToCart(product.id)">
          Ajouter au panier
        </button>
      </div>
    </div>
  </div>

  <!-- Toast réutilisable -->
  <AppToast v-model="toastMessage" :type="toastType" />
</template>

<style scoped>
.main-image {
  max-height: 400px;
  object-fit: contain;
}

.thumbnail-wrapper {
  cursor: pointer;
  border-radius: 6px;
  overflow: hidden;
}

.thumbnail {
  height: 70px;
  width: 100px;
  object-fit: cover;
  opacity: 0.6;
  transition: opacity 0.3s, transform 0.2s;
  border: 2px solid transparent;
  border-radius: 6px;
}

.thumbnail:hover {
  opacity: 0.9;
  transform: scale(1.05);
}

.thumbnail.active {
  opacity: 1;
  border-color: #198754; 
}
</style>
