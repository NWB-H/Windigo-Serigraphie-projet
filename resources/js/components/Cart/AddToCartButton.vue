<template>
    <AppButton
        :ignoreStyle
        :class="$attrs.class ?? 'btn btn-primary w-100'"
        :disabled="!productCanIncrease(product)"
        @click.prevent="addItem(product)"
    >
        <slot> Ajouter au panier </slot>
    </AppButton>
</template>

<script setup lang="ts">
import { Product } from '@/models';
import { useCartStore } from '@/stores/Cart';
import AppButton from '@/components/Global/AppButton.vue';

const { ignoreStyle = false } = defineProps<{
    product: Product;
    ignoreStyle?: boolean;
}>();

const { addItem, productCanIncrease } = useCartStore();
</script>

<style scoped></style>
