import { Address } from '@/models/Address';
import axios from 'axios';

class AddressRepository {
    public async deleteAddress(address: Address): Promise<any> {
        return axios.delete(`/api/addresses/${address.id}`);
    }
}

export default new AddressRepository();
