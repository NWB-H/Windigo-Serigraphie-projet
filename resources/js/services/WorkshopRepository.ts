import axios from 'axios';
import { Workshop } from '@/models';

class WorkshopRepository {
    async delete(workshop: Workshop) {
        return axios.delete(`/api/workshops/${workshop.id}`);
    }
}

export default new WorkshopRepository();
