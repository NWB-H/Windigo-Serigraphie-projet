<template>
    <article
        class="flex flex-col gap-4 rounded-xl border border-gray-200 p-4 sm:flex-row sm:items-center"
    >
        <!-- Product -->
        <div class="flex min-w-0 flex-1 items-center gap-4">
            <AppImage
                :url="product.picture_url ?? null"
                class="h-20 w-20 shrink-0 rounded-lg object-cover"
            />

            <div class="min-w-0">
                <h3 class="truncate text-lg font-semibold text-gray-800">
                    {{ product.name }}
                </h3>

                <div class="mt-2 flex flex-wrap items-center gap-2">
                    <span
                        class="inline-flex items-center rounded-full bg-[#3E7C59]/10 px-2 py-1 text-xs font-medium text-[#3E7C59]"
                    >
                        En stock
                    </span>

                    <span class="text-sm text-gray-500">
                        {{ formatPrice(product.price) }} / unité
                    </span>
                </div>
            </div>
        </div>

        <!-- Quantity read-only -->
        <div
            class="flex items-center justify-between gap-4 rounded-lg bg-gray-50 px-4 py-3 sm:block sm:min-w-24 sm:text-center"
        >
            <span class="text-sm text-gray-500"> Quantité </span>

            <p class="text-lg font-bold text-gray-800 sm:mt-1">
                {{ quantity }}
            </p>
        </div>

        <!-- Total -->
        <div
            class="flex items-center justify-between sm:block sm:min-w-32 sm:text-right"
        >
            <span class="text-sm text-gray-500 sm:hidden"> Total </span>

            <div>
                <p class="hidden text-sm text-gray-500 sm:block">Total</p>

                <p class="text-xl font-bold text-gray-800">
                    {{ formatPrice(product.price * quantity) }}
                </p>
            </div>
        </div>
    </article>
</template>

<script setup lang="ts">
import AppImage from '@/components/AppImage.vue';
import type { Product } from '@/models';

defineProps<{
    product: Product;
    quantity: number;
}>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};
</script>
