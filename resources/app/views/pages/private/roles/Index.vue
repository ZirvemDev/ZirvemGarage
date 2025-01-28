<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onPageAction">
        <div class="grid grid-cols-12 gap-6">
            <!-- Roller Listesi -->
            <div class="col-span-4">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium">{{ trans('roles.roles_list') }}</h3>
                    </div>
                    <div class="divide-y divide-gray-200">
                        <div v-for="role in roles" :key="role.id" 
                             :class="{'bg-gray-50': selectedRole?.id === role.id}"
                             class="px-4 py-4 cursor-pointer hover:bg-gray-50"
                             @click="selectRole(role)">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="font-medium">{{ role.title }}</p>
                                    <p class="text-sm text-gray-500">{{ role.name }}</p>
                                </div>
                                <div class="flex space-x-2">
                                    <button @click.stop="editRole(role)" 
                                            class="text-indigo-600 hover:text-indigo-900">
                                        <Icon name="edit" />
                                    </button>
                                    <button v-if="role.name !== 'admin'" 
                                            @click.stop="deleteRole(role)" 
                                            class="text-red-600 hover:text-red-900">
                                        <Icon name="trash" />
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Yetkiler Listesi -->
            <div class="col-span-8" v-if="selectedRole">
                <div class="bg-white shadow rounded-lg">
                    <div class="px-4 py-5 border-b border-gray-200">
                        <h3 class="text-lg font-medium">
                            {{ trans('roles.permissions_for', { role: selectedRole.title }) }}
                        </h3>
                    </div>
                    <div class="p-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div v-for="(abilities, group) in groupedAbilities" :key="group" 
                                 class="border rounded-lg p-4">
                                <h4 class="font-medium mb-3">{{ group }}</h4>
                                <div class="space-y-2">
                                    <label v-for="ability in abilities" :key="ability.id" 
                                           class="flex items-center">
                                        <input type="checkbox" 
                                               :value="ability.name"
                                               v-model="selectedAbilities"
                                               class="rounded border-gray-300 text-indigo-600">
                                        <span class="ml-2">{{ ability.title }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-4 flex justify-end">
                            <button @click="savePermissions" 
                                    class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                                {{ trans('global.buttons.save') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Role Modal -->
        <Modal v-if="showModal" @close="closeModal">
            <template #title>
                {{ isEditing ? trans('roles.edit_role') : trans('roles.create_role') }}
            </template>
            <template #content>
                <form @submit.prevent="saveRole">
                    <div class="space-y-4">
                        <div v-if="!isEditing">
                            <label class="block text-sm font-medium text-gray-700">
                                {{ trans('roles.labels.name') }}
                            </label>
                            <input type="text" v-model="form.name" 
                                   class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">
                                {{ trans('roles.labels.title') }}
                            </label>
                            <input type="text" v-model="form.title" 
                                   class="mt-1 block w-full rounded-md border-gray-300">
                        </div>
                    </div>
                    <div class="mt-5">
                        <button type="submit" 
                                class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                            {{ trans('global.buttons.save') }}
                        </button>
                    </div>
                </form>
            </template>
        </Modal>
    </Page>
</template>

<script>
import { defineComponent, ref, reactive, onMounted, computed } from 'vue';
import { useAlertStore } from '@/stores';
import RoleService from '@/services/RoleService';
import { trans } from '@/helpers/i18n';
import { toUrl } from "@/helpers/routing";
import Page from "@/views/layouts/Page";
import Modal from "@/views/components/Modal";
import Icon from "@/views/components/icons/Icon";

export default defineComponent({
    components: {
        Page,
        Modal,
        Icon
    },
    
    setup() {
        const service = new RoleService();
        const alertStore = useAlertStore();
        const roles = ref([]);
        const abilities = ref([]);
        const selectedRole = ref(null);
        const selectedAbilities = ref([]);
        const showModal = ref(false);
        const isEditing = ref(false);
        
        const page = reactive({
            id: 'roles_list',
            title: trans('roles.menu_title'),
            breadcrumbs: [
                {
                    name: trans('roles.menu_title'),
                    to: toUrl('/roles'),
                    active: true,
                }
            ],
            actions: [
                {
                    id: 'new',
                    name: trans('global.buttons.add_new'),
                    icon: "fa fa-plus",
                }
            ],
        });

        const form = reactive({
            name: '',
            title: ''
        });

        const groupedAbilities = computed(() => {
            const grouped = {};
            abilities.value.forEach(ability => {
                const group = ability.group || 'Genel';
                if (!grouped[group]) {
                    grouped[group] = [];
                }
                grouped[group].push(ability);
            });
            return grouped;
        });

        const fetchRoles = async () => {
            try {
                const response = await service.getRoles();
                roles.value = response.data;
            } catch (error) {
                alertStore.error(error.message);
            }
        };

        const fetchAbilities = async () => {
            try {
                const response = await service.getAbilities();
                abilities.value = response.data;
            } catch (error) {
                alertStore.error(error.message);
            }
        };

        const selectRole = async (role) => {
            selectedRole.value = role;
            try {
                const response = await service.getRoleAbilities(role.id);
                selectedAbilities.value = response.data.map(a => a.name);
            } catch (error) {
                alertStore.error(error.message);
            }
        };

        const savePermissions = async () => {
            try {
                await service.syncRoleAbilities(selectedRole.value.id, {
                    abilities: selectedAbilities.value
                });
                alertStore.success(trans('roles.permissions_saved'));
            } catch (error) {
                alertStore.error(error.message);
            }
        };

        const editRole = (role) => {
            selectedRole.value = role;
            isEditing.value = true;
            form.name = role.name;
            form.title = role.title;
            showModal.value = true;
        };

        const deleteRole = async (role) => {
            if (confirm(trans('global.phrases.confirm_delete'))) {
                try {
                    await service.deleteRole(role.id);
                    await fetchRoles();
                    if (selectedRole.value?.id === role.id) {
                        selectedRole.value = null;
                    }
                    alertStore.success(trans('roles.role_deleted'));
                } catch (error) {
                    alertStore.error(error.message);
                }
            }
        };

        const saveRole = async () => {
            try {
                if (isEditing.value) {
                    await service.updateRole(selectedRole.value.id, form);
                } else {
                    await service.createRole(form);
                }
                await fetchRoles();
                closeModal();
                alertStore.success(trans('roles.role_saved'));
            } catch (error) {
                alertStore.error(error.message);
            }
        };

        const closeModal = () => {
            showModal.value = false;
            isEditing.value = false;
            form.name = '';
            form.title = '';
        };

        const onPageAction = (params) => {
            if (params.action.id === 'new') {
                showModal.value = true;
            }
        };

        onMounted(() => {
            fetchRoles();
            fetchAbilities();
        });

        return {
            page,
            roles,
            abilities,
            selectedRole,
            selectedAbilities,
            form,
            showModal,
            isEditing,
            selectRole,
            savePermissions,
            editRole,
            deleteRole,
            saveRole,
            closeModal,
            onPageAction,
            trans,
            groupedAbilities
        };
    }
});
</script> 