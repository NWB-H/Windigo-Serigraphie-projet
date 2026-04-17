import type { Category } from "./Category"
import type { Option } from "./Option"

export interface Image {
    id?: number,
    isHighlighted: boolean,
    url: string
}

export interface Product {
  id: number
  name: string
  price: number
  stock: number
  description: string
  archived: boolean
  images: Image[]

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
