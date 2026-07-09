<template>
    <div class="flex gap-2">
        <div class="flex gap-2">
            <AppButton
                class="w-1/3 rounded bg-[#9E3D3D] text-white"
                @click="handleDecrement"
                :disabled="quantity <= 0"
                >-</AppButton
            >
            <span
                class="w-full rounded-lg border border-[#bfa79a] bg-[#f7f3f0] px-4 py-2 text-center text-gray-800 placeholder-gray-500 shadow-sm transition outline-none focus:border-[#a18678] focus:ring-2 focus:ring-[#a18678]/40 disabled:cursor-not-allowed disabled:bg-[#e8ddd6] disabled:text-gray-500"
            >{{ quantity }}</span
            >
            <AppButton
                class="w-1/3 rounded bg-[#3E7C59] text-white"
                @click="handleIncrement"
                :disabled="isStockLimitReached"
                >+</AppButton
            >
        </div>
        <AppButton
            @click="handleAddToCart"
            :disabled="quantity === 0 || quantity > max"
            >Ajouter au panier</AppButton
        >
    </div>
</template>

<script setup lang="ts">
import AppButton from '@/components/Global/AppButton.vue';
import { ref, computed } from 'vue';
import AppInput from '@/components/Global/AppInput.vue';
import { useCartStore } from '@/stores/Cart';
import { Product } from '@/models';

const props = defineProps<{ product: Product }>();

const max = props.product.stock;
const quantity = ref<number>(0);

const { addItem, getItem } = useCartStore();

const isStockLimitReached = computed(() => {
    const currentCartItem = getItem(props.product);
    const currentQuantity = quantity.value;

    if (!currentCartItem) {
        return currentQuantity >= max;
    }

    return currentCartItem.quantity + currentQuantity >= max;
});

function handleIncrement() {
    if (quantity.value < max) {
        quantity.value++;
    }
}

function handleDecrement() {
    if (quantity.value > 0) {
        quantity.value--;
    }
}

function handleAddToCart() {
    addItem(props.product, quantity.value);

    quantity.value = 0;
}
</script>

<style scoped></style>
