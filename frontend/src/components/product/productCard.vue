<script setup>
import {productPrice} from '@/components/product'
const props = defineProps({
    products: {
        type: Object,
        required: true
    },
});
</script>
<template>
<div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
    <div class="col" v-for="(pro, index) in products.data" :key="index">
        <div class="product-card">
            <div class="product-media">
                <div class="product-label">
                    <label class="label-text sale">{{ pro.conditions }}</label>
                </div>
                <button class="product-wish wish">
                    <i class="fas fa-heart"></i></button><a class="product-image" href="product-video.html"><img
                        :src="pro.thumbnail" alt="product" /></a>
            </div>
            <div class="product-content">
                <h6 class="product-name">
                    <a href="product-video.html">{{ pro.name }}</a>
                </h6>
                <productPrice :price="pro.price" :discount="pro.discount"/>
                <button class="product-add" title="Add to Cart">
                    <i class="fas fa-shopping-basket"></i><span>Add</span>
                </button>
            </div>
        </div>
    </div>
</div>
</template>