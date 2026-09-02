<template>
    <div class="mt-8 rounded-2xl bg-gray-50 p-6">
        <h3 class="mb-5 text-lg font-semibold text-gray-800">
            Détail du paiement
        </h3>

        <div class="mb-3">
            <template v-for="product in productsCart" :key="product.product.id">
                <SummaryCartLine
                    :product="product.product"
                    :quantity="product.quantity"
                />
            </template>
        </div>

        <div class="space-y-3">
            <div class="flex items-center justify-between text-gray-600">
                <span>Sous-total</span>
                <span>{{ formatPrice(totalPrice) }}</span>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <div class="flex items-center justify-between">
                    <span class="text-xl font-bold text-gray-800">Total</span>
                    <span class="text-2xl font-bold text-[#3E7C59]">{{
                        formatPrice(totalPrice)
                    }}</span>
                </div>

                <p class="mt-1 text-right text-xs text-gray-500">
                    Taxes incluses
                </p>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { ProductCart } from '@/models';
import SummaryCartLine from '@/components/Cart/SummaryCartLine.vue';

defineProps<{
    totalPrice: number;
    productsCart: ProductCart[];
}>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};
</script>

<style scoped></style>
