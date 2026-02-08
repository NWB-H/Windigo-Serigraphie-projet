import type { Product } from "./Product"

export interface Option {
  id: number
  name: string

  // Relation inverse
  products?: Product[]
}
