<template>
  <AppLayout>
      <div class="container my-5">
          <h2>Votre Panier</h2>

          <div v-if="items.length === 0">
              <p>Votre panier est vide.</p>
          </div>

          <div v-else>
              <ul class="list-group mb-3">
                  <li v-for="item in items" :key="item.product.id" class="list-group-item d-flex justify-content-between align-items-center">
                      <div>
                          <strong>{{ item.product.name }}</strong> - {{ item.product.price }} €
                      </div>
                      <div class="d-flex align-items-center">
                          <button class="btn btn-outline-secondary btn-sm me-1" @click="decrement(item)">-</button>
                          <span class="mx-2">{{ item.quantity }}</span>
                          <button class="btn btn-outline-secondary btn-sm me-3" @click="increment(item)">+</button>
                          <button class="btn btn-danger btn-sm" @click="removeItem(item)">Supprimer</button>
                      </div>
                      <span>{{ item.product.price * item.quantity }} €</span>
                  </li>
              </ul>

              <div class="d-flex justify-content-between align-items-center">
                  <h4>Total : {{ totalPrice }} €</h4>
                  <h4>Total : {{ totalProducts }}</h4>
                  <button class="btn btn-warning" @click="clear">Vider le panier</button>
              </div>
          </div>
      </div>
  </AppLayout>
</template>

<script setup lang="ts">

import AppLayout from "@/layouts/AppLayout.vue";
import { useCartStore } from "@/stores/Cart";
import {storeToRefs} from "pinia";

const { items, totalPrice, totalProducts } = storeToRefs(useCartStore())
const { clear, removeItem, decrement, increment } = useCartStore()
</script>

<style scoped>

</style>
