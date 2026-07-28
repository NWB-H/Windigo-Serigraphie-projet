<template>
    <div class="flex gap-2">
        <div class="flex gap-2">
            <RemoveToCartButton
                class="w-1/3 rounded bg-[#9E3D3D] text-white"
                :product
                >-</RemoveToCartButton
            >
            <span
                class="w-full rounded-lg border border-[#bfa79a] bg-[#f7f3f0] px-4 py-2 text-center text-gray-800 placeholder-gray-500 shadow-sm transition outline-none focus:border-[#a18678] focus:ring-2 focus:ring-[#a18678]/40 disabled:cursor-not-allowed disabled:bg-[#e8ddd6] disabled:text-gray-500"
                >{{ quantity }}</span
            >
            <AddToCartButton
                class="w-1/3 rounded bg-[#3E7C59] text-white"
                :product
                >+</AddToCartButton
            >
        </div>
        <AppButton @click="handleAddToCart" :disabled="!productCanIncrease(product)"
            >Ajouter au panier</AppButton
        >
    </div>
</template>

<script setup lang="ts">
import AppButton from '@/components/Global/AppButton.vue';
import { computed } from 'vue';
import { useCartStore } from '@/stores/Cart';
import { Product } from '@/models';
import AddToCartButton from '@/components/Cart/AddToCartButton.vue';
import RemoveToCartButton from '@/components/Cart/RemoveToCartButton.vue';

const props = defineProps<{ product: Product }>();

const { addItem, getItem, productCanIncrease } = useCartStore();

const quantity = computed(() => getItem(props.product)?.quantity ?? 0);

function handleAddToCart() {
    addItem(props.product, quantity.value);
}
</script>

<style scoped></style>
