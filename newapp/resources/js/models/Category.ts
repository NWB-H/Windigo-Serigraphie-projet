import type { Product } from "./Product"

export interface Category {
  id: number
  name: string

  // Relation inverse
  products?: Product[]
}
