<template>
    <div class="space-y-4">
        <!-- Item -->
        <div
            class="flex flex-col gap-4 rounded-xl border border-gray-200 p-4 md:flex-row md:items-center md:justify-between"
        >
            <!-- Product Info -->
            <div class="flex items-center gap-4">
                <AppImage
                    :url="product.picture_url ?? null"
                    class="h-20 w-20 rounded-lg object-cover"
                />

                <div>
                    <h3 class="text-lg font-semibold text-gray-800">
                        {{ product.name }}
                    </h3>

                    <span
                        class="mt-2 inline-flex items-center rounded-full bg-[#3E7C59]/10 px-2 py-1 text-xs font-medium text-[#3E7C59]"
                    >
                        En stock
                    </span>
                </div>
            </div>

            <!-- Quantity -->
            <div class="flex items-center gap-3">
                <button
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-100 text-red-600 transition hover:bg-red-200"
                    @click="decrement(product)"
                >
                    -
                </button>

                <span
                    class="min-w-[30px] text-center font-medium text-gray-800"
                    >{{ quantity }}</span
                >

                <button
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#3E7C59]/10 text-[#3E7C59] transition hover:bg-[#3E7C59]/20"
                    @click="increment(product)"
                >
                    +
                </button>
            </div>

            <!-- Price -->
            <div class="text-right">
                <p class="text-sm text-gray-500">
                    {{ product.price }} € / unité
                </p>

                <p class="text-xl font-bold text-gray-800">
                    {{ product.price * quantity }} €
                </p>
            </div>

            <!-- Delete -->
            <button
                class="rounded-lg bg-red-50 px-4 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100"
                @click="removeItem(product)"
            >
                Supprimer
            </button>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Product } from '@/models';
import AppImage from '@/components/AppImage.vue';
import { useCartStore } from '@/stores/Cart';

defineProps<{
    product: Product;
    quantity: number;
}>();

const { removeItem, increment, decrement } = useCartStore();
</script>

<style scoped></style>
