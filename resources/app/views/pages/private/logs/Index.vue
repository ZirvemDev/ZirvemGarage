<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs">
        <template #filters v-if="page.toggleFilters">
            <Filters @clear="onFiltersClear">
                <FiltersRow>
                    <FiltersCol>
                        <TextInput 
                            name="action" 
                            :label="trans('logs.labels.action')" 
                            v-model="mainQuery.filters.action.value">
                        </TextInput>
                    </FiltersCol>
                    <FiltersCol>
                        <TextInput 
                            name="module" 
                            :label="trans('logs.labels.module')" 
                            v-model="mainQuery.filters.module.value">
                        </TextInput>
                    </FiltersCol>
                </FiltersRow>
            </Filters>
        </template>

        <template #default>
            <Table 
                :headers="table.headers"
                :records="table.records"
                :pagination="table.pagination"
                :is-loading="table.loading"
                @page-changed="onTablePageChange"
                @sort="onTableSort">
                <template v-slot:content-user="props">
                    {{ props.item.user ? props.item.user.full_name : '-' }}
                </template>
                <template v-slot:content-created_at="props">
                    {{ new Date(props.item.created_at).toLocaleString() }}
                </template>
            </Table>
        </template>
    </Page>
</template>

<script>
import {defineComponent, reactive, watch, onMounted} from 'vue';
import LogService from "@/services/LogService";
import {trans} from "@/helpers/i18n";
import {prepareQuery} from "@/helpers/api";

export default defineComponent({
    setup() {
        const service = new LogService();
        
        const mainQuery = reactive({
            page: 1,
            filters: {
                action: { value: '', comparison: '=' },
                module: { value: '', comparison: '=' }
            }
        });

        const table = reactive({
            headers: {
                user: trans('logs.labels.user'),
                action: trans('logs.labels.action'),
                module: trans('logs.labels.module'),
                description: trans('logs.labels.description'),
                ip_address: trans('logs.labels.ip_address'),
                created_at: trans('logs.labels.created_at')
            },
            records: [],
            pagination: {
                meta: null,
                links: null
            },
            loading: false
        });

        function fetchLogs() {
            table.loading = true;
            service.index(prepareQuery(mainQuery))
                .then(response => {
                    table.records = response.data.data;
                    table.pagination.meta = response.data.meta;
                    table.pagination.links = response.data.links;
                })
                .finally(() => {
                    table.loading = false;
                });
        }

        watch(mainQuery, () => {
            fetchLogs();
        });

        onMounted(() => {
            fetchLogs();
        });

        return {
            table,
            mainQuery,
            trans
        };
    }
});
</script> 