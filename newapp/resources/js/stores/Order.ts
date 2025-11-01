import type { Order } from '@/_models/Order';
import { defineStore } from 'pinia';

interface OrderState {
  orders: Order[];
}

export const useOrderStore = defineStore('order', {
  state: (): OrderState => ({
    orders: []
  }),
  actions: {
    setOrders(orders: Order[]) {
      this.orders = orders;
    }
  }
});
