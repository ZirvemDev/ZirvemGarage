import ModelService from './ModelService';

export default class RoleService extends ModelService {
    constructor() {
        super();
        this.url = '/roles';
    }

    getRoles() {
        return this.get(`${this.url}`);
    }

    getAbilities() {
        return this.get(`${this.url}/abilities`);
    }

    getRoleAbilities(roleId: number) {
        return this.get(`${this.url}/${roleId}/abilities`);
    }

    syncRoleAbilities(roleId: number, data: any) {
        return this.post(`${this.url}/${roleId}/abilities`, data);
    }

    createRole(data: any) {
        return this.post(this.url, data);
    }

    updateRole(id: number, data: any) {
        return this.put(`${this.url}/${id}`, data);
    }

    deleteRole(id: number) {
        return this.delete(`${this.url}/${id}`);
    }
} 