<script setup>

defineProps({
    product: Object,
    editModal: {
        type: Function,
    },
});
</script>

<template>
    <tr class="border-b dark:border-gray-700">
        <th
            scope="row"
            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white"
        >
            {{ product.title }}
        </th>
        <td class="px-4 py-3">{{ product.category.name }}</td>
        <td class="px-4 py-3">{{ product.brand.name }}</td>
        <td class="px-4 py-3">
            <span
                v-if="product.inStock === 0"
                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300"
                >Out of Stock</span
            >
            <span
                v-else
                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"
                >In Stock</span
            >
        </td>
        <td class="px-4 py-3">
            <span
                v-if="product.published === 0"
                class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-red-900 dark:text-red-300"
                >Unpublished</span
            >
            <span
                v-else
                class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-full dark:bg-green-900 dark:text-green-300"
                >Published</span
            >
        </td>
        <td class="px-4 py-3">$ {{ product.price }}</td>
        <td class="px-4 py-3 flex items-center justify-end">
            <button
                id="apple-imac-27-dropdown-button"
                :data-dropdown-toggle="'apple-imac-27-dropdown- '+ product.id"
                class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100"
                type="button"
            >
                <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    fill="currentColor"
                    viewbox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg"
                >
                    <path
                        d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z"
                    />
                </svg>
            </button>
            <div
                :id="'apple-imac-27-dropdown- '+ product.id"
                class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
            >
                <ul
                    class="py-1 text-sm text-gray-700 dark:text-gray-200"
                    aria-labelledby="apple-imac-27-dropdown-button"
                >
                    <li>
                        <a
                            href="#"
                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            >Show</a
                        >
                    </li>
                    <li>
                        <button
                            @click="editModal"
                            class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                            >Edit</button
                        >
                    </li>
                </ul>
                <div class="py-1">
                    <a
                        href="#"
                        class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                        >Delete</a
                    >
                </div>
            </div>
        </td>
    </tr>
</template>
