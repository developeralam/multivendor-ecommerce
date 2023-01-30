import { createRouter, createWebHistory } from 'vue-router'
import { useAuth } from '@/store';
import { Index, Shop } from '@/views/pages';
import { SellerList, SellerStore, SellerApply } from '@/views/pages/seller';
import { Order, Profile, Wishlist, Checkout } from '@/views/user';
import { Login, Register } from '@/views/user/auth';
import NProgress from 'nprogress';

const routes = [
    {
        path: '/',
        name: 'index',
        component: Index,
        meta: {
            title: 'Home',
        }
    },
    {
        path: '/shop',
        name: 'pages.shop',
        component: Shop,
        meta: {
            title: 'Shop',
        }
    },
    {
        path: '/seller',
        name: 'pages.seller.list',
        component: SellerList,
        meta: {
            title: 'Seller List',
        }
    },
    {
        path: '/seller/apply',
        name: 'pages.seller.apply',
        component: SellerApply,
        meta: {
            title: 'Seller Apply',
        }
    },
    {
        path: '/seller/store',
        name: 'pages.seller.store',
        component: SellerStore,
        meta: {
            title: 'Seller Store',
        }
    },
    {
        path: '/user/login',
        name: 'user.login',
        component: Login,
        meta: {
            title: 'Login',
            guest: true,
        }
    },
    {
        path: '/user/register',
        name: 'user.register',
        component: Register,
        meta: {
            title: 'Register',
            guest: true,
        }
    },
    {
        path: '/user/profile',
        name: 'user.profile',
        component: Profile,
        meta: {
            title: 'User Profile',
            requiredAuth: true,
        }
    },
    {
        path: '/user/order',
        name: 'user.order',
        component: Order,
        meta: {
            title: 'Order',
            requiredAuth: true,
        }
    },
    {
        path: '/user/wishlist',
        name: 'user.wishlist',
        component: Wishlist,
        meta: {
            title: 'Wishlist',
        }
    },
    {
        path: '/user/checkout',
        name: 'user.checkout',
        component: Checkout,
        meta: {
            title: 'Checkout',
        }
    },
];
const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes
})
const DEFAULT_TITLE = '404';
router.beforeEach((to, from, next) => {
    const userCredentials = useAuth();
    document.title = to.meta.title || DEFAULT_TITLE;
    NProgress.start();
    if (to.meta.requiredAuth && !userCredentials.user.meta) {
        next({ name: 'user.login' });
    } else if (to.meta.guest && userCredentials.user.meta) {
        next({ name: 'user.profile' });
    }
    else {
        next();
    }
    next();
})
router.afterEach(() => {
    NProgress.done();
})
export default router;