<script setup>
import { router } from "@inertiajs/vue3";

defineProps({
    products: {
        type: Object,
        required: true,
    },
    updatePageNumber: {
        type: Function,
        required: true,
    }
});

</script>
<template>
    <nav
        class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4"
        aria-label="Table navigation"
    >
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
            Showing
            <span class="font-bold text-orange-500 dark:text-white"
                >{{ products.meta.from }} - {{ products.meta.to }}</span
            >
            of
            <span class="font-bold text-orange-500 dark:text-white">{{
                products.meta.total
            }}</span>
        </span>
        <ul class="inline-flex items-stretch -space-x-px">
            <li v-for="(link, index) in products.meta.links">
                <a
                    @click.prevent="
                        !link.active && !link.url
                            ? ''
                            : updatePageNumber(link)
                    "
                    v-html="link.label"
                    :key="index"
                    class="flex items-center justify-center text-sm py-2 px-3 leading-tight text-gray-500 border border-orange-500"
                    :class="[
                        link.active
                            ? 'bg-orange-500 text-white'
                            : 'hover:bg-orange-500 hover:text-white',
                            !link.active && !link.url? 'pointer-events-none': 'cursor-pointer',
                    ]"
                ></a>
            </li>
        </ul>
    </nav>
</template>
