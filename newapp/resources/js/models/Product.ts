import type { Category } from "./Category"
import type { Option } from "./Option"

export interface Product {
  id: number
  name: string
  price: number
  stock: number
  description: string
  archived: boolean
  picture: string | File | null   // <-- accepte string (backend) ou File (upload)

  // Relations
  category?: Category
  option?: Option
  picture_url?: string;
}
