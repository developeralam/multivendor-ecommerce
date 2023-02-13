import { defineStore } from "pinia";
import axiosInstance from '@/services/axios';

export const useShop = defineStore('shop', {
    state: () => ({
        products: [],
        sidebar: [],
    }),
    actions: {
        async index(page, show, sort, brand, category, price_range) {
            try {
                let res = await axiosInstance.get('/shops', {
                    params: {
                        page,
                        show,
                        sort,
                        brand,
                        category,
                        price_range
                    }
                });

                if (res.status == 200) {
                    this.products = res.data;
                }
            } catch (error) {
                console.log(error);
            }
        },
        async sidebarData() {
            try {
                let res = await axiosInstance.get('/sidebar');

                if (res.status == 200) {
                    this.sidebar = res.data;
                }
            } catch (error) {
                console.log(error);
            }
        }
    }
});