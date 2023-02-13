<script setup>
const props = defineProps({
    dataAmount: {
        type: Number,
        required: true,
        default:10,
    }
})
</script>
<template>
    <div class="col" v-for="(data, index) in dataAmount" :key="index">
        <div class="product-card">
            <ul>
                <li>
                    <a class="suggest-card" href="shop-4column.html">
                        <img src="@/assets/images/category/cat.jpg" alt="" />
                    </a>
                </li>
            </ul>
            <div class="ssc-line w-100"></div>
        </div>
    </div>
</template>
