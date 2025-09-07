// _services/ProductService.ts
import Axios from './CallerService';
import type { Product } from '@/_models/Product';

// -------------------
// PUBLIC (boutique)
// -------------------
export async function getProducts(): Promise<Product[]> {
  const res = await Axios.get('api/products');
  return res.data.products; 
}

export async function getProduct(id: number): Promise<Product> {
  const res = await Axios.get(`api/products/${id}`);
  return res.data;
}

// -------------------
// ADMIN (back-office)
// -------------------
export async function getAdminProducts(): Promise<Product[]> {
  const res = await Axios.get('api/admin/products');
  return res.data; 
}

export async function getAdminProduct(id: number): Promise<Product> {
  const res = await Axios.get(`api/admin/products/${id}`);
  return res.data;
}

// on accepte aussi un objet brut { name, price, stock, ... }
export async function createAdminProduct(data: any): Promise<Product> {
  const res = await Axios.post('api/admin/products', data);
  return res.data;
}

export async function updateAdminProduct(id: number, data: any): Promise<Product> {
  const res = await Axios.post(`api/admin/products/${id}?_method=PUT`, data);
  return res.data;
}

export async function deleteAdminProduct(id: number): Promise<void> {
  await Axios.delete(`api/admin/products/${id}`);
}
