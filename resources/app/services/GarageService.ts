import ModelService from "@/services/ModelService";

export default class UserService extends ModelService {

    constructor() {
        super();
        this.url = '/garages';
    }

    public updateAvatar(id, payload) {
        const formData = new FormData();
        formData.append("avatar", payload.avatar);
        return this.put(`/garages/${id}/avatar`, formData);
    }

}
