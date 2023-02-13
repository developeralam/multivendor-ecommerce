<script setup>
import { ref, onMounted, computed } from 'vue';
import { productCard } from '@/components/product';
import { ProductScreen, ShopSidebarScreen } from '@/components/skeleton';
import { useShop } from '@/store';
import { storeToRefs } from 'pinia';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
const shop = useShop();
const show = ref(12);
const sort = ref('default');
const { products, sidebar } = storeToRefs(shop);
const getProduct = async (page = 1) => {
    products.value = [];
    shop.index(
        page,
        show.value,
        sort.value,
        selectedBrand.value,
        selectedCat.value,
        price_range.value,
    );
}
onMounted(() => {
    getProduct();
    shop.sidebarData();
})

//Category and brand search
const searchBrandQuery = ref('');
const searchCatQuery = ref('');

const searchedBrands = computed(() => {
    return shop.sidebar.data.brands.filter((brand) => {
        return brand.name.toLowerCase().match(searchBrandQuery.value.toLowerCase());
    });
});
const searchedCats = computed(() => {
    return shop.sidebar.data.category.filter((cat) => {
        return cat.name.toLowerCase().match(searchCatQuery.value.toLowerCase());
    });
});
const selectedBrand = ref([]);
const selectedCat = ref([]);
const price_range = ref('');
</script>
<template>
  <div>
    <section class="inner-section single-banner" style="background: url(images/single-banner.jpg) no-repeat center">
        <div class="container">
            <h2>Shop Page</h2>
        </div>
    </section>
    <section class="inner-section shop-part">
        <div class="container">
            <div class="row content-reverse">
                <div class="col-lg-3">
                    <!-- <div class="shop-widget-promo">
                <a href="#"><img src="images/promo/shop/01.jpg" alt="promo" /></a>
              </div> -->
              <template v-if="sidebar.data">
                <div class="shop-widget">
                    <h6 class="shop-widget-title">Filter by Price</h6>
                        <el-slider v-model="price_range" @change="getProduct" range show-stops :max="sidebar.data.price.max_price" :min="sidebar.data.price.min_price" />
                        <div class="shop-widget-group">
                            <input type="text" :placeholder="`Min - ${$filters.currencySymbol(sidebar.data.price.min_price)}`"><input
                                type="text" :placeholder="`Max - ${$filters.currencySymbol(sidebar.data.price.max_price)}`">
                        </div>
                </div>
                
                <div class="shop-widget">
                    <h6 class="shop-widget-title">Filter by Brand</h6>
                    <form>
                        <input class="shop-widget-search" type="text" v-model="searchBrandQuery" placeholder="Search...">
                        <ul class="shop-widget-list shop-widget-scroll">
                            <li v-for="brand in searchedBrands" :key="brand.id">
                                <div class="shop-widget-content">
                                    <input type="checkbox" @change="getProduct" :value="brand.id" v-model="selectedBrand" :id="`brand${brand.id}`"><label :for="`brand${brand.id}`">{{ brand.name }}</label>
                                </div>
                                <span class="shop-widget-number">({{ brand.products_count }})</span>
                            </li>
                
                        </ul>
                        <button class="shop-widget-btn">
                            <i class="far fa-trash-alt"></i><span>clear filter</span>
                        </button>
                    </form>
                </div>
                <div class="shop-widget">
                    <h6 class="shop-widget-title">Filter by Category</h6>
                    <form>
                        <input class="shop-widget-search" type="text" v-model="searchCatQuery" placeholder="Search...">
                        <ul class="shop-widget-list shop-widget-scroll">
                            <li v-for="category in searchedCats" :key="category.id">
                                <div class="shop-widget-content">
                                    <input type="checkbox" @change="getProduct" :value="category.id" v-model="selectedCat" :id="`cate${category.id}`"><label :for="`cate${category.id}`">{{category.name}}</label>
                                </div>
                                <span class="shop-widget-number">({{category.products_count}})</span>
                            </li>
                
                        </ul>
                        <button class="shop-widget-btn">
                            <i class="far fa-trash-alt"></i><span>clear filter</span>
                        </button>
                    </form>
                </div>
              </template>
              <template v-else>
                <ShopSidebarScreen />
              </template>
                    
                </div>
                <div class="col-lg-9">
                    <!-- {{ searchedBrands }} -->
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="top-filter">
                                <div class="filter-show">
                                    <label class="filter-label">Show :</label><select @change="getProduct()" v-model="show" class="form-select filter-select">
                                        <option value="12">12</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                    </select>
                                </div>
                                <div class="filter-short">
                                    <label class="filter-label">Short by :</label><select v-model="sort" @change="getProduct()" class="form-select filter-select">
                                        <option selected="">default</option>
                                        <option value="3">trending</option>
                                        <option value="1">featured</option>
                                        <option value="2">recommend</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <template v-if="products.data">
                    <div class="row row-cols-2 row-cols-md-3 row-cols-lg-3 row-cols-xl-4">
                        <productCard :product="product" v-for="(product, index) in products.data" :key="index"/>
                    </div>
                    </template>
                    <template v-else>
                        <ProductScreen :dataAmount="12" :cols="4"/>
                    </template>
                    <div class="row" v-if="products">
                        <div class="col-lg-12">
                            <div class="bottom-paginate">
                                <p class="page-info">Showing {{ products.per_page }} of {{ products.total }} Results</p>
                                <ul class="pagination">
                                    <Bootstrap5Pagination :data="products" @pagination-change-page="getProduct">
                                        <template #prev-nav>
                                            <a class="page-link" href="#"><i class="fas fa-long-arrow-alt-left"></i></a>
                                        </template>
                                        <template #next-nav>
                                            <a class="page-link" href="#"><i class="fas fa-long-arrow-alt-right"></i></a>
                                        </template>
                    
                                    </Bootstrap5Pagination>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
  </div>
</template>


<style>

</style>