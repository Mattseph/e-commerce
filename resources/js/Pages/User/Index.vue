<script setup>
import { initFlowbite } from "flowbite";
import { onMounted } from "vue";
import { Head } from "@inertiajs/vue3";
import UserLayout from "@/Layouts/User/UserLayout.vue";

onMounted(() => {
    initFlowbite();
});

const props = defineProps({
    products: {
        type: Object,
        required: true,
    },
});

console.log(props.products);
</script>

<template>
    <UserLayout>
        <Head title="Product Page"></Head>

        <div class="bg-white">
            <div
                class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8"
            >
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">
                    Customers also purchased
                </h2>

                <div
                    class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8"
                >
                    <div
                        v-for="product in props.products.data"
                        class="group relative"
                    >
                        <div
                            class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80"
                        >
                            <img
                                v-if="product.product_images.length > 0"
                                :src="`/${product.product_images[0].image}`"
                                alt="Front of men&#039;s Basic Tee in black."
                                class="h-full w-full object-cover object-center lg:h-full lg:w-full"
                            />
                            <img
                                v-else
                                src="https://tailwindui.com/plus/img/ecommerce-images/product-page-01-related-product-01.jpg"
                                alt="Front of men&#039;s Basic Tee in black."
                                class="h-full w-full object-cover object-center lg:h-full lg:w-full"
                            />
                        </div>
                        <div class="mt-4 flex justify-between">
                            <div>
                                <h3 class="text-sm text-gray-700">
                                    <a href="#">
                                        <span
                                            aria-hidden="true"
                                            class="absolute inset-0"
                                        ></span>
                                        {{ product.title }}
                                    </a>
                                </h3>
                                <p class="mt-1 text-sm text-gray-500">
                                    {{ product.brand.name }}
                                </p>
                            </div>
                            <p class="text-sm font-medium text-gray-900">
                                ${{ product.price }}
                            </p>
                        </div>
                    </div>

                    <!-- More products... -->
                </div>
            </div>
        </div>
    </UserLayout>
</template>
