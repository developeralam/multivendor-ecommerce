import { defineStore } from "pinia";
import axiosInstance from "@/services/axios";
import { useAuth } from '@/store';
export const useWishlist = defineStore('wishlist', {
    state: () => ({
        wishlists: [],
        loading: false,
    }),
    actions: {
        async index() {
            try {
                const res = await axiosInstance.get('/user/wishlist');
                if (res.status == 200) {
                    const auth = useAuth();
                    auth.user.meta.wishlists = res.data.data;
                }
            } catch (error) {
                if (error.response.data) {
                    console.log(error.response.data);
                }
            }
        },
        async addToWishList(product) {
            try {
                this.loading = product.id;
                const res = await axiosInstance.post('/user/wishlist', {
                    product_id: product.id,
                });
                return new Promise((resolve) => {
                    resolve(res);
                });
            } catch (error) {
                if (error.response.data) {
                    console.log(error.response.data);
                }
            } finally {
                this.loading = false;
            }


        }
    }
});