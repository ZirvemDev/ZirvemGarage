<template>
    <div class="border p-4 rounded-lg cursor-pointer hover:bg-gray-100" @click="onClick">
        <h2 class="text-lg font-bold">{{ garage.name }}</h2>
        <p>{{ garage.description }}</p>
    </div>
</template>

<script>
export default {
    props: {
        garage: {
            type: Object,
            required: true,
        },
    },
    methods: {
        onClick() {
            this.$emit('click');
        },
    },
};
</script>

<style scoped>
.cursor-pointer {
    cursor: pointer;
}
</style>
