import { route } from 'quasar/wrappers';
import { createRouter, createMemoryHistory, createWebHistory, createWebHashHistory } from 'vue-router';
import routesAuth from './auth';
import routesGuest from './visitor';
import routesUser from './user';
import routesBackpanel from './admin';

export default route(function (/* { store, ssrContext } */) {
    const createHistory = process.env.SERVER
        ? createMemoryHistory
        : (process.env.VUE_ROUTER_MODE === 'history' ? createWebHistory : createWebHashHistory);

    // Default-Routes
    const routes = [
        {
            path: '/:catchAll(.*)*',
            component: () => import('pages/ErrorNotFound.vue')
        }
    ];

    // Routes
    routes.push(...routesGuest)
    routes.push(...routesAuth);
    routes.push(...routesUser);
    routes.push(...routesBackpanel);

    const Router = createRouter({
        scrollBehavior: () => ({ left: 0, top: 0 }),
        routes,
        history: createHistory(process.env.VUE_ROUTER_BASE)
    });

    return Router;
})
