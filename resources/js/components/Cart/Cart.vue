<template>
    <div class="container my-5">
        <div class="mx-auto max-w-4xl rounded-2xl bg-white p-6 shadow-lg">
            <!-- Header -->
            <div class="mb-6 flex items-center justify-between border-b pb-4">
                <h2 class="text-2xl font-bold text-gray-800">Mon panier</h2>

                <span
                    class="inline-flex items-center rounded-full bg-[#3E7C59]/10 px-3 py-1 text-sm font-medium text-[#3E7C59]"
                >
                    {{ totalProducts }} articles
                </span>
            </div>

            <!-- Cart Items -->
            <CartLine
                v-for="item in items"
                :key="item.id"
                :product="item.product"
                :quantity="item.quantity"
            />

            <!-- Summary -->
            <div class="mt-8 rounded-2xl bg-gray-50 p-6">
                <div class="space-y-3">
                    <div
                        class="flex items-center justify-between text-gray-600"
                    >
                        <span>Sous-total</span>
                        <span>{{ totalPrice }} €</span>
                    </div>

                    <div class="border-t pt-3">
                        <div class="flex items-center justify-between">
                            <span class="text-xl font-bold text-gray-800">
                                Total
                            </span>

                            <span class="text-2xl font-bold text-[#3E7C59]">
                                {{ totalPrice }} €
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                    <button
                        class="flex-1 rounded-xl border border-gray-300 px-6 py-3 font-medium text-gray-700 !no-underline transition hover:bg-gray-100"
                    >
                        Continuer mes achats
                    </button>

                    <Link
                        class="flex-1 rounded-xl bg-[#3E7C59] px-6 py-3 font-medium text-white !no-underline transition hover:bg-[#326548]"
                        :href="route('checkout')"
                        method="POST"
                        :data="{ items, totalPrice }"
                    >
                        Passer la commande
                    </Link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { storeToRefs } from 'pinia';
import { useCartStore } from '@/stores/Cart';
import CartLine from '@/components/Cart/CartLine.vue';

const { totalProducts, items, totalPrice } = storeToRefs(useCartStore());
</script>

<style scoped></style>
