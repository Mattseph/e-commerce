<script setup>

import { initFlowbite } from "flowbite";
import { onMounted } from "vue";
import HeaderLayout from "./HeaderLayout.vue";
import HeroLayout from "./HeroLayout.vue";
import FooterLayout from "./FooterLayout.vue";

onMounted(() => {
    initFlowbite();
});

</script>

<template>
    <HeaderLayout />

    <HeroLayout />

    <slot />

    <FooterLayout />
</template>
