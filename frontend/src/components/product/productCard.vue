<script setup>
import { ref } from 'vue';
import { useCart, useNotification, useAuth, useWishlist } from '@/store';
import { productPrice } from '@/components/product'
import { storeToRefs } from 'pinia';
const props = defineProps({
    product: {
        type: Object,
        required: true
    },
});
const cart = useCart();
const auth = useAuth();
const wishlist = useWishlist();
const notify = useNotification();
const price = ref(0);
const addToCart = (product) => {
    
    if (product.discount) {
        var discount = (product.price * product.discount) / 100;
        var totalprice = product.price - discount;
        price.value = totalprice.toFixed();
    } else {
        price.value = product.price;
    }
    cart.addItem({
        id: product.id,
        name: product.name,
        price: price.value,
        thumbnail: product.thumbnail
    });
    notify.success(`${product.name} Added to cart`);
}
const addToWishList = async (product) => {
    if (auth.user.data) {
        let res = await wishlist.addToWishList(product);
        if (res.status == 201) {
            auth.user.meta.wishlists.unshift(product);
            notify.success(`${product.name} Added to Wishlist`);
        } else {
            let index = auth.user.meta.wishlists.findIndex((i) => i.id === product.id);
            auth.user.meta.wishlists.splice(index, 1);
            notify.success(`${product.name} Removed to Wishlist`);
        }
    } else {
        $("#loginModal").modal("show");
    }
}
</script>
<template>
    
        <div class="col">
            <div class="product-card">
                <div class="product-media">
                    <div class="product-label">
                        <label class="label-text sale">{{ product.conditions }}</label>
                    </div>
                    <i class="fas fa-spinner fa-spin text-danger product-wish wish" v-if="wishlist.loading == product.id"></i>
                    <button v-else class="product-wish wish" @click.prevent="addToWishList(product)">
                        <i class="fas fa-heart"></i></button>
                        <a class="product-image" href="product-video.html"><img
                            :src="$filters.imagePath(product.thumbnail)" alt="product" /></a>
                </div>
                <div class="product-content">
                    <h6 class="product-name">
                        <a href="product-video.html">{{ product.name }}</a>
                    </h6>
                    <productPrice :price="product.price" :discount="product.discount" />
                    <button @click.prevent="addToCart(product)" class="product-add" title="Add to Cart">
                        <i class="fas fa-shopping-basket"></i><span>Add</span>
                    </button>
                </div>
            </div>
        </div>
</template>