import { Workshop, WorkshopSession } from '@/models';
import axios from 'axios';
import { useDateFormat } from '@vueuse/shared';

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

    public async filterWorkshopSessions(
        workshop: Workshop,
        date: Date,
    ): Promise<Record<string, WorkshopSession[]>> {
        try {
            const params = new URLSearchParams({
                date: useDateFormat(date, 'YYYY-MM-DD').value
            })

            const { data } = await axios.get(`/api/workshop/${workshop.id}/sessions?` + params.toString());

            return data;
        } catch (error) {
            console.error(
                'Erreur lors du filtrage des sessions de workshop',
                error,
            );
            throw error;
        }
    }
}

export default new WorkshopRepository();
