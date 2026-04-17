import { Image, Product } from '@/models';
import axios from "axios";

class ProductRepository {
    public async deleteProduct(product: Product): Promise<any>
    {
        return axios.delete(`/api/products/${product.id}`)
    }

    public async deleteMedia(product: Product, image: Image): Promise<any>
    {
        return axios.delete(`/api/products/${product.id}/media/${image.id}`)
    }
}

export default new ProductRepository()
