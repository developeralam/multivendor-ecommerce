<script setup>
import { useCart, useNotification } from '@/store';
import { storeToRefs } from 'pinia';
const cart = useCart();
const notify = useNotification();
const { cartItems, cartItemsCount, totalPrice } = storeToRefs(cart);
const cartClose = () => {
    $("body").css("overflow", "inherit"),
    $(".cart-sidebar").removeClass("active"),
    $(".backdrop").fadeOut();
}
const cartDestroy = (index)=>{
    cart.destroy(index);
    notify.success('Item removed successfully');
}
const showCoupon = () => {
    $('.coupon-btn').hide(), $(".coupon-form").css("display", "flex");
}
const cartIncrement = (product) => {
    console.log(product);
    cart.addItem(product);
}
const cartDecrement = (index) => {
    cart.incrementQuantity(index);
}
</script>
<template>
  <div>
    <aside class="cart-sidebar">
        <div class="cart-header">
            <div class="cart-total">
                <i class="fas fa-shopping-basket"></i><span>total item ({{ cartItemsCount }})</span>
            </div>
            <button class="cart-close" @click="cartClose"><i class="icofont-close"></i></button>
        </div>
        <Transition name="switch">
            <TransitionGroup class="cart-list" v-if="cartItemsCount !== 0" name="list" tag="ul">
            <li class="cart-item" v-for="(item, index) in cartItems" :key="index">
                <div class="cart-media">
                    <a href="#"><img :src="$filters.imagePath(item.thumbnail)" alt="product" /></a><button @click.prevent="cartDestroy(index)" class="cart-delete">
                        <i class="far fa-trash-alt"></i>
                    </button>
                </div>
                <div class="cart-info-group">
                    <div class="cart-info">
                        <h6><a href="product-single.html">{{item.name}}</a></h6>
                        <p>Unit Price - {{ $filters.currencySymbol(item.price) }}</p>
                    </div>
                    <div class="cart-action-group">
                        <div class="product-action">
                            <button @click.prevent="cartDecrement(index)" class="action-minus" title="Quantity Minus">
                                <i class="icofont-minus"></i></button><input class="action-input" title="Quantity Number"
                                type="text" name="quantity" :value="item.quantity" /><button @click.prevent="cartIncrement(item)" class="action-plus" title="Quantity Plus">
                                <i class="icofont-plus"></i>
                            </button>
                        </div>
                        <h6>{{ $filters.currencySymbol(item.price * item.quantity) }}</h6>
                    </div>
                </div>
            </li>
            </TransitionGroup>
            <ul class="cart-list" v-else>
                <li class="cart-item">
                    <h3 class="text-center">Your Cart Is Empty</h3>
                </li>
            </ul>
        </Transition>
        <div class="cart-footer">
            <button class="coupon-btn" @click="showCoupon">Do you have a coupon code?</button>
            <form class="coupon-form">
                <input type="text" placeholder="Enter your coupon code" /><button type="submit">
                    <span>apply</span>
                </button>
            </form>
            <router-link class="cart-checkout-btn" :to="{name:'user.checkout'}"><span class="checkout-label">Proceed to Checkout</span><span
                    class="checkout-price">{{ $filters.currencySymbol(totalPrice) }}</span></router-link>
        </div>
    </aside>
  </div>
</template>
<style scoped>
.list-move,
.list-enter-active,
.list-leave-active {
    transition: all 1s ease;
}

.list-enter-from,
.list-leave-to {
    opacity: 0;
    transform: translateX(30px);
    transition: all 1s ease;
}

.switch-enter-active,
.switch-leave-active {
    transition: opacity 0.5s ease;
}

.switch-enter-from,
.switch-leave-to {
    opacity: 0;
}
</style>