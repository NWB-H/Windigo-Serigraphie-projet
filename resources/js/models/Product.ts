import type { Category } from "./Category"
import type { Option } from "./Option"

interface Images {
    url?: string
}

export interface Product {
  id: number
  name: string
  price: number
  stock: number
  description: string
  archived: boolean
  picture: string | File | null   // <-- accepte string (backend) ou File (upload)
    images?: Images[]

  // Relations
  category?: Category
  option?: Option
  picture_url?: string;
}

export interface ProductForm {
    id: number
    name: string
    price: number
    stock: number
    description: string
    archived: boolean
    pictures: File[]

    // Relations
    category_id?: number
    option_id?: number
}