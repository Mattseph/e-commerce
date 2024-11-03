<script setup>
import { Head, usePage, router } from "@inertiajs/vue3";
import { onMounted, ref, reactive } from "vue";
import { initFlowbite } from "flowbite";
import { useToast } from "vue-toastification";
import AdminLayout from "../Layout/AdminLayout.vue";
import ProductList from "@/Components/Admin/Product/ProductList.vue";
import BrandList from "@/Components/Admin/Product/BrandList.vue";
import CategoryList from "@/Components/Admin/Product/CategoryList.vue";
import Pagination from "@/Components/Admin/Product/Pagination.vue";
import { Plus } from "@element-plus/icons-vue";
import { descriptionItemProps } from "element-plus";

onMounted(() => {
    initFlowbite();
});

const products = usePage().props.products;
const brands = usePage().props.brands;
const categories = usePage().props.categories;

const dialogVisible = ref(false);
const addModal = ref(false);
const editModal = ref(false);

const toast = useToast();

const dialogImageUrl = ref("");

const fields = reactive({
    id: "",
    title: "",
    price: "",
    quantity: "",
    description: "",
    category_id: "",
    brand_id: "",
    product_images: [],
    productImages: [],
    // inStock: 0,
    // published: 0,

});

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url;
    dialogVisible.value = true;
};

const handleRemove = (file) => {
    console.log(file);
};

const handleFileChange = (file) => {
    fields.productImages.push(file);
};

//Opening Modal

const openAddModal = () => {
    dialogVisible.value = true;
    addModal.value = true;
    editModal.value = false;
};

const addNewProduct = async () => {
    const Form = new FormData();

    Form.append("category_id", fields.category_id);
    Form.append("brand_id", fields.brand_id);
    Form.append("title", fields.title);
    Form.append("price", fields.price);
    Form.append("quantity", fields.quantity);
    Form.append("description", fields.description);

    for (const image of fields.productImages) {
        console.log(image.raw);
        Form.append("product_images[]", image.raw);
    }

    // Form.append("inStock", fields.inStock);
    // Form.append("published", fields.published);

    try {
        await router.post("product/", Form, {
            onSuccess: (page) => {
                toast.success("Successfully Added Product");
                // Use the returned newProduct data to update the products array
                if (page.props.newProduct) {
                    products.value.push(page.props.newProduct);
                }

                dialogVisible.value = false;
            },
        });
    } catch (error) {
        console.log(error.response || error);
    }
};

const openEditModal = (product) => {
    dialogVisible.value = true;
    addModal.value = false;
    editModal.value = true;

    fields.id = product.id;
    fields.title = product.title;
    fields.price = product.price;
    fields.quantity = product.quantity;
    fields.description = product.description;
    fields.category_id = product.category_id;
    fields.brand_id = product.brand_id;
    fields.product_images = product.product_images;

    // Format existing product images for el-upload
    fields.productImages = product.product_images.map((image) => ({
        name: image.image, // Use image name or any unique identifier
        url: `../storage/${image.image}`, // Full path for image preview
    }));
};

</script>

