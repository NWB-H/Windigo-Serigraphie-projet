<template>
    <AppLayout title="Pannier">
        <Cart v-if="totalProducts > 0" />
        <EmptyCart v-else />
    </AppLayout>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useCartStore } from '@/stores/Cart';
import { storeToRefs } from 'pinia';
import EmptyCart from '@/components/Cart/EmptyCart.vue';
import Cart from '@/components/Cart/Cart.vue';

const { totalProducts } = storeToRefs(useCartStore());
</script>

<style scoped></style>
