import { defineStore } from 'pinia'
export const useAgeStore = defineStore('age', {
    state: () => ({
        alamage: 23,
        srityage: 23,
    }),
    getters: {
        alamagedouble: (state) => state.alamage * 10,
        srityagedouble: (state) => state.srityage * 10,
    },
    actions: {
        alamageincrement() {
            this.alamage++
        }
    }
})