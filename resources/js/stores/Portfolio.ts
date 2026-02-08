import { defineStore } from "pinia";
import portfolioService from "../_services/PortfolioService";

export const usePortfolioStore = defineStore("portfolio", {
  state: () => ({
    photos: [] as Array<{ id: number; titre?: string; src: string }>,
    loading: false,
    error: null as string | null,
  }),

  actions: {
    async fetchPhotos() {
      this.loading = true;
      try {
        this.photos = await portfolioService.getPhotos();
      } catch (err) {
        this.error = "Erreur lors du chargement des photos";
      } finally {
        this.loading = false;
      }
    },

    async addPhoto(titre: string, file: File) {
      try {
        const formData = new FormData();
        formData.append("titre", titre);
        formData.append("image", file);

        const newPhoto = await portfolioService.addPhoto(formData);
        this.photos.push(newPhoto);
      } catch (err) {
        this.error = "Erreur lors de l'ajout de la photo";
      }
    },

    async deletePhoto(id: number) {
      try {
        await portfolioService.deletePhoto(id);
        this.photos = this.photos.filter((p) => p.id !== id);
      } catch (err) {
        this.error = "Erreur lors de la suppression";
      }
    },
  },
});
