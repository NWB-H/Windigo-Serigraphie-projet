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
                <RemoveToCartButton
                    ignoreStyle
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-red-100 text-red-600 transition hover:bg-red-200"
                    :product
                    @remove="handleRemove"
                    >-</RemoveToCartButton
                >

                <span
                    class="min-w-[30px] text-center font-medium text-gray-800"
                    >{{ quantity }}</span
                >

                <AddToCartButton
                    ignoreStyle
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-[#3E7C59]/10 text-[#3E7C59] transition hover:bg-[#3E7C59]/20"
                    :product
                    >+</AddToCartButton
                >
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
                @click="handleRemove"
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
import RemoveToCartButton from '@/components/Cart/RemoveToCartButton.vue';
import AddToCartButton from '@/components/Cart/AddToCartButton.vue';
import { computed } from 'vue';

const props = defineProps<{
    product: Product;
}>();
const emits = defineEmits<{ (e: 'remove', product: Product): void }>();

const { getItem } = useCartStore();

const quantity = computed(() => getItem(props.product)?.quantity ?? 0);

function handleRemove() {
    emits('remove', props.product);
}
</script>

<style scoped></style>
