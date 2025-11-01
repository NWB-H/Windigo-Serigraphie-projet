import { defineStore } from 'pinia';
import type { Product } from '@/_models/Product';
import * as productService from '@/_services/ProductService';

interface ProductState {
  products: Product[];
  selectedProduct: Product | null;
  loading: boolean;
  error: string | null;
}

export const useProductStore = defineStore('product', {
  state: (): ProductState => ({
    products: [],
    selectedProduct: null,
    loading: false,
    error: null
  }),
  actions: {
    // -------------------
    // BOUTIQUE (PUBLIC)
    // -------------------
    async fetchProducts() {
      this.loading = true;
      this.error = null;
      try {
        this.products = await productService.getProducts();
      } catch (e: any) {
        this.error = e.message;
      } finally {
        this.loading = false;
      }
    },

    async fetchProduct(id: number) {
      this.loading = true;
      this.error = null;
      try {
        this.selectedProduct = await productService.getProduct(id);
      } catch (e: any) {
        this.error = e.message;
      } finally {
        this.loading = false;
      }
    },

    setProducts(products: Product[]) {
      this.products = products;
    },

    // -------------------
    // ADMIN (BACK-OFFICE)
    // -------------------
    async fetchAdminProducts() {
      this.loading = true;
      this.error = null;
      try {
        this.products = await productService.getAdminProducts();
      } catch (e: any) {
        this.error = e.message;
      } finally {
        this.loading = false;
      }
    },

    async fetchAdminProduct(id: number) {
      this.loading = true;
      this.error = null;
      try {
        this.selectedProduct = await productService.getAdminProduct(id);
      } catch (e: any) {
        this.error = e.message;
      } finally {
        this.loading = false;
      }
    },

    async createAdminProduct(data: Product | FormData) {
      this.loading = true;
      this.error = null;
      try {
        // ⚡ on envoie directement le FormData au backend
        const product = await productService.createAdminProduct(data);
        this.products.push(product);
        return product;
      } catch (e: any) {
        this.error = e.message;
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async updateAdminProduct(id: number, data: Product | FormData, removedImages: string[] = []) {
      this.loading = true;
      this.error = null;
      try {
        // ⚡ Si data est un FormData, on ajoute removed_images[]
        if (data instanceof FormData && removedImages.length) {
          removedImages.forEach(img => data.append('removed_images[]', img));
        }
        const updated = await productService.updateAdminProduct(id, data);
        const index = this.products.findIndex(p => p.id === id);
        if (index !== -1) this.products[index] = updated;
        return updated;
      } catch (e: any) {
        this.error = e.message;
        throw e;
      } finally {
        this.loading = false;
      }
    },

    async deleteAdminProduct(id: number) {
      this.loading = true;
      this.error = null;
      try {
        await productService.deleteAdminProduct(id);
        this.products = this.products.filter(p => p.id !== id);
      } catch (e: any) {
        this.error = e.message;
        throw e;
      } finally {
        this.loading = false;
      }
    }
  }
});
