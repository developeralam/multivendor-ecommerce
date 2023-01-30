import { defineStore } from 'pinia';
import { ElNotification } from 'element-plus';
export const useNotification = defineStore('notification', {
    state: () => ({
        type: {
            success: 'success',
            error: 'error'
        },
        position: 'top-right',
        duration: 5000,
    }),
    actions: {
        success(msg) {
            ElNotification({
                title: 'Success',
                message: msg,
                type: this.type.success,
                position: this.position,
                duration: this.duration,
            })
        },
        error(msg) {
            ElNotification({
                title: 'Error',
                message: msg,
                type: this.type.error,
                position: this.position,
                duration: this.duration,
            })
        },
    },
});