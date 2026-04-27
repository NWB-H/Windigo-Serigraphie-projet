import { Category } from '@/models';
import axios from 'axios';

class CategoryRepository {
    public async deleteCategory(category: Category): Promise<any> {
        return axios.delete(`/api/categories/${category.id}`);
    }
}

export default new CategoryRepository();
