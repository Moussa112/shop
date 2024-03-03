<template>
    <section class="bg-gray-50 dark:bg-gray-900 p-3 sm:p-5">
        <el-dialog
            v-model="dialogVisible"
            :title="editMode ? 'Edit product' : 'Add product'"
            width="30%"
            :before-close="handleClose"
        >
            <form @submit.prevent="editMode ? updateProduct() : addProduct()" class="max-w-md mx-auto">
                <div class="relative z-0 w-full mb-5 group">
                    <input v-model="title" type="text" name="floating_title" id="floating_title" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                    <label for="floating_title" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Title</label>
                </div>
                <div class="relative z-0 w-full mb-5 group">
                    <label for="description" class="block mb-2 text-sm dark:text-white">Description</label>
                    <textarea v-model="description" id="description" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Your product description..."></textarea>
                </div>
                <div class="grid md:grid-cols-2 md:gap-6">
                    <div class="relative z-0 w-full mb-5 group">
                        <input v-model="price" type="number" step="any" name="floating_price" id="floating_price" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                        <label for="floating_price" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Price</label>
                    </div>
                    <div class="relative z-0 w-full mb-5 group">
                        <label for="categories" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                        <select id="categories" v-model="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
                        </select>
                    </div>
                </div>
                <div class="mb-6">
                    <el-upload
                        v-model:file-list="productImages"
                        list-type="picture-card"
                        multiple
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :on-change="handleFileChange"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75 5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5 1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5Zm10.5-11.25h.008v.008h-.008V8.25Zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
                        </svg>
                    </el-upload>
                </div>

                <div class="flex flex-nowrap mb-8">
                    <div v-for="(productImage, index) in product_images" :key="productImage.id" class="relative w-32 h-32">
                        <img class="w-32 h-32 rounded" :src="`/${productImage.image}`" alt="">
                        <span class="absolute top-0 right-8 transform -translate-y-1/2 w-3.5 h-3.5 bg-red-400 border-2 border-white dark:border-gray-800 rounded-full">
                            <span @click="deleteImage(productImage, index)" class="text-white text-xs absolute top-0 right">x</span>
                        </span>
                    </div>
                </div>

                <button type="submit" class="mr-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                <el-button @click="dialogVisible = false">Cancel</el-button>
            </form>
        </el-dialog>

        <div class="mx-auto max-w-screen-xl px-4 lg:px-12">
            <!-- Start coding here -->
            <button type="button" @click="openAddModal" class="mb-6 flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-primary-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <svg class="h-3.5 w-3.5 mr-2" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path clip-rule="evenodd" fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" />
                </svg>
                Add product
            </button>
            <div class="bg-white dark:bg-gray-800 relative shadow-md sm:rounded-lg overflow-hidden">
                <div class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-4">
                    <div class="w-full md:w-1/2">
                        <form class="flex items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <svg aria-hidden="true" class="w-5 h-5 text-gray-500 dark:text-gray-400" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Search" required="">
                            </div>
                        </form>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-4 py-3">Product name</th>
                            <th scope="col" class="px-4 py-3">Description</th>
                            <th scope="col" class="px-4 py-3">Category</th>
                            <th scope="col" class="px-4 py-3">Price</th>
                            <th scope="col" class="px-4 py-3">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr
                                v-for="product in products"
                                :key="product.id"
                                class="border-b dark:border-gray-700"
                            >
                            <th scope="row" class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ product.title }}
                            </th>
                            <td class="px-4 py-3">{{ product.description }}</td>
                            <td class="px-4 py-3">{{ product.category.name }}</td>
                            <td class="px-4 py-3">{{ product.price }}</td>
                            <td class="px-4 py-3 flex items-center justify-end">
                                <button :id="`${product.id}-button`" :data-dropdown-toggle="`${product.id}`" class="inline-flex items-center p-0.5 text-sm font-medium text-center text-gray-500 hover:text-gray-800 rounded-lg focus:outline-none dark:text-gray-400 dark:hover:text-gray-100" type="button">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div :id="`${product.id}`" class="hidden z-10 w-44 bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600">
                                    <ul class="py-1 text-sm text-gray-700 dark:text-gray-200" :aria-labelledby="`${product.id}-button`">
                                        <li>
                                            <a :href="`/products/${product.slug}`" class="w-full text-left block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Show</a>
                                        </li>
                                        <li>
                                            <button
                                                @click="openEditModal(product)"
                                                href="#" class="w-full text-left block py-2 px-4 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Edit</button>
                                        </li>
                                    </ul>
                                    <div class="py-1">
                                        <a href="#" @click="deleteProduct(product, index)" class="block py-2 px-4 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Delete</a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <nav class="flex flex-col md:flex-row justify-between items-start md:items-center space-y-3 md:space-y-0 p-4" aria-label="Table navigation">
                <span class="text-sm font-normal text-gray-500 dark:text-gray-400">
                    Showing
                    <span class="font-semibold text-gray-900 dark:text-white">{{ products.length }}</span>
                    products
                </span>
                </nav>
            </div>
        </div>
    </section>
