import { defineStore } from "pinia";
import axiosInstance from "@/services/axios";
export const useCategory = defineStore('category', {
    state: () => ({
        categories: {

        }
    }),
    actions: {
        async getCat() {
            try {
                let res = await axiosInstance.get('/category');
                if (res.status == 200) {
                    this.categories = res.data;
                    return new Promise((resolve) => {
                        resolve(res.data);
                    });
                }
            } catch (error) {
                if (error.response.data) {
                    console.log(error.response.data);
                }
            }
        }
    }
});