import store from "src/stores/storeUser.js";

const routesAuth = [
    
    // Account Management
    {
        path: "/create-account",
        name: "CreateNewAccount",
        component: () => import('src/pages/auth/CreateNewAccount.vue'),
    },

    // Password Reset
    {
        path: "/password-reset-request",
        name: "PasswordResetRequest",
        component: () => import('src/pages/auth/PasswordResetRequest.vue'),
    },
    {
        path: "/password-reset/:email/:key",
        name: "PasswordSet",
        component: () => import('src/pages/auth/PasswordReset.vue'),
    },

    // Email Verification
    {
        path: "/email-verification-request/:email",
        name: "EmailVerificationRequest",
        component: () => import('src/pages/auth/EmailVerificationRequest.vue'),
    },
    {
        path: "/email-verification/:email/:key",
        name: "EmailAccountVerification",
        component: () => import('src/pages/auth/EmailAccountVerification.vue'),
    }, 

    // Transfer Account
    {
        path: "/transfer-account/:email/:key/:transfer",
        name: "TransferAccount",
        component: () => import('src/pages/auth/TransferAccount.vue'),
    },

    // User Session
    {
        path: "/login",
        name: "UserLogin",
        component: () => import('src/pages/auth/UserLogin.vue'),
    },
    {
        path: "/my-account",
        name: "UserProfile",
        component: () => import('src/pages/auth/UserProfile.vue'),
        beforeEnter: (to, from, next) => {
            if (!store().access.user) next('/');
            else next();
        },
    },
];

export default routesAuth;
