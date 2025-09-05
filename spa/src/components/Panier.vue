<script setup lang="ts">
import { useCartStore } from '@/stores/Cart'
import { addOne, removeOne, removeFromCart, clearCart } from '@/_services/CartService'

const cartStore = useCartStore()

function increment(itemId: number) {
  addOne(itemId)
}

function decrement(itemId: number) {
  removeOne(itemId)
}

function removeItem(itemId: number) {
  removeFromCart(itemId)
}

function clearAll() {
  clearCart()
}
</script>

<template>
  <div class="container my-5">
    <h2>Votre Panier</h2>

    <div v-if="cartStore.items.length === 0">
      <p>Votre panier est vide.</p>
    </div>

    <div v-else>
      <ul class="list-group mb-3">
        <li v-for="item in cartStore.items" :key="item.product_id" class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong>{{ item.product?.name }}</strong> - {{ item.product?.price }} €
          </div>
          <div class="d-flex align-items-center">
            <button class="btn btn-outline-secondary btn-sm me-1" @click="decrement(item.product_id)">-</button>
            <span class="mx-2">{{ item.quantity }}</span>
            <button class="btn btn-outline-secondary btn-sm me-3" @click="increment(item.product_id)">+</button>
            <button class="btn btn-danger btn-sm" @click="removeItem(item.product_id)">Supprimer</button>
          </div>
          <span>{{ (item.product?.price ?? 0) * item.quantity }} €</span>
        </li>
      </ul>

      <div class="d-flex justify-content-between align-items-center">
        <h4>Total : {{ cartStore.totalPrice }} €</h4>
        <h4>Total : {{ cartStore.totalQuantity }} </h4>
        <button class="btn btn-warning" @click="clearAll">Vider le panier</button>
      </div>
    </div>
  </div>
</template>
