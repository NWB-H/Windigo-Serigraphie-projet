import { defineStore } from 'pinia'
import {computed, ref} from "vue";
import { Product } from "@/models/Product";

export interface CartItem {
  quantity: number
  product: {
    id: number
    name: string
    price: number
  }
}

interface CartState {
  items: CartItem[]
}

export const useCartStore = defineStore(
    'cart',
    () => {
        const items = ref<CartItem[]>([])

        const totalCartItem = computed(() => items.value.length)
        const totalPrice = computed(() => items.value.reduce((total, i: CartItem) => total + i.quantity * i.product.price, 0))
        const totalProducts = computed(() => items.value.reduce((total, i: CartItem) => total + i.quantity, 0))

        function addItem(product: Product) {
            const currentItem = items.value.findIndex((item: CartItem) => item.product.id === product.id)

            if (currentItem !== -1) {
                items.value[currentItem].quantity++
            } else {
                items.value.push({ quantity: 1, product: { id: product.id, name: product.name, price: product.price }})
            }
        }

        function decrement(item: CartItem) {
            const currentItem = items.value.findIndex((i: CartItem) => i.product.id === item.product.id)

            if (items.value[currentItem]) {
                items.value[currentItem].quantity--

                if (items.value[currentItem].quantity <= 0) {
                    items.value.splice(currentItem, 1)
                }
            }
        }

        function increment(item: CartItem) {
            const currentItem = items.value.findIndex((i: CartItem) => i.product.id === item.product.id)

            if (items.value[currentItem])  {
                items.value[currentItem].quantity++
                // todo: voir pour vérifier la quantité dispo via un appelle API
            }
        }

        function removeItem(item: CartItem) {
            items.value.splice(
                items.value.findIndex((i: CartItem) => i.product.id === item.product.id),
                1
            )
        }

        function clear() {
            items.value = []
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
            increment
        }
    }
)