</template>

<script setup>
import {router, usePage} from "@inertiajs/vue3";
import {ref} from "vue";
import Swal from "sweetalert2";

defineProps({
    products:Array
})

const categories = usePage().props.categories

const isAddProduct = ref(false)
const dialogVisible = ref(false)
const editMode = ref(false)

const id = ref('')
const title = ref('')
const description = ref('')
const price = ref('')
const category_id = ref('')
const productImages = ref([])
const product_images = ref([])
const dialogImageUrl = ref('')

const resetFormData = () => {
    id.value = ''
    title.value = ''
    description.value = ''
    price.value = ''
    category_id.value = ''
    productImages.value = []
}

const handleFileChange = (file) => {
    productImages.value.push(file)
}

const handlePictureCardPreview = (file) => {
    dialogImageUrl.value = file.url
    dialogVisible.value = true
}

const handleRemove = (file) => {
    console.log(file)
}

const openAddModal = () => {
    isAddProduct.value = true
    dialogVisible.value = true
    editMode.value = false
}

const addProduct = async () => {
    const data = new FormData()
    data.append('title', title.value)
    data.append('description', description.value)
    data.append('price', price.value)
    data.append('category_id', category_id.value)

    for (const image of productImages.value) {
        data.append('product_images[]', image.raw)
    }

    try {
        await router.post('products/store', data, {
            onSuccess: page => {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
                dialogVisible.value = false
                resetFormData()
            },
        })
    } catch (error) {
        console.log(error)
    }
}

const openEditModal = (product) => {
    editMode.value = true
    isAddProduct.value = false
    dialogVisible.value = true

    id.value = product.id
    title.value = product.title
    description.value = product.description
    price.value = product.price
    category_id.value = product.category_id
    product_images.value = product.product_images
}

const updateProduct = async () => {
    const data = new FormData()
    data.append('title', title.value)
    data.append('description', description.value)
    data.append('price', price.value)
    data.append('category_id', category_id.value)
    data.append('_method', 'PUT')

    for (const image of productImages.value) {
        data.append('product_images[]', image.raw);
    }

    try {
        await router.post('products/update/' + id.value, data, {
            onSuccess: (page) => {
                dialogVisible.value = false
                resetFormData()
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            }
        })
    } catch(error) {
        console.log(error)
    }
}

const deleteImage = async (productImage, index) => {
    try {
        await router.delete('/admin/products/image/' + productImage.id, {
            onSuccess:(page) => {
                product_images.value.splice(index, 1)
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            }
        })
    } catch(error) {
        console.log(error);
    }
}

const deleteProduct = async (product, index) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'This action cannot be undone!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, I am sure.',
    }).then((result) => {
        if (result.isConfirmed) {
            try {
                router.delete('products/delete/' + product.id, {
                    onSuccess: (page) => {
                        this.delete(product, index)
                        Swal.fire({
                            toast: true,
                            icon: 'success',
                            position: 'top-end',
                            showConfirmButton: false,
                            title: page.props.flash.success
                        })
                    }
                })
            } catch (error) {
                console.log(error)
            }
        }
    })

    try {
        await router.delete('/admin/products/image/' + productImage.id, {
            onSuccess:(page) => {
                product_images.value.splice(index, 1)
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            }
        })
    } catch(error) {
        console.log(error);
    }
}
</script>
