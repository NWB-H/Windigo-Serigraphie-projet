import { Product } from "@/models";
import axios from "axios";

class ProductRepository {
    public async deleteProduct(product: Product): Promise<any> {
        return axios.delete(`/api/products/${product.id}`)
    }
}

export default new ProductRepository()