<template>
    <AdminLayout>
        <Head title="Product List" />

        <el-dialog v-model="dialogVisible" width="540">
            <div
                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600"
            >
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                    {{ editModal ? "Edit Product" : "Create New Product" }}
                </h3>
            </div>

            <form
                class="p-4 md:p-5"
                @submit.prevent="addNewProduct"
                enctype="multipart/form-data"
            >
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label
                            for="title"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Title</label
                        >
                        <input
                            v-model="fields.title"
                            type="text"
                            name="title"
                            id="title"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="Type product title"
                            required=""
                        />
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label
                            for="quantity"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Quantity</label
                        >
                        <input
                            v-model="fields.quantity"
                            type="number"
                            name="quantity"
                            id="quantity"
                            value="1"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="$2999"
                            required=""
                        />
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label
                            for="price"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Price</label
                        >
                        <input
                            v-model="fields.price"
                            type="number"
                            name="price"
                            id="price"
                            step=".01"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                            placeholder="$2999"
                            required=""
                        />
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label
                            for="brand"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Brand</label
                        >
                        <BrandList
                            v-model="fields.brand_id"
                            id="brand"
                            :brands="brands"
                            :brand_id="fields.brand_id"
                        />
                    </div>

                    <div class="col-span-2 sm:col-span-1">
                        <label
                            for="category"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Category</label
                        >
                        <CategoryList
                            v-model="fields.category_id"
                            id="category"
                            :categories="categories"
                            :category_id="fields.category_id"
                        />
                    </div>

                    <div class="col-span-2">
                        <label
                            for="description"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"
                            >Product Description</label
                        >
                        <textarea
                            v-model="fields.description"
                            id="description"
                            rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write product description here"
                        ></textarea>
                    </div>
                </div>

                <div class="col-span-2 pb-3">
                    <el-upload
                        v-model:file-list="fields.productImages"
                        multiple
                        :auto-upload="false"
                        list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-change="handleFileChange"
                        :on-remove="handleRemove"
                    >
                        <el-icon><Plus /></el-icon>
                    </el-upload>
                </div>

                <button
                    type="submit"
                    class="text-white inline-flex items-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                >
                    <svg
                        class="me-1 -ms-1 w-5 h-5"
                        fill="currentColor"
                        viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg"
                    >
                        <path
                            fill-rule="evenodd"
                            d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                            clip-rule="evenodd"
                        ></path>
                    </svg>
                    Add new product
                </button>
            </form>
            <!-- <template #footer>
                <div class="dialog-footer">
                    <el-button @click="dialogVisible = false">Cancel</el-button>
                    <el-button type="primary" @click="dialogVisible = false">
                        Confirm
                    </el-button>
                </div>
            </template> -->
        </el-dialog>

        <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
            <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
                <!-- Start coding here -->
                <div
                    class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden"
                >
                    <div
                        class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4"
                    >
                        <div class="w-full md:w-1/2">
                            <form class="flex items-center">
                                <label for="simple-search" class="sr-only"
                                    >Search</label
                                >
                                <div class="relative w-full">
                                    <div
                                        class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none"
                                    >
                                        <svg
                                            aria-hidden="true"
                                            class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            fill="currentColor"
                                            viewbox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg"
                                        >
                                            <path
                                                fill-rule="evenodd"
                                                d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                                clip-rule="evenodd"
                                            />
                                        </svg>
                                    </div>
                                    <input
                                        type="text"
                                        id="simple-search"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                        placeholder="Search"
                                        required=""
                                    />
                                </div>
                            </form>
                        </div>
                        <div
                            class="w-full md:w-auto flex flex-col md:flex-row space-y-2 md:space-y-0 items-stretch md:items-center justify-end md:space-x-3 flex-shrink-0"
                        >
                            <button
                                type="button"
                                @click="openAddModal"
                                class="flex items-center justify-center text-white bg-orange-500 hover:bg-yellow-600 focus:ring-4 focus:ring-orange-200 font-medium rounded-lg text-sm px-4 py-2 dark:bg-orange-500 dark:hover:bg-orange-600 focus:outline-none dark:focus:ring-orange-700"
                            >
                                <svg
                                    class="h-4 w-4 mr-2 mb-0.5"
                                    fill="currentColor"
                                    viewbox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                >
                                    <path
                                        clip-rule="evenodd"
                                        fill-rule="evenodd"
                                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                                    />
                                </svg>
                                Add product
                            </button>
                            <div
                                class="flex items-center space-x-3 w-full md:w-auto"
                            >
                                <button
                                    id="actionsDropdownButton"
                                    data-dropdown-toggle="actionsDropdown"
                                    class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    type="button"
                                >
                                    <svg
                                        class="-ml-1 mr-1.5 w-5 h-5"
                                        fill="currentColor"
                                        viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true"
                                    >
                                        <path
                                            clip-rule="evenodd"
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        />
                                    </svg>
                                    Actions
                                </button>
                                <div
                                    id="actionsDropdown"
                                    class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600"
                                >
                                    <ul
                                        class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="actionsDropdownButton"
                                    >
                                        <li>
                                            <a
                                                href="#"
                                                class="block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                                >Mass Edit</a
                                            >
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <a
                                            href="#"
                                            class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white"
                                            >Delete all</a
                                        >
                                    </div>
                                </div>
                                <button
                                    id="filterDropdownButton"
                                    data-dropdown-toggle="filterDropdown"
                                    class="w-full md:w-auto flex items-center justify-center py-2 px-4 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700"
                                    type="button"
                                >
                                    <svg
                                        xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true"
                                        class="h-4 w-4 mr-2 text-gray-400"
                                        viewbox="0 0 20 20"
                                        fill="currentColor"
                                    >
                                        <path
                                            fill-rule="evenodd"
                                            d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z"
                                            clip-rule="evenodd"
                                        />
                                    </svg>
                                    Filter
                                    <svg
                                        class="-mr-1 ml-1.5 w-5 h-5"
                                        fill="currentColor"
                                        viewbox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg"
                                        aria-hidden="true"
                                    >
                                        <path
                                            clip-rule="evenodd"
                                            fill-rule="evenodd"
                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        />
                                    </svg>
                                </button>
                                <div
                                    id="filterDropdown"
                                    class="z-10 hidden w-48 p-3 bg-white rounded-lg shadow dark:bg-gray-700"
                                >
                                    <h6
                                        class="mb-3 text-sm font-medium text-gray-900 dark:text-white"
                                    >
                                        Choose brand
                                    </h6>
                                    <ul
                                        class="space-y-2 text-sm"
                                        aria-labelledby="filterDropdownButton"
                                    >
                                        <li class="flex items-center">
                                            <input
                                                id="apple"
                                                type="checkbox"
                                                value=""
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                            />
                                            <label
                                                for="apple"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                                >Apple (56)</label
                                            >
                                        </li>
                                        <li class="flex items-center">
                                            <input
                                                id="fitbit"
                                                type="checkbox"
                                                value=""
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                            />
                                            <label
                                                for="fitbit"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                                >Microsoft (16)</label
                                            >
                                        </li>
                                        <li class="flex items-center">
                                            <input
                                                id="razor"
                                                type="checkbox"
                                                value=""
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                            />
                                            <label
                                                for="razor"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                                >Razor (49)</label
                                            >
                                        </li>
                                        <li class="flex items-center">
                                            <input
                                                id="nikon"
                                                type="checkbox"
                                                value=""
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                            />
                                            <label
                                                for="nikon"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                                >Nikon (12)</label
                                            >
                                        </li>
                                        <li class="flex items-center">
                                            <input
                                                id="benq"
                                                type="checkbox"
                                                value=""
                                                class="w-4 h-4 bg-gray-100 border-gray-300 rounded text-primary-600 focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500"
                                            />
                                            <label
                                                for="benq"
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-100"
                                                >BenQ (74)</label
                                            >
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="overflow-x-auto">
                        <table
                            class="w-full text-sm text-left text-gray-500 dark:text-gray-400"
                        >
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400"
                            >
                                <tr>
                                    <th scope="col" class="px-4 py-3">
                                        Product name
                                    </th>
                                    <th scope="col" class="px-4 py-3">
                                        Category
                                    </th>
                                    <th scope="col" class="px-4 py-3">Brand</th>
                                    <th scope="col" class="px-4 py-3">Stock</th>
                                    <th scope="col" class="px-4 py-3">Price</th>
                                    <th scope="col" class="px-4 py-3">
                                        <span class="sr-only">Actions</span>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <ProductList
                                    v-for="product in products"
                                    :key="product.id"
                                    :product="product"
                                    :editModal="openEditModal"
                                />
                            </tbody>
                        </table>
                    </div>

                    <Pagination />
                </div>
            </div>
        </section>
    </AdminLayout>
</template>
