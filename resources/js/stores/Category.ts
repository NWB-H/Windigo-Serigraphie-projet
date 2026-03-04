import { defineStore } from 'pinia'
import type { Category } from '@/_models/Category'
import * as CategoryService from '@/_services/CategoryService'

export const useCategoryStore = defineStore('categories', {
  state: () => ({
    categories: [] as Category[],
    currentCategory: null as Category | null,
    loading: false,
    error: null as string | null,
  }),
  actions: {
    async fetchAdminCategories() {
      this.loading = true
      this.error = null
      try {
        this.categories = await CategoryService.getAdminCategories()
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
    async createAdminCategory(data: Category) {
      this.loading = true
      try {
        const newCat = await CategoryService.createAdminCategory(data)
        this.categories.push(newCat)
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
    async updateAdminCategory(id: number, data: Category) {
      this.loading = true
      try {
        const updated = await CategoryService.updateAdminCategory(id, data)
        const index = this.categories.findIndex(c => c.id === id)
        if (index !== -1) this.categories[index] = updated
        if (this.currentCategory?.id === id) this.currentCategory = updated
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
    async deleteAdminCategory(id: number) {
      this.loading = true
      try {
        await CategoryService.deleteAdminCategory(id)
        this.categories = this.categories.filter(c => c.id !== id)
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
  },
})
