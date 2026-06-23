import axios from 'axios';
import { Workshop } from '@/models';

class WorkshopRepository {
    public async delete(workshop: Workshop) {
        return axios.delete(`/api/workshops/${workshop.id}`);
    }

    public async deleteImage(workshop: Workshop, image: any): Promise<any> {
        return axios.delete(`/api/workshops/${workshop.id}/medias/${image.id}`);
    }

    public async setHighlighted(workshop: Workshop, image: any): Promise<any> {
        return axios.patch(
            `/api/workshops/${workshop.id}/medias/${image.id}/highlighted`,
        );
    }
}

export default new WorkshopRepository();
