import { createRouter, createWebHistory } from 'vue-router';
import MainRoutes from './MainRoutes';
import AuthRoutes from './AuthRoutes';

export const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/login',
            component: () => import('@/views/auth/Login.vue')
        },
        {
            path: '/:pathMatch(.*)*',
            component: () => import('@/views/pages/Error404.vue')
        },
        MainRoutes,
        AuthRoutes
    ]
});

