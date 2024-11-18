<script setup>
import { initFlowbite } from "flowbite";
import { onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import Header from "@/Components/User/Header.vue";
import Hero from "@/Components/User/Hero.vue";
import Footer from "@/Components/User/Footer.vue";

onMounted(() => {
    initFlowbite();
});
</script>

<template>
    <Head title="Product Page"></Head>

    <Header />

    <Hero />

    <Footer />
</template>
