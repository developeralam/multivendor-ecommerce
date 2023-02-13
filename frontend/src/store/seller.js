import { defineStore } from "pinia";
import axiosInstance from '@/services/axios';

export const useSeller = defineStore('seller', {
    state: () => ({
        sellers: [],
        products: [],
    }),
    actions: {
        async index(page, show) {
            try {
                let res = await axiosInstance.get('/seller?page=' + page + '&limit=' + show);
                if (res.status === 200) {
                    this.sellers = res.data;
                }
            } catch (error) {

            }
        },
        async sellerProductsBySlug(slug, page, show, sort) {
            try {
                let res = await axiosInstance.get('seller/products/' + slug + '?page=' + page + '&show=' + show + '&sort=' + sort);
                this.products = res.data;
            } catch (error) {

            }
        }
    }
})