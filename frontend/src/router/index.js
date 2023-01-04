import Vue from 'vue';
import VueRouter from 'vue-router';
import Cookies from 'js-cookie';
// import Cookies from 'vue-cookies'
import store from '../store';
import Layout from '@/views/layouts/Layout';
// import Home from '../views/Home.vue'
Vue.use(VueRouter);
const routes = [
  {
    path: '/',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/',
        component: () => import('@/views/Home'),
      },
    ],
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('@/views/layouts/Login.vue'),
    hidden: true,
  },
  {
    path: '/users',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Users'),
      },
    ],
  },
  {
    path: '/403',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/layouts/403'),
      },
    ],
  },

  // {
  //   path: '/',
  //   name: 'Home',
  //   component: Home
  // },
  {
    path: '/about',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/About'),
      },
    ],
  },
  {
    path: '/table',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Table'),
      },
    ],
  },
  {
    path: '/excel',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/ExcelUpload'),
      },
    ],
  },


  {
    path: '/employees',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Employees'),
      },
    ],
  },
  {
    path: '/vehicles',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Vehicles'),
      },
    ],
  },
  {
    path: '/dilerusers',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/DilerUsers'),
      },
    ],
  },
  {
    path: '/dilerwins',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/DilerWins'),
      },
    ],
  },
  {
    path: '/statistics',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('../views/Statistics.vue'),
      },
    ],
  },
  {
    path: '/dilers',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Dilers'),
      },
    ],
  },
  {
    path: '/details',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Details'),
      },
    ],
  },
  {
    path: '/warehouses',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/Warehouses'),
      },
    ],
  },
  {
    path: '/userlogs',
    component: Layout,
    children: [
      {
        path: '/',
        component: () => import('@/views/UserLogs'),
      },
    ],
  },
];

const router = new VueRouter({
  mode: 'hash',
  base: process.env.BASE_URL,
  routes,
});

//--------------------------------------------------------------------------------------
router.beforeEach((to, from, next) => {
  var access_token = Cookies.get('access_token');
  if (!access_token) {
    setTimeout(() => {
      access_token = Cookies.get('access_token');
    }, 100);
  }
  if (!access_token && to.fullPath != '/login') {
    store.dispatch('setRedirectUrl', to.fullPath);
    next({
      path: '/login',
    });
  } else next();
});
export default router;
