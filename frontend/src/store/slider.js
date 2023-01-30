import { defineStore } from "pinia";
import axiosInstance from "@/services/axios";
export const useSlider = defineStore('slider', {
    state: () => ({
        sliders: {

        }
    }),
    actions: {
        async getSlider() {
            try {
                let res = await axiosInstance.get('/slider');
                if (res.status == 200) {
                    this.sliders = res.data;
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