const MainRoutes = {
    path: '/main',
    redirect: '/main',
    component: () => import('@/layouts/full/Layout.vue'),
    children: [
        {
            name: 'Dashboard',
            path: '/',
            component: () => import('@/views/dashboard/index.vue')
        },
        {
            name: 'Category',
            path: '/category',
            component: () => import('@/views/pages/Category.vue'),
            children: [
                {
                    name: 'CategoryList',
                    path: '',
                    component: () => import('@/views/pages/category/List.vue')
                },
                {
                    name: 'CategoryAdd',
                    path: 'add',
                    component: () => import('@/views/pages/category/Add.vue')
                },
                {
                    name: 'CategoryEdit',
                    path: ':id',
                    component: () => import('@/views/pages/category/Edit.vue')
                },
            ]
        },
        {
            name: 'Product',
            path: '/product',
            component: () => import('@/views/pages/Product.vue'),
            children: [
                {
                    name: 'ProductList',
                    path: '',
                    component: () => import('@/views/pages/product/List.vue')
                },
                {
                    name: 'ProductAdd',
                    path: 'add',
                    component: () => import('@/views/pages/product/Add.vue')
                },
                {
                    name: 'ProductEdit',
                    path: ':id',
                    component: () => import('@/views/pages/product/Edit.vue')
                },
            ]
        },
        {
            name: 'Invoice',
            path: '/invoice',
            component: () => import('@/views/pages/Invoice.vue'),
            children: [
                {
                    name: 'InvoiceList',
                    path: '',
                    component: () => import('@/views/pages/product/List.vue')
                },
                {
                    name: 'InvoiceAdd',
                    path: 'add',
                    component: () => import('@/views/pages/product/Add.vue')
                },
                {
                    name: 'InvoiceEdit',
                    path: ':id',
                    component: () => import('@/views/pages/product/Edit.vue')
                },
            ]
        },
    ]
};

export default MainRoutes;
