import store from "src/stores/storeUser.js";

const routesBackpanel = [
    {
        path: '/backpanel',
        name: 'AdminBackpanel',
        component: () => import('src/pages/admin/Backpanel.vue'),
        beforeEnter: (to, from, next) => {
            if (!store().access.admin) next({ name: "Welcome" });
            else next();
        },
    },
];

export default routesBackpanel;
