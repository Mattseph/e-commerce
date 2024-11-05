<script setup>
const props = defineProps({
    categories: {
        type: Array,
        required: true,
    },
    category_id: {
        type: Number,
    }
});



</script>

<template>
    <select v-model="props.category_id"
        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
    >
        <option value="" selected disabled hidden>Select category</option>
        <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
        >
            {{ category.name }}
        </option>
    </select>
</template>
