const routesGuest = [
    {
        path: '/',
        name: 'Welcome',
        component: () => import('src/pages/guest/Welcome.vue'),
    },
    
    // Legal & Compliance
    {
        path: "/contact",
        name: "Contact",
        component: () => import('src/pages/guest/about/Contact.vue'),
    }, {
        path: "/impressum",
        name: "Impressum",
        component: () => import('src/pages/guest/compliance/Impressum.vue'),
    }, {
        path: "/terms-and-conditions",
        name: "TermsConditions",
        component: () => import('src/pages/guest/compliance/TermsConditions.vue'),
    }, {
        path: "/sitemap",
        name: "Sitemap",
        component: () => import('src/pages/guest/compliance/Sitemap.vue'),
    },
];

export default routesGuest;
