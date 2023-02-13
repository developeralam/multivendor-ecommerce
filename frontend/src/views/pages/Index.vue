<script setup>
import { ref, onMounted } from 'vue';
import { Swiper, SwiperSlide } from "swiper/vue";
import { useSlider, useCategory, useProduct } from '@/store'
import {productCard, productPrice} from '@/components/product'
import { SliderScreen, CategoryScreen, ProductScreen } from '@/components/skeleton'
// Import Swiper styles
import "swiper/css";
import "swiper/css/pagination";
import "swiper/css/navigation";
// import required modules
import { Pagination, Autoplay, Navigation } from "swiper";
import { storeToRefs } from 'pinia';
const modules = ref([Pagination, Autoplay]);
const newModules = ref([Navigation]);
const slider = useSlider();
const cat = useCategory();
const product = useProduct();
const { sliders } = storeToRefs(slider);
const { categories } = storeToRefs(cat);
const { sales, populars, features, newItems } = storeToRefs(product);
onMounted(() => {
    slider.getSlider();

    cat.getCat();
    product.index('sale');

    product.index('popular');
    product.index('feature');
    product.index('new');
})
</script>
<template>
  <div>
        <section class="banner-part">
            <div class="">
                <div class="row">
                    <div class="col-lg-12 order-0 order-lg-1 order-xl-1">
                        <template v-if="sliders.data">
                            <div class="home-grid-slider slider-arrow slider-dots">
                                <swiper :spaceBetween="30" :pagination="{
                                    clickable: true,
                                }" :loop="true" :autoplay="{
                                  delay: 2500,
                                }" :modules="modules" class="mySwiper">
                                    <swiper-slide v-for="slider in sliders.data" :key="slider.index"><img :src="$filters.imagePath(slider.image)"
                                            alt="" /></swiper-slide>
                                </swiper>
                            </div>
                        </template>
                        <template v-else>
                            <SliderScreen />
                        </template>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="section suggest-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h3 style="float: left">SHOP BY CATEGORIES</h3>
                        </div>
                    </div>
                </div>
    
                <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <template v-if="categories.data">
                        <div class="col" v-for="(category, index) in categories.data" :key="index">
                            <div class="product-card">
                                <ul>
                                    <li>
                                        <a class="suggest-card" href="shop-4column.html">
                                            <img :src="$filters.imagePath(category.image)" alt="" />
                                        </a>
                                    </li>
                                </ul>
                        
                                <h6 class="text-center mt-2">{{category.name}}</h6>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <CategoryScreen :dataAmount="10"/>
                    </template>
                    
                </div>
            </div>
        </section>
    
        <section class="section recent-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>recently sold items</h2>
                        </div>
                    </div>
                </div>
                <template v-if="sales.data">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                    <productCard :product="product" v-for="(product, index) in sales.data" :key="index"/>
                    </div>
                </template>
                <template v-else>
                    <ProductScreen :dataAmount="10" />
                </template>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-btn-25">
                            <a href="shop-4column.html" class="btn btn-outline"><i class="fas fa-eye"></i><span>show
                                    more</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="section recent-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>Popular items</h2>
                        </div>
                    </div>
                </div>
                
                <template v-if="populars.data">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                        <productCard :product="product" v-for="(product, index) in populars.data" :key="index" />
                    </div>
                </template>
                <template v-else>
                    <ProductScreen :dataAmount="10" />
                </template>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-btn-25">
                            <a href="shop-4column.html" class="btn btn-outline"><i class="fas fa-eye"></i><span>show
                                    more</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="section recent-part">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-heading">
                            <h2>Feature items</h2>
                        </div>
                    </div>
                </div>
                
                <template v-if="features.data">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                        <productCard :product="product" v-for="(product, index) in features.data" :key="index" />
                    </div>
                </template>
                <template v-else>
                    <ProductScreen :dataAmount="10" />
                </template>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="section-btn-25">
                            <a href="shop-4column.html" class="btn btn-outline"><i class="fas fa-eye"></i><span>show
                                    more</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    
        <section class="section newitem-part">
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="section-heading">
                            <h2>collected new items</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        
                        <template v-if="newItems.data">
                            <ul class="new-slider slider-arrow">
                                <swiper :slidesPerView="5" :slidesPerGroup="3" :loop="true" :loopFillGroupWithBlank="true" :navigation="true"
                                    :modules="newModules" class="mySwiper">
                                    <swiper-slide v-for="(nitem, index) in newItems.data" :key="index">
                                        <li>
                                            <div class="product-card">
                                                <div class="product-media">
                                                    <div class="product-label">
                                                        <label class="label-text new">New</label>
                                                    </div>
                                                    <button class="product-wish wish">
                                                        <i class="fas fa-heart"></i></button><a class="product-image" href="product-video.html"><img
                                                            :src="$filters.imagePath(nitem.thumbnail)" alt="product" /></a>
                                                </div>
                                                <div class="product-content">
                                                    <h6 class="product-name">
                                                        <a href="product-video.html">{{ nitem.name}}</a>
                                                    </h6>
                                                    <productPrice :price="nitem.price" :discount="nitem.discount" />
                                                    <button class="product-add" title="Add to Cart">
                                                        <i class="fas fa-shopping-basket"></i><span>Add</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </li>
                                    </swiper-slide>
                                </swiper>
                            </ul>
                        </template>
                        <template v-else>
                            <ProductScreen :dataAmount="5" />
                        </template>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="section-btn-25">
                            <a href="shop-4column.html" class="btn btn-outline"><i class="fas fa-eye"></i><span>show
                                    more</span></a>
                        </div>
                    </div>
                </div>
            </div>
        </section> 
  </div>
</template>
<script setup>
</script>
