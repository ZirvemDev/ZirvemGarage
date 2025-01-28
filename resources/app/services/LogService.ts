import ModelService from "@/services/ModelService";

export default class LogService extends ModelService {
    constructor() {
        super();
        this.url = '/logs';
    }
} 