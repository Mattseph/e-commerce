<script setup>
defineProps({
    brands: {
        type: Array,
        required: true,
    },
});

const model = defineModel({
    type: Number,
    required: true,
});

</script>

<template>
    <select
        v-model="model"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
    >
        <option selected value="" disabled hidden>Select Brand</option>

        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
            {{ brand.name }}
        </option>
    </select>
</template>
