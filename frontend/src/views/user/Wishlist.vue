<script setup>
import { productPrice } from "@/components/product";
import { useAuth, useNotification, useWishlist, useCart } from '@/store';
import { ref, onMounted } from "vue";
import { storeToRefs } from 'pinia';
const auth = useAuth();
const cart = useCart();
const wishlist = useWishlist();
const notify = useNotification();
const {user} = storeToRefs(auth);
const deleteWishlist = async (product) => {
    if (auth.user.data) {
        let res = await wishlist.addToWishList(product);
        if (res.status == 200) {
            let index = auth.user.meta.wishlists.findIndex((i) => i.id === product.id);
            auth.user.meta.wishlists.splice(index, 1);
            notify.success(`${product.name} Removed to Wishlist`);
        }
    }
}

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

onMounted(() => {
    wishlist.index();
})
</script>
<template>
<div>
    <section class="inner-section single-banner">
        <div class="container">
            <h2>wishlist</h2>
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="index.html">My Wishlist</a>
                </li>
            </ol>
        </div>
    </section>
    <section class="inner-section wishlist-part">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="table-scroll">
                        <table class="table-list">
                            <thead>
                                <tr>
                                    <th scope="col">Serial</th>
                                    <th scope="col">Product</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">shopping</th>
                                    <th scope="col">action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(product, index) in user.meta.wishlists" :key="index">
                                    <td class="table-serial">
                                        <h6>{{ ++index }}</h6>
                                    </td>
                                    <td class="table-image">
                                        <img :src="$filters.imagePath(product.thumbnail)"
                                            alt="product" />
                                    </td>
                                    <td class="table-name">
                                        <h6>{{product.name}}</h6>
                                    </td>
                                    <td class="table-price">
                                        <productPrice :price="product.price" :discount="product.discount"/>
                                    </td>
                                    <td class="table-shop">
                                        <button @click.prevent="addToCart(product)" class="product-add" title="Add to Cart">
                                            add to cart</button><!-- fas fa-spinner fa-spin -->
                                    </td>
                                    <td class="table-action">
                                        <i class="fas fa-spinner fa-spin text-danger" v-if="wishlist.loading == product.id"></i>
                                        <a @click.prevent="deleteWishlist(product)" v-else href="javascript::void(0)" title="Remove Wishlist"><i
                                                class="icofont-trash text-danger"></i></a>
                                                
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-5">
                        <button class="btn btn-outline">Load more items</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</template>