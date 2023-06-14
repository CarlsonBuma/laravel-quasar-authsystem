import store from "src/stores/userAccess.js";

const routesUser = [
    {
        path: '/dashboard',
        name: 'Dashboard',
        component: () => import('src/pages/user/Dashboard.vue'),
        beforeEnter: (to, from, next) => {
            if (!store().access.user) next({ name: "Welcome" });
            else next();
        },
    },
];

export default routesUser;
