<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onPageAction">

        <template #filters v-if="page.toggleFilters">
            <Filters @clear="onFiltersClear">
                <FiltersRow>
                    <FiltersCol>
                        <TextInput name="plate" :label="trans('sbm.labels.plate')" v-model="mainQuery.filters.plate.value"></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput name="user_id" :label="trans('sbm.labels.user_id')" v-model="mainQuery.filters.user_id.value"></TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput name="ended_date" type="email" :label="trans('sbm.labels.ended_date')" v-model="mainQuery.filters.ended_date.value"></TextInput>
                    </FiltersCol>
             
                </FiltersRow>
            </Filters>
        </template>

        <template #default>
            <Table :id="page.id" v-if="table" :headers="table.headers" :sorting="table.sorting"  :records="table.records" :pagination="table.pagination" :is-loading="table.loading" @page-changed="onTablePageChange" @sort="onTableSort">
                <template v-slot:content-id="props">
                    <div class="flex items-center">
                  
                        <div class="ml-4">
                            <div class="text-sm font-medium text-gray-900">
                                {{ props.item.full_name }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ trans('users.labels.id') + ': ' + props.item.id }}
                            </div>
                        </div>
                    </div>
                </template>
                
                <template v-slot:content-location="props">
                    <div class="flex items-center">
                        <img 
                            :src="getImageUrl(props.item.location)" 
                            class="w-16 h-16 object-cover cursor-pointer" 
                            @click="openImageModal(props.item.location)"
                            alt="Sorgu Resmi"
                        />
                    </div>
                </template>
            </Table>

            <div v-if="showModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" @click="closeImageModal">
                <div class="relative">
                    <img :src="selectedImage" class="max-w-3xl max-h-[80vh]" alt="Büyük Resim" />
                    <button class="absolute top-4 right-4 text-white text-2xl" @click="closeImageModal">&times;</button>
                </div>
            </div>
        </template>
    </Page>
</template>

<script>

import {trans} from "@/helpers/i18n";
import SbmService from "@/services/SbmService";
import {watch, onMounted, defineComponent, reactive, ref} from 'vue';
import {getResponseError, prepareQuery} from "@/helpers/api";
import {toUrl} from "@/helpers/routing";
import {useAlertStore} from "@/stores";
import alertHelpers from "@/helpers/alert";
import Page from "@/views/layouts/Page";
import Table from "@/views/components/Table";
import Avatar from "@/views/components/icons/Avatar";
import Filters from "@/views/components/filters/Filters";
import FiltersRow from "@/views/components/filters/FiltersRow";
import FiltersCol from "@/views/components/filters/FiltersCol";
import TextInput from "@/views/components/input/TextInput";
import Dropdown from "@/views/components/input/Dropdown";

export default defineComponent({
    components: {
        Dropdown,
        TextInput,
        FiltersCol,
        FiltersRow,
        Filters,
        Page,
        Table,
        Avatar
    },
    setup() {
        const service = new SbmService();
        const alertStore = useAlertStore();
        const mainQuery = reactive({
            page: 1,
            search: '',
            sort: '',
            filters: {
                plate: {
                    value: '',
                    comparison: '='
                },
                user_id: {
                    value: '',
                    comparison: '='
                },
               ended_date: {
                    value: '',
                    comparison: '='
                },
            }
        });

        const page = reactive({
            id: 'list_users',
            title: trans('sbm.old_query'),
            breadcrumbs: [
                {
                    name: trans('sbm.old_query'),
                    to: toUrl('/sbm/old_query'),
                    active: true,
                }
            ],
           /*  actions: [
                {
                    id: 'filters',
                    name: trans('global.buttons.filters'),
                    icon: "fa fa-filter",
                    theme: 'outline',
                },
                {
                    id: 'new',
                    name: trans('global.buttons.add_new'),
                    icon: "fa fa-plus",
                    to: toUrl('/users/create')
                }
            ], */
            toggleFilters: false,
        });

        const showModal = ref(false);
        const selectedImage = ref('');

        const table = reactive({
            headers: {
                id: trans('sbm.labels.id_pound'),
                plate: trans('sbm.labels.plate'),
                user_id: trans('sbm.labels.user_id'),
                ended_date: trans('sbm.labels.ended_date'),
                location: trans('sbm.labels.image'),
            },
            sorting: {
                id: true,
                plate: true,
                user_id: true,
                ended_date: true,
                location: false,
            },
            pagination: {
                meta: null,
                links: null,
            },
            loading: false,
            records: null
        })

        function onTableSort(params) {
            mainQuery.sort = params;
        }

        function onTablePageChange(page) {
            mainQuery.page = page;
        }

        function onTableAction(params) {
            switch (params.action.id) {
                case 'delete':
                    alertHelpers.confirmDanger(function () {
                        service.delete(params.item.id).then(function (response) {
                            fetchPage(mainQuery);
                        });
                    })
                    break;
            }
        }

        function onPageAction(params) {
            switch (params.action.id) {
                case 'filters':
                    page.toggleFilters = !page.toggleFilters;
                    break;
            }
        }

        function onFiltersClear() {
            let clonedFilters = mainQuery.filters;
            for(let key in clonedFilters) {
                clonedFilters[key].value = '';
            }
            mainQuery.filters = clonedFilters;
        }

        function fetchPage(params) {
            table.records = [];
            table.loading = true;
            let query = prepareQuery(params);
            service
                .oldQuery(query)
                .then((response) => { 
                
                    table.records = response.data.data;
                    table.pagination.meta = response.data.meta;
                    table.pagination.links = response.data.links;
                    table.loading = false;
                })
                .catch((error) => {
                    alertStore.error(getResponseError(error));
                    table.loading = false;
                });
        }

        function getImageUrl(location) {
            if (!location) return '';
            return location;
        }

        function openImageModal(imageUrl) {
            selectedImage.value = getImageUrl(imageUrl);
            showModal.value = true;
        }

        function closeImageModal() {
            showModal.value = false;
            selectedImage.value = '';
        }

        watch(mainQuery, (newTableState) => {
            fetchPage(mainQuery);
        });

        onMounted(() => {
            fetchPage(mainQuery);
        });

        return {
            trans,
            page,
            table,
            onTablePageChange,
            onTableAction,
            onTableSort,
            onPageAction,
            onFiltersClear,
            mainQuery,
            getImageUrl,
            openImageModal,
            closeImageModal,
            showModal,
            selectedImage,
        }

    },
});
</script>

<style scoped>
.modal-image {
    max-width: 90vw;
    max-height: 90vh;
}
</style>
