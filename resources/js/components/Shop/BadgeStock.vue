<template>
    <span
        v-if="currentQuantityInCart"
        class="inline-flex items-center rounded-full bg-[#3E7C59]/10 px-3 py-1 text-sm font-medium text-[#3E7C59]"
        >Dont {{ currentQuantityInCart }} en cours de commande</span
    >
</template>

<script setup lang="ts">
import { Product } from '@/models';
import { useCartStore } from '@/stores/Cart';
import { computed } from 'vue';

const { product } = defineProps<{ product: Product }>();

const { getItem } = useCartStore();

const currentQuantityInCart = computed(() => getItem(product)?.quantity);
</script>

<style scoped></style>
