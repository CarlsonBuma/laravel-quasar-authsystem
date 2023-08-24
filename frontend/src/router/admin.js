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
    },
];

export default routesBackpanel;
