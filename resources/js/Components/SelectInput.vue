<script setup>
const model = defineModel({
    type: String,
    required: true,
});

</script>

<template>

<select class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" v-model="model">
    <option value="" disabled hidden selected>Select</option>
    <option value="Administrator">Administrator</option>
    <option value="Customer">Customer</option>
</select>


</template>
