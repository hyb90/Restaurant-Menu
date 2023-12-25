import ModelService from "@/services/ModelService";

export default class ItemService extends ModelService {

    constructor() {
        super();
        this.url = '/items';
    }


}
