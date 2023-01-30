import { defineStore } from 'pinia';
import axiosInstance from '@/services/axios';

export const useProduct = defineStore('product', {
    state: () => ({
        products: {

        },
        sales: [],
        features: [],
        populars: [],
        winter: [],
        newItems: [],
    }),
    actions: {
        async index(type = "") {
            const res = await axiosInstance.get('/product?conditions=' + type);
            try {
                if (res.status == 200) {
                    if (type == 'sale') {
                        this.sales = res.data
                    } else if (type == 'feature') {
                        this.features = res.data
                    } else if (type == 'popular') {
                        this.populars = res.data
                    } else if (type == 'new') {
                        this.newItems = res.data
                    } else {
                        this.products = res.data
                    }
                    return new Promise((resolve, reject) => {
                        resolve(res.data);
                    });
                }
            } catch (error) {
                if (error.response.error) {
                    console.log(error.response.error);
                }
            }
        }
    }
})