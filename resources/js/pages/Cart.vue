<template>
    <Cart v-if="totalProducts > 0" :products :totalProducts :totalPrice />
    <EmptyCart v-else />
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import EmptyCart from '@/components/Cart/EmptyCart.vue';
import Cart from '@/components/Cart/Cart.vue';
import { ProductCart } from '@/models';

defineOptions({
    layout: [AppLayout, { title: 'Pannier' }],
});

defineProps<{
    totalProducts: number;
    totalPrice: number;
    products: ProductCart[];
}>();
</script>

<style scoped></style>
