<script setup>
import { computed } from 'vue';
const props = defineProps({
    price: {
        type: Number,
        required: true,
        default:0
    },
    discount: {
        type: Number,
        required: true,
        default:0
    }
})
const discountPrice = computed(() => {
    
    var discount = (props.price * props.discount) / 100;
    var totalprice = props.price - discount;
    return totalprice.toFixed();
})
</script>
<template>
  <div>
    <h6 class="product-price" v-if="discount">
        <del>{{ $filters.currencySymbol(price) }}</del><span>{{ $filters.currencySymbol(discountPrice) }}<small></small></span>
    </h6>
    <h6 class="product-price" v-else>
        <span>{{ $filters.currencySymbol(price) }}</span>
    </h6>
  </div>
</template>