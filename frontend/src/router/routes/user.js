import store from "src/stores/storeUser.js";

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
    {
        path: '/my-gigs',
        name: 'GigsManagement',
        component: () => import('src/pages/user/GigsManagement.vue'),
        beforeEnter: (to, from, next) => {
            if (!store().access.user) next({ name: "Welcome" });
            else next();
        },
    },
    {
        path: '/add-new-gig',
        name: 'AddNewGig',
        component: () => import('src/pages/user/gig-management/AddNewGig.vue'),
        beforeEnter: (to, from, next) => {
            if (!store().access.user) next({ name: "Welcome" });
            else next();
        },
    },
];

export default routesUser;
