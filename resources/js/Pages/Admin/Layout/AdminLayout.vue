<script setup>
import Header from "@/Pages/Admin/Components/Header.vue";
import Sidebar from "@/Pages/Admin/Components/Sidebar.vue";
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Header -->

        <Header />

        <!-- Sidebar -->

        <Sidebar />

        <slot />
    </div>
</template>
