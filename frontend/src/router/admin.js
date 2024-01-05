'use strict';
import userStore from "src/stores/user.js";

const routesBackpanel = [
    {
        path: '/backpanel',
        name: 'AdminBackpanel',
        component: () => import('src/pages/admin/Backpanel.vue'),
        beforeEnter: (to, from, next) => {
            if (!userStore().access.admin) next({ name: "Welcome" });
            else next();
        },
    }, {
        path: '/releasemanagement',
        name: 'ReleaseManagement',
        component: () => import('src/pages/admin/ReleaseManagement.vue'),
        beforeEnter: (to, from, next) => {
            if (!userStore().access.admin) next('/');
            else next();
        },
    },
];

export default routesBackpanel;
