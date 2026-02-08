import {Option} from "@/models";
import axios from "axios";

class OptionRepository {
    public async deleteOption(option: Option): Promise<any> {
        return axios.delete(`/api/options/${option.id}`)
    }
}

export default new OptionRepository()