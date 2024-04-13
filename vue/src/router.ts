import { createRouter, createWebHistory } from 'vue-router';
import MainRoutes from '@/router/MainRoutes';
import AuthRoutes from '@/router/AuthRoutes';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/:pathMatch(.*)*',
      component: () => import('@/views/pages/Error404.vue')
    },
    MainRoutes,
    AuthRoutes
  ],
});

export default router;
