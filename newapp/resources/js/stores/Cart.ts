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

        function addItem(product: Product) {
            const currentItem = items.value.findIndex((item: CartItem) => item.product.id === product.id)

            if (currentItem !== -1) {
                items.value[currentItem].quantity++
            } else {
                items.value.push({ quantity: 1, product: { id: product.id, name: product.name, price: product.price }})
            }
        }

        function removeItem(item: CartItem) {
            const currentItem = items.value.find((item: CartItem) => item.product.id === product.id)

            if (currentItem) {
                items.value[currentItem].quantity--

                if ((items.value[currentItem].quantity - 1) <= 0) {
                    items.value.splice(currentItem, 1)
                }
            }
        }

        return {
            items,
            totalCartItem,
            addItem,
            removeItem,
        }
    }
)
