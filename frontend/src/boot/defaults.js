'use strict';
import { ref } from 'vue';
import { boot } from 'quasar/wrappers';
import { ResponseHandler } from 'src/modules/responseHandling';
import storeUser from "src/stores/user.js";
import CookieConsent from 'vue-cookieconsent';

export default boot(({ app, router }) => {
    
    /* .env Variables */
    app.config.globalProperties.$env = {
        APP_URL: process.env.APP_URL,
        APP_NAME: process.env.APP_NAME,
        APP_SLOGAN: process.env.APP_SLOGAN,
        APP_API_URL: process.env.APP_API_URL,
        SESSION_NAME: process.env.SESSION_NAME
    };
    
    /* Userstore */
    app.config.globalProperties.$canLogin = true; 
    app.config.globalProperties.$user = storeUser();

    /* Load Toaster */
    app.config.globalProperties.$toast = new ResponseHandler(router);

    /* Left Drawer */
    app.config.globalProperties.$drawerLeft = ref(false);

    /* 
     * Cookie-Consent accessible by this.$cc
     *  > Init Options: this.$cc.run(this.$cookieConsentOptions)
     *  > @App.vue
     */
    app.use(CookieConsent);
});
