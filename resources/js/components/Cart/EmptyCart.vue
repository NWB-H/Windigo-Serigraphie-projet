<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div
        class="mx-auto flex max-w-2xl flex-col items-center justify-center rounded-2xl bg-white p-10 text-center shadow-lg"
    >
        <!-- Icon -->
        <div
            class="mb-6 flex h-24 w-24 items-center justify-center rounded-full bg-[#3E7C59]/10"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-12 w-12 text-[#3E7C59]"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="1.8"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-1 5h12m-9 0a1 1 0 100 2 1 1 0 000-2zm8 0a1 1 0 100 2 1 1 0 000-2"
                />
            </svg>
        </div>

        <!-- Text -->
        <h2 class="text-2xl font-bold text-gray-800">Votre panier est vide</h2>

        <p class="mt-3 max-w-md text-gray-500">
            Vous n'avez encore ajouté aucun produit à votre panier. Découvrez
            notre catalogue et trouvez ce qu'il vous faut.
        </p>

        <!-- Actions -->
        <div class="mt-8 flex w-full flex-col gap-3 sm:w-auto sm:flex-row">
            <Link
                class="rounded-xl bg-[#3E7C59] px-6 py-3 font-medium text-white !no-underline transition hover:bg-[#326548]"
                :href="route('shop')"
            >
                Découvrir les produits
            </Link>

            <Link
                class="rounded-xl border border-gray-300 px-6 py-3 font-medium text-gray-700 !no-underline transition hover:bg-gray-100"
                :href="route('home')"
            >
                Retour à l'accueil
            </Link>
        </div>
    </div>
</template>

<style scoped></style>
