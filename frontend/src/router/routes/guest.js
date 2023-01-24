const routesGuest = [
    {
        path: '/',
        name: 'Welcome',
        component: () => import('src/pages/Welcome.vue'),
    }, {
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

    // Businessbox
    {
        path: "/table",
        name: "TableTemplate",
        component: () => import('src/pages/guest/TableTemplate.vue'),
    }, 
    
    {
        path: "/card",
        name: "CardResponse",
        component: () => import('src/pages/guest/CardResponse.vue'),
    }
    // {
    //     path: "/about-us",
    //     name: "AboutUs",
    //     component: AboutUs,
    // },
    // {
    //     path: "/how-to",
    //     name: "HowTo",
    //     component: HowTo,
    // },
];

export default routesGuest;
