<script setup>
import Header from "@/Components/Admin/Header.vue";
import Sidebar from "@/Components/Admin/Sidebar.vue";
</script>

<template>
    <div class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Header -->

        <Header />

        <!-- Sidebar -->

        <Sidebar />

        <main class="p-4 md:ml-64 h-auto pt-20">
            <slot />
        </main>
    </div>
</template>
