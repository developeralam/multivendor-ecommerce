<script setup>
import { useAuth,useNotification } from '@/store';
import { storeToRefs } from 'pinia';
import { useRouter } from 'vue-router';
const auth = useAuth();
const notify = useNotification();
const { user, logoutLoading } = storeToRefs(auth);
const router = useRouter();
const logout = async () => {
    const res = await auth.logout();
    if (res.status === 200) {
        router.push({ name: 'index' });
        notify.success('Logout Successfull');
    }
}
const showCart = () => {
    $("body").css("overflow", "hidden"),
        $(".cart-sidebar").addClass("active")
}
const showSidebar = () => {
    $("body").css("overflow", "hidden"),
        $(".nav-sidebar").addClass("active")
}
const showSeach = () => {
    $(".header-form").toggleClass("active"),
        $('.header-src').children(".fa-search").toggleClass("fa-times");
}
</script>
<template>
  <div>
    <div class="header-top">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-lg-5">
                    <div class="header-top-welcome">
                        <p>Welcome to Ecomart in Your Dream Online Store!</p>
                    </div>
                </div>
                <div class="col-md-5 col-lg-3"></div>
                <div class="col-md-7 col-lg-4">
                    <ul class="header-top-list">
                        <li><router-link :to="{name:'pages.seller.apply'}" href="offer.html">Seller Apply</router-link></li>
                        <li><a href="faq.html">need help</a></li>
                        <li><a href="contact.html">contact us</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    
    <header class="header-part">
        <div class="container">
            <div class="header-content">
                <div class="header-media-group">
                    <button class="header-user" @click="showSidebar">
                        <img src="@/assets/images/menu.png" alt="user" /></button><router-link :to="{ name:'index'}"><img
                            src="@/assets/images/logo.png" alt="logo" /></router-link><button class="header-src" @click="showSeach"><i
                            class="fas fa-search"></i></button>
                </div>
                <router-link :to="{name:'index'}" class="header-logo"><img src="@/assets/images/logo.png" alt="logo" /></router-link>
    
                <form class="header-form">
                    <input type="text" placeholder="Search anything..." /><button>
                        <i class="fas fa-search"></i>
                    </button>
                </form>
                <div class="header-widget-group">
                    <li class="nav-item dropdown">
                        <a class="nav-link header-widget" href="#" data-bs-toggle="dropdown"><i class="fas fa-user"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end" v-if="user.data">
                            
                            <li>
                                <router-link :to="{name:'user.profile'}" class="dropdown-item">Profile</router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'user.order'}" class="dropdown-item">Orders</router-link>
                            </li>
                            <li>
                                <router-link :to="{name:'user.wishlist'}" class="dropdown-item">WisthList</router-link>
                            </li>
                            <li>
                                <button :disabled="logoutLoading" @click="logout" class="dropdown-item">Logout <span v-show="logoutLoading" class="spinner-border spinner-border-sm mr-1"></span></button>
                            </li>
                        </ul>
                        <ul class="dropdown-menu dropdown-menu-end" v-else>
                            <li><router-link :to="{name:'user.login'}" class="dropdown-item"> Login</router-link></li>
                            <li>
                                <router-link :to="{name:'user.register'}" class="dropdown-item"> Register</router-link>
                            </li>
                        </ul>
                    </li>
    
                    <a href="wishlist.html" class="header-widget" title="Wishlist"><i
                            class="fas fa-heart"></i><sup>0</sup></a><button @click="showCart" class="header-widget header-cart"
                        title="Cartlist">
                        <i class="fas fa-shopping-basket"></i><sup>9+</sup><span>total price<small>$345.00</small></span>
                    </button>
                </div>
            </div>
        </div>
    </header>
  </div>
</template>
<style>
.nav-item:hover .dropdown-menu{
    display:block!important;
}
</style>
