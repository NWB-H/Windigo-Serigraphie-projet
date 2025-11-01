import { defineStore } from 'pinia'

export interface CartItem {
  product_id: number
  quantity: number
  product?: {
    id: number
    name: string
    price: number
    stock: number
  }
}

interface CartState {
  items: CartItem[]
}

export const useCartStore = defineStore('cart', {
  state: (): CartState => ({
    items: []
  }),
  actions: {
    setCart(items: CartItem[]) {
      this.items = items
    },
    clearCart() {
      this.items = []
    },
    removeItem(productId: number) {
      this.items = this.items.filter(i => i.product_id !== productId)
    }
  },
  getters: {
  totalPrice: (state) =>
    state.items.reduce((sum, item) => sum + (item.product?.price ?? 0) * item.quantity, 0),
  
  totalQuantity: (state) =>
    state.items.reduce((sum, item) => sum + item.quantity, 0)
}
})
