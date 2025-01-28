<template>
    <Page>
        <div class="w-1/2 m-auto text-center pt-10">
            <h1 class="text-6xl mb-4 font-bold text-gray-600">SBM (TRAMER) Sistemi</h1>
            <h4 class="text-gray-500 text-2xl">{{ new Date().toLocaleString('tr-TR', {timeZone: 'Europe/Istanbul'}) }}</h4>
        </div>
    </Page>
</template>

<script>
import {defineComponent} from 'vue';
import {trans} from "@/helpers/i18n";
import Page from "@/views/layouts/Page";

export default defineComponent({
    components: {
        Page
    },
    setup() {
        return {
            trans
        }
    }
});
</script>
