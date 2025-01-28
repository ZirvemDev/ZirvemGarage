<template>
    <Page :title="page.title" :breadcrumbs="page.breadcrumbs" :actions="page.actions" @action="onPageAction">
        <template #default>

        </template>
    </Page>
</template>

<script>
import router from "@/router";
import { defineComponent, reactive } from 'vue';

export default defineComponent({
    components: {
    },
    setup() {
        const page = reactive({
            title: "Garajlar",
            breadcrumbs: [
                {
                    name: "Garajlar",
                    active: true,
                }
            ],
            actions: [],
        });

        const garages = reactive([
            { id: 1, name: 'Garaj 1', description: 'Açıklama 1' },
            { id: 2, name: 'Garaj 2', description: 'Açıklama 2' },
        ]);

        function onGarageClick(garage) {
            // Burada tıklama işlemi yapabilirsiniz
            console.log(`Tıklanan garaj: ${garage.name}`);
            // İsterseniz garaj detay sayfasına yönlendirme yapabilirsiniz
             router.push(`/panel/garage/garage${garage.id}`);
        }

        return {
            page,
            garages,
            onGarageClick,
        }
    },
});
</script>

<style>
/* İsteğe bağlı stil ayarları */
.grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}
</style>
