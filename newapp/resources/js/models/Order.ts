// _models/Order.ts
export interface Order {
  id: number;
  user_id: number;
  total: number;
  status: string;
  products: {
    id: number;
    name: string;
    price: number;
    quantity: number;
  }[];
}
