<template>
    <div class="container my-5">
        <div class="mx-auto max-w-4xl rounded-2xl bg-white p-6 shadow-lg">
            <!-- Header -->
            <div class="mb-6 border-b pb-4">
                <div class="flex items-center gap-4">
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

            <template v-if="selectedAddress">
                <AddressList
                    :addresses="user.addresses"
                    :actions="addressListProps"
                    @edit="address => handleAddressListEdit(address)"
                    v-if="selectedMode"
                />
                <AddressDetail
                    :address="selectedAddress"
                    @edit="selectedMode = !selectedMode"
                    v-else
                />
            </template>

            <DetailPayment
                :totalPrice
                :productsCart="products"
            />

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
                    method="post"
                    :data="form"
                    :disabled="!selectedAddress"
                    as="button"
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
    </div>
</template>

<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import type { ProductCart } from '@/models';
import {Address} from "@/models/Address";
import DetailPayment from "@/components/Cart/DetailPayment.vue";
import AddressDetail from "@/components/Cart/AddressDetail.vue";
import AddressList, {Actions} from "@/components/Address/AddressList.vue";
import {User} from "@/types";
import {ref} from "vue";
import SummaryCartLine from "@/components/Cart/SummaryCartLine.vue";

defineOptions({
    layout: [AppLayout, { title: 'Récapitulatif du panier' }],
});

const props = defineProps<{
    totalProducts: number;
    products: ProductCart[];
    totalPrice: number;
    user: User
}>();

const selectedAddress = ref<Address | null>(props.user.addresses.at(0) ?? null)
const selectedMode = ref(false)

const form = ref({
    totalPrice: props.totalPrice,
    totalProducts: props.totalProducts,
    items: props.products.map((productCart: ProductCart) => ({
        quantity: productCart.quantity,
        product_id: productCart.product.id,
        product_price: productCart.product.price,
    })),
    address: formatAddress(selectedAddress.value),
})

const addressListProps: Actions = {
    addAddress: false,
    hover: true,
    card: {
        click: true,
        hover: true,
        footer: false,
    },
}

function handleAddressListEdit(address: Address) {
    selectedMode.value = false
    selectedAddress.value = address
    form.value.address = formatAddress(address)
}

function formatAddress(address: Address)
{
    return {
        line1: address.address_line1,
        line2: address?.address_line2,
        postal_code: address.postal_code,
        city: address.city,
        country: address.country,
    }
}
</script>

<style scoped></style>
