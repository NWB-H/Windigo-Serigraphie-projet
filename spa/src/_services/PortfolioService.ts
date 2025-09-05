import CallerService from "./CallerService";

export default {
  async getPhotos() {
    const res = await CallerService.get("/api/portfolio");
    return res.data;
  },

  async addPhoto(formData: FormData) {
    const res = await CallerService.post("/api/admin/portfolio", formData, {
      headers: {
        "Content-Type": "multipart/form-data",
      },
    });
    return res.data;
  },

  async deletePhoto(id: number) {
    const res = await CallerService.delete(`/api/admin/portfolio/${id}`);
    return res.data;
  },
};
