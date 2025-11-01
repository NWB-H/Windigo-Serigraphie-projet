// _models/Cart.ts
export interface CartItem {
  id: number;
  product_id: number;
  user_id: number;
  quantity: number;
  price: number;
  product?: {
    id: number;
    name: string;
    price: number;
    stock: number;
  };
}
