import store from "src/stores/storeUser.js";

const routesUser = [
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('src/pages/user/Dashboard.vue'),
        beforeEnter: (to, from, next) => {
            if (!store().access.logged) next({ name: "Welcome" });
            else next();
        },
    },
];

export default routesUser;
