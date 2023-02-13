import { createApp } from 'vue'
import router from './router';
import { createPinia } from 'pinia'
import ElementPlus from 'element-plus'

import piniaPluginPersistedstate from 'pinia-plugin-persistedstate'
import './style.css'
import './template.js'
const pinia = createPinia();
pinia.use(piniaPluginPersistedstate);
import App from './App.vue'

const app = createApp(App)
    .use(router)
    .use(pinia)
    .use(ElementPlus)


app.config.globalProperties.$filters = {
    currencySymbol(value) {
        return '৳' + value.toLocaleString();
    },
    imagePath(img) {
        return import.meta.env.VITE_API_URL + '/' + img;
    }
}
app.mount('#app')