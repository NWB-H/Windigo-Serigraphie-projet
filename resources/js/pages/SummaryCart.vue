<template>
    <div class="container my-5">
        <div class="mx-auto max-w-4xl rounded-2xl bg-white p-6 shadow-lg">
            <!-- Header -->
            <div class="mb-6 border-b pb-4">
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-gray-800">
                            Récapitulatif de la commande
                        </h2>

                        <p class="mt-1 text-sm text-gray-500">
                            Vérifiez votre commande avant de procéder au
                            paiement.
                        </p>
                    </div>

                    <span
                        class="inline-flex shrink-0 items-center rounded-full bg-[#3E7C59]/10 px-3 py-1 text-sm font-medium text-[#3E7C59]"
                    >
                        {{ totalProducts }}
                        {{ totalProducts > 1 ? 'articles' : 'article' }}
                    </span>
                </div>
            </div>

            <!-- Empty cart -->
            <div
                v-if="products.length === 0"
                class="rounded-xl border border-dashed border-gray-300 p-8 text-center"
            >
                <p class="font-medium text-gray-700">Votre panier est vide.</p>

                <Link
                    :href="route('products.index')"
                    class="mt-4 inline-flex rounded-xl bg-[#3E7C59] px-6 py-3 font-medium text-white no-underline! transition hover:bg-[#326548]"
                >
                    Découvrir les produits
                </Link>
            </div>

            <template v-else>
                <!-- Products -->
                <div class="space-y-4"></div>

                <!-- Summary -->
                <div class="mt-8 rounded-2xl bg-gray-50 p-6">
                    <h3 class="mb-5 text-lg font-semibold text-gray-800">
                        Détail du paiement
                    </h3>

                    <div class="space-y-3">
                        <div
                            class="flex items-center justify-between text-gray-600"
                        >
                            <span>Sous-total</span>
                            <span>{{ formatPrice(totalPrice) }}</span>
                        </div>

                        <div
                            class="flex items-center justify-between text-gray-600"
                        >
                            <span>Livraison</span>

                            <span class="font-medium text-[#3E7C59]">
                                Gratuite
                            </span>
                        </div>

                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xl font-bold text-gray-800">
                                    Total
                                </span>

                                <span class="text-2xl font-bold text-[#3E7C59]">
                                    {{ formatPrice(totalPrice) }}
                                </span>
                            </div>

                            <p class="mt-1 text-right text-xs text-gray-500">
                                Taxes incluses
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                        <Link
                            :href="route('cart')"
                            class="flex-1 rounded-xl border border-gray-300 px-6 py-3 text-center font-medium text-gray-700 no-underline! transition hover:bg-gray-100"
                        >
                            Retour au panier
                        </Link>

                        <Link
                            :href="route('checkout')"
                            class="flex-1 rounded-xl bg-[#3E7C59] px-6 py-3 text-center font-medium text-white no-underline! transition hover:bg-[#326548]"
                        >
                            Confirmer la commande
                        </Link>
                    </div>

                    <div
                        class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2h-1V7a5 5 0 00-10 0v4H6a2 2 0 00-2 2v6a2 2 0 002 2zm3-10V7a3 3 0 016 0v4H9z"
                            />
                        </svg>

                        Paiement sécurisé
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import type { ProductCart } from '@/models';

defineOptions({
    layout: [AppLayout, { title: 'Récapitulatif du panier' }],
});

defineProps<{
    totalProducts: number;
    products: ProductCart[];
    totalPrice: number;
}>();

const formatPrice = (price: number): string => {
    return new Intl.NumberFormat('fr-FR', {
        style: 'currency',
        currency: 'EUR',
    }).format(price);
};
</script>

<style scoped></style>
