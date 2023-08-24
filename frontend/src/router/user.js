'use strict';
import userStore from "src/stores/user.js";

const routesUser = [
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('src/pages/user/Dashboard.vue'),
        beforeEnter: (to, from, next) => {
            if (!userStore().access.user) next({ name: "Welcome" });
            else next();
        },
    },
];

export default routesUser;
