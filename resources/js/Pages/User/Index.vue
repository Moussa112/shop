<template>

    <UserLayout>
        <Hero />

<!--        <div v-if="$page.props.auth.user" class="bg-white">-->
        <div class="bg-white">
            <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">Our latest products</h2>

                <Products :products="products"></Products>
            </div>
        </div>
    </UserLayout>
</template>

<script setup>
import {router} from "@inertiajs/vue3";
import UserLayout from "@/Pages/Layout/UserLayout.vue";
import Swal from "sweetalert2";
import Hero from "@/Pages/Layout/Hero.vue";
import Products from '../User/Components/Products.vue'

defineProps({
    products:Array
})
const addToCart = (product) => {
    console.log(product);
    router.post(route('cart.store', product), {
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
