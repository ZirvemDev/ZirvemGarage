<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs">
        <template #default>
            <div class="flex flex-col gap-4 md:flex-row md:items-center">
                <div class="flex-1">
                    <label for="plate" class="block text-sm font-medium text-gray-700">
                        {{ trans('garage.labels.plate') }}
                    </label>
                    <input
                        type="text"
                        id="plate"
                        name="plate"
                        v-model="mainQuery.filters.plate.value"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                </div>
                <div>
                    <button
                        class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mt-5"
                        @click="onSearch">
                        {{ trans('global.buttons.search') }}
                    </button>
                </div>
            </div>
            <div v-if="isLoading.value" class="flex justify-center mt-4">
                <div class="loader border-t-4 border-blue-500 rounded-full w-8 h-8 animate-spin"></div>
            </div>

            <div v-else-if="imageData.info" class="mt-4">
                <!-- Resim Bilgileri -->
                <div class="bg-gray-100 border border-gray-300 text-black p-2 rounded-t-md flex justify-between items-center">
                    <div>
                        <p class="text-sm font-semibold">Plaka: {{ imageData.info.plate }}</p>
                        <p class="text-sm font-semibold">Sorgulanma Tarihi: {{ imageData.info.date }}</p>
                    </div>
                    <button
                        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded"
                        @click="updateRequest">
                        {{ trans('sbm.update_button') }}
                    </button>
                </div>
            </div>
            <!-- Resim -->
            <img v-if="imageData.value" :src="imageData.value.imageUrl" alt="Search Result" class="rounded-b-lg shadow-lg border border-gray-300">
        </template>
    </Page>
</template>

<script>
import { trans } from "@/helpers/i18n";
import SbmService from "@/services/SbmService.ts";
import { reactive, defineComponent } from "vue";
import { toUrl } from "@/helpers/routing";
import Page from "@/views/layouts/Page";
import { useAlertStore } from "@/stores";

export default defineComponent({
    components: {
        Page,
    },
    setup() {
        const service = new SbmService();
        const alertStore = useAlertStore();

        const mainQuery = reactive({
            filters: {
                plate: {
                    value: "",
                    comparison: "=",
                },
            },
        });

        const page = reactive({
            title: trans("global.pages.sbm"),
            breadcrumbs: [
                {
                    name: trans("sbm.plate"),
                    to: toUrl("/sbm/plate"),
                    active: true,
                },
            ],
        });

        const isLoading = reactive({ value: false });

        const imageUrl = reactive({
            value: null, // Başlangıçta boş
        });

        const imageData = reactive({
            value: null, // Resim ve bilgi verisi
            info: null  // Bilgi verisi
        });

        function onSearch() {
            imageData.value = null; // Her sorgulamadan önce veriyi sıfırla
            imageData.info = null; // Her sorgulamadan önce veriyi sıfırla
            const plate = mainQuery.filters.plate.value;
            if (!plate) {
                alertStore.error(trans("sbm.errors.plate_required"));
                return;
            }

            isLoading.value = true; // İstek başladığında yükleme durumunu etkinleştir
            service
                .searchByPlate(plate)
                .then((response) => {
                    alertStore.success('Plaka sorgulama başarılı');
                    console.log(response);
                   // imageUrl.value = response.data.data; // Base64 veriyi ata

                    imageData.value =
                    {
                        imageUrl: response.data.data, // Resim URL'si
                    }
                        if(response.data.status !== 'first')
                        {
                            imageData.info = {
                                plate: response.data.plate,
                                date: response.data.date,
                            }
                        }
                    console.log(imageData);

                })
                .catch((error) => {
                    alertStore.error(trans("global.alerts.danger"));
                    console.error(error);
                })
                .finally(() => {
                    isLoading.value = false; // İstek tamamlandığında yükleme durumunu devre dışı bırak
                });
        }

        function updateRequest() {
            const plate = mainQuery.filters.plate.value;
            if (!plate) {
                alertStore.error(trans("sbm.errors.plate_required"));
                return;
            }

            isLoading.value = true; // İstek başladığında yükleme durumunu etkinleştir
            service
                .fetchDataByPlate(plate)
                .then((response) => {
                    alertStore.success('Plaka sorgulama başarılı');
                    console.log(response);
                   // imageUrl.value = response.data.data; // Base64 veriyi ata

                    imageData.value =
                    {
                        imageUrl: response.data.data, // Resim URL'si
                    }
                        if(response.data.status !== 'first')
                        {
                            imageData.info = {
                                plate: response.data.plate,
                                date: response.data.date,
                            }
                        }
                    console.log(imageData);

                })
                .catch((error) => {
                    alertStore.error(trans("global.alerts.danger"));
                    console.error(error);
                })
                .finally(() => {
                    isLoading.value = false; // İstek tamamlandığında yükleme durumunu devre dışı bırak
                });
        }
    

        return {
            trans,
            page,
            mainQuery,
            imageUrl,
            isLoading,
            onSearch,
            imageData,
            updateRequest,
        };
    },
});
</script>

<style scoped>
/* TailwindCSS classes used, no additional scoped CSS needed */
.loader {
    border-width: 4px;
    border-style: solid;
    border-color: transparent;
    border-top-color: #3b82f6; /* Tailwind'in mavi rengi */
    border-radius: 50%;
    width: 32px;
    height: 32px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    from {
        transform: rotate(0deg);
    }
    to {
        transform: rotate(360deg);
    }
}
</style>
