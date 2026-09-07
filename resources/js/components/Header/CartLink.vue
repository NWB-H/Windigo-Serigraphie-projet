<template>
    <Link
        :href="route('cart')"
        class="cart-button"
        type="button"
        aria-label="Voir le panier"
    >
        <CartIcon class="cart-icon" />

        <span class="cart-count">
            {{ count }}
        </span>
    </Link>
</template>

<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import CartIcon from '@/components/Icon/CartIcon.vue';

defineProps<{
    count: number;
}>();
</script>

<style scoped>
.cart-button {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;

    min-width: 78px;
    height: 44px;
    padding: 0 16px;

    border: none;
    border-radius: 999px;

    background: rgba(255, 255, 255, 0.65);
    color: #171717;

    cursor: pointer;

    transition:
        background-color 0.2s ease,
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.cart-button:hover {
    background: rgba(255, 255, 255, 0.85);
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

.cart-button:active {
    transform: translateY(0);
}

.cart-icon {
    width: 22px;
    height: 22px;
    stroke-width: 1.8;
}

.cart-count {
    font-size: 16px;
    font-weight: 600;
    line-height: 1;
}
</style>
