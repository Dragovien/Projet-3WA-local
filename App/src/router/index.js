import { createRouter, createWebHistory } from 'vue-router';
import {useSignInStore} from '../stores/account.js';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: () => import("../views/Front-office/HomeView.vue"),
    },

    {
      path: '/rules',
      name: 'rules',
      component: () => import("../views/Front-office/RulesView.vue"),
    },

    {
      path: '/login',
      name: 'login',
      component: () => import("../views/Front-office/LoginView.vue"),
      
    },

    {
      path: '/:login/characterPage',
      name: 'characterPage',
      component: () => import("../views/Front-office/CharacterpageView.vue"),
      beforeEnter: (to, from, next) => {
        const store = useSignInStore();
        const id = store.currentUserId;
        if (store.$state[id].logged === true) {
          next();
        } else {
          alert('Vous devez vous logguez afin de voir cette page !')
          next('/login');
        }
      }
    },

    {
      path: '/:login/admin',
      name: 'admin',
      component: () => import("../views/Back-office/AdminView.vue"),
      beforeEnter: (to, from, next) => {
        const store = useSignInStore();
        const id = store.currentUserId;
        if (store.$state[id].logged === true && store.$state[id].adminPrivileges === 'yes') {
          next();
        } else {
          alert('Vous devez vous logguez avec un compte administrateur afin de voir cette page !')
          next('/login');
        }
      },
    },

    {
      path: '/:login/admin/list',
      name: 'accountsList',
      component: () => import("../views/Back-office/AdminListAccountsView.vue"),
      beforeEnter: (to, from, next) => {
        const store = useSignInStore();
        const id = store.currentUserId;
        if (store.$state[id].logged === true && store.$state[id].adminPrivileges === 'yes') {
          next();
        } else {
          alert('Vous devez vous logguez avec un compte administrateur afin de voir cette page !')
          next('/login');
        }
      },
    },

    {
      path: '/:login/admin/create-account',
      name: 'adminAccountForm',
      component: () => import("../views/Back-office/AdminAccountFormView.vue"),
      beforeEnter: (to, from, next) => {
        const store = useSignInStore();
        const id = store.currentUserId;
        if (store.$state[id].logged === true && store.$state[id].adminPrivileges === 'yes') {
          next();
        } else {
          alert('Vous devez vous logguez avec un compte administrateur afin de voir cette page !')
          next('/login');
        }
      },
    },

    {
      path: '/game-explo',
      name: 'game-explo',
      component: () => import("../layout/GameLayout.vue"),
    },
    
    {
      path: '/game-combat',
      name: 'game-combat',
      component: () => import("../layout/GameLayout.vue"),
    }
  ]
})

export default router
