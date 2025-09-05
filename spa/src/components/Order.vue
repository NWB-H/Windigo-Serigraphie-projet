<!-- <script setup lang="ts">
import { onMounted } from 'vue';
import { useCartStore } from '@/stores/Cart';
import { useUserStore } from '@/stores/User';
import { getCart, removeFromCart, clearCart } from '@/_services/CartService';
import { checkoutFromCart } from '@/_services/OrderService';

const Cart = useCartStore();
const User = useUserStore();

onMounted(async () => {
  if (User.id) await getCart(User.id);
});

async function removeItem(productId: number) {
  if (!User.id) return;
  await removeFromCart(User.id, productId);
}

async function checkout() {
  if (!User.id) return alert('Veuillez vous connecter.');
  try {
    const order = await checkoutFromCart(User.id);
    alert(`Commande #${order.id} passée avec succès !`);
    await clearCart(User.id);
  } catch (err: any) {
    alert(err.error || 'Erreur lors de la commande');
  }
}
</script>

<template>
  <div>
    <h2>Panier</h2>
    <div v-if="Cart.items.length === 0">
      <p>Votre panier est vide.</p>
    </div>
    <div v-else>
      <div v-for="item in Cart.items" :key="item.product_id">
        {{ item.product?.name }} x {{ item.quantity }} = {{ (item.product?.price ?? 0) * item.quantity }}€
        <button @click="removeItem(item.product_id)">Supprimer</button>
      </div>
      <p>Total : {{ Cart.total }} €</p>
      <button @click="checkout">Commander</button>
    </div>
  </div>
</template> -->
