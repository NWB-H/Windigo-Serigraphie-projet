import { defineStore } from 'pinia'
import type { Option } from '@/_models/Option'
import * as OptionService from '@/_services/OptionService'

export const useOptionStore = defineStore('options', {
  state: () => ({
    options: [] as Option[],
    currentOption: null as Option | null,
    loading: false,
    error: null as string | null,
  }),
  actions: {
    async fetchAdminOptions() {
      this.loading = true
      this.error = null
      try {
        this.options = await OptionService.getAdminOptions()
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
    async createAdminOption(data: Option) {
      this.loading = true
      try {
        const newOption = await OptionService.createAdminOption(data)
        this.options.push(newOption)
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
    async updateAdminOption(id: number, data: Option) {
      this.loading = true
      try {
        const updated = await OptionService.updateAdminOption(id, data)
        const index = this.options.findIndex(o => o.id === id)
        if (index !== -1) this.options[index] = updated
        if (this.currentOption?.id === id) this.currentOption = updated
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
    async deleteAdminOption(id: number) {
      this.loading = true
      try {
        await OptionService.deleteAdminOption(id)
        this.options = this.options.filter(o => o.id !== id)
      } catch (e: any) {
        this.error = e.message
      } finally {
        this.loading = false
      }
    },
  },
})
