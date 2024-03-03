<template>
    <Header />
    <slot />
    <Footer />
</template>

<script setup>
import {onMounted} from "vue";
import {initFlowbite} from "flowbite";
import Header from "@/Pages/Layout/Header.vue";
import Footer from "@/Pages/Layout/Footer.vue";

onMounted(() => {
    initFlowbite();
})


</script>
