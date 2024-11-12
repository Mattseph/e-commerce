<script setup>
import { initFlowbite } from "flowbite";
import { onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/User/Header.vue";

onMounted(() => {
    initFlowbite();
});
</script>

<template>
    <Head title="Product Page"></Head>
    <Header />
</template>
