import { Product } from '@/models/Product';
import { acceptHMRUpdate, defineStore } from 'pinia';
import { computed, ref } from 'vue';

export interface CartItem {
    quantity: number;
    product: Product;
}

function getDefaultItems(): CartItem[] {
    const savedCart = localStorage.getItem('cart');

    if (!savedCart) {
        return [];
    }

    return JSON.parse(savedCart) as CartItem[];
}

export const useCartStore = defineStore('cart', () => {
    const items = ref<CartItem[]>(getDefaultItems());

    const totalCartItem = computed(() => items.value.length);
    const totalPrice = computed(() =>
        items.value.reduce(
            (total, i: CartItem) => total + i.quantity * i.product.price,
            0,
        ),
    );
    const totalProducts = computed(() =>
        items.value.reduce((total, i: CartItem) => total + i.quantity, 0),
    );

    function addItem(product: Product, quantity?: number) {
        const currentItem = items.value.findIndex(
            (item: CartItem) => item.product.id === product.id,
        );

        if (currentItem !== -1) {
            items.value[currentItem].quantity += quantity ?? 1;
        } else {
            items.value.push({
                quantity: quantity ?? 1,
                product: product,
            });
        }
    }

    function getItem(product: Product): CartItem | undefined {
        return items.value.find((i: CartItem) => i.product.id === product.id);
    }

    function decrement(product: Product) {
        const currentItem = items.value.findIndex(
            (i: CartItem) => i.product.id === product.id,
        );

        if (items.value[currentItem]) {
            items.value[currentItem].quantity--;

            if (items.value[currentItem].quantity <= 0) {
                items.value.splice(currentItem, 1);
            }
        }
    }

    function increment(product: Product) {
        const currentItem = items.value.findIndex(
            (i: CartItem) => i.product.id === product.id,
        );

        if (items.value[currentItem]) {
            items.value[currentItem].quantity++;
            // todo: voir pour vérifier la quantité dispo via un appelle API
        }
    }

    function removeItem(product: Product) {
        items.value.splice(
            items.value.findIndex((i: CartItem) => i.product.id === product.id),
            1,
        );
    }

    function clear() {
        items.value = [];
    }

    return {
        items,
        totalCartItem,
        totalPrice,
        totalProducts,
        addItem,
        removeItem,
        clear,
        decrement,
        increment,
        getItem,
    };
});

if (import.meta.hot) {
    import.meta.hot.accept(acceptHMRUpdate(useCartStore, import.meta.hot));
}
