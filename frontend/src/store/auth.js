import { defineStore } from 'pinia';
import axiosInstance from '@/services/axios';
import axios from 'axios'
export const useAuth = defineStore('auth', {
    state: () => ({
        user: {},
        logoutLoading: false,
    }),
    persist: {
        storage: sessionStorage,
        paths: ['user'],
    },
    actions: {
        async login(formData) {
            try {
                let res = await axiosInstance.post("/user/login", formData);
                if (res.status === 200) {
                    this.user = res.data;
                    return new Promise((resolve) => {
                        resolve(res.data);
                    });
                }
            } catch (error) {
                return new Promise((reject) => {
                    reject(error.response.data.errors);
                });
            }


        },
        async register(formData) {
            try {
                let res = await axiosInstance.post('user/register', formData);
                if (res.status === 200) {
                    return new Promise((resolve) => {
                        resolve(res.data);
                    });
                }
            } catch (error) {
                return new Promise((resolve) => {
                    resolve(error.response.data.errors);
                });
            }
        },
        async resendOtp(phone) {
            let res = await axiosInstance.post('user/resend-otp', {
                phone: phone,
            });
            if (res.status === 200) {
                return new Promise((resolve) => {
                    resolve(res.data);
                });
            }
        },
        async otpVerify(formData) {
            let res = await axiosInstance.post('user/otp-verify', formData);
            console.log(res);
            try {
                if (res.status === 200) {
                    this.user = res.data;
                    return new Promise((resolve) => {
                        resolve(res.data);
                    });
                }
            } catch (error) {
                return new Promise((resolve) => {
                    resolve(error.response.data.errors);
                });
            }
        },
        async logout() {
            try {
                this.logoutLoading = true;
                const res = await axiosInstance.post('/user/logout');
                if (res.status === 200) {
                    this.user = {};
                    return new Promise((resolve) => {
                        resolve(res.data);
                    });
                }
            } catch (error) {
                return new Promise((reject) => {
                    reject(error.response.data.errors);
                });
            } finally {
                this.logoutLoading = false;
            }
        }
    }
});