import ModelService from "@/services/ModelService";

export default class SbmService extends ModelService {

    constructor() {
        super();
        this.url = '/sbm';
    }

    public searchByPlate(plate)
    {

        return this.post(`/sbm/plate`, {plate: plate});

    }

    public oldQuery(params = {}) {
        let path = '/sbm/old';
        let query = new URLSearchParams(params).toString();
        if (query) {
            path += '?' + query
        }
        return this.get(path, {});
    }

    public fetchDataByPlate(plate) {
        return this.post(`/sbm/fetch-data-by-plate`, {plate: plate});
    }

}
