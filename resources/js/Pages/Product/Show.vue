<template>
    <UserLayout>
        <div class="font-[sans-serif]">
            <div class="max-w-screen-xl px-6 mx-auto">
                <div class="grid items-start grid-cols-1 lg:grid-cols-2 gap-8">
                    <div class="w-full lg:sticky top-0 sm:flex gap-2">
                        <div class="sm:space-y-3 w-16 max-sm:flex max-sm:mb-4 max-sm:gap-4">
                            <img @click="setBigPicture(productImage)" v-for="(productImage, index) in product.product_images" :key="productImage.id" :src="`/${productImage.image}`" class="w-full cursor-pointer" />
                        </div>
                        <img v-if="previewImageUrl" :src="`/${previewImageUrl}`" alt="Product" class="w-4/5 rounded object-cover" />
                        <img v-else-if="product.product_images.length > 0" :src="`/${product.product_images[0].image}`" alt="Product" class="w-4/5 rounded object-cover" />
                        <img v-else src="/misc/no-image.jpeg" alt="Product" class="w-4/5 rounded object-cover" />
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-gray-800">{{ product.title }}</h2>
                        <h3 class="text-1xl  text-gray-400">{{ product.category.name }}</h3>
                        <div class="flex flex-wrap gap-4 mt-4">
                            <p class="text-gray-800 text-xl font-bold">€{{ product.price }}</p>
                        </div>
                        <div class="mt-8">
                            <h3 class="text-lg font-bold text-gray-800">About the item</h3>
                            <div>
                                {{ product.description }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import {router} from "@inertiajs/vue3";
import UserLayout from "@/Pages/Layout/UserLayout.vue";
import Swal from "sweetalert2";
import {ref} from "vue";

defineProps({
    product:Object
})

const previewImageUrl = ref('');

const setBigPicture = (product) => {
    previewImageUrl.value = product.image;
};

const addToCart = (product) => {
    console.log(product);
    router.post(route('cart.store'), product, {
        onSuccess: (page) => {
            if (page.props.flash.success) {
                Swal.fire({
                    toast: true,
                    icon: 'success',
                    position: 'top-end',
                    showConfirmButton: false,
                    title: page.props.flash.success
                })
            }
        }
    })
}
</script>
