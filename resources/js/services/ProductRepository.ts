import { Image, Product } from '@/models';
import axios from "axios";

/**
 * todo: passer toutes les routes en route() object pour ne passer que le nom de la route avec les parametres
 */
class ProductRepository {
    public async deleteProduct(product: Product): Promise<any>
    {
        return axios.delete(`/api/products/${product.id}`)
    }

    public async deleteMedia(product: Product, image: Image): Promise<any>
    {
        return axios.delete(`/api/products/${product.id}/medias/${image.id}`)
    }

    public async setHighlighted(product: Product, image: Image): Promise<any>
    {
        return axios.patch(`/api/products/${product.id}/medias/${image.id}/highlighted`)
    }
}

export default new ProductRepository()
