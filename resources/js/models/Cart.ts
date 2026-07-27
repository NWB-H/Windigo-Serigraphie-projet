import { Product } from '@/models/Product';

export interface ProductCart {
    product: Product;
    quantity: number;
}
