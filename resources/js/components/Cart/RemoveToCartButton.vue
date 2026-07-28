<template>
    <AppButton
        :ignoreStyle
        :class="$attrs.class ?? 'btn btn-primary w-100'"
        :disabled="!productCanDecrease(product)"
        @click.prevent="decrement(product)"
    >
        <slot> Retirer du panier </slot>
    </AppButton>
</template>

<script setup lang="ts">
import { Product } from '@/models';
import { useCartStore } from '@/stores/Cart';
import AppButton from '@/components/Global/AppButton.vue';
import { watch } from 'vue';

const props = withDefaults(
    defineProps<{
        product: Product;
        ignoreStyle?: boolean;
    }>(),
    {
        ignoreStyle: false,
    },
);

const emits = defineEmits(['remove']);

const { decrement, productCanDecrease, getItem } = useCartStore();

watch(
    () => getItem(props.product),
    (newItem) => {
        if (!newItem) {
            emits('remove');
        }
    },
);
</script>

<style scoped></style>
