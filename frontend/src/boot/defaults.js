'use strict';

import { boot } from 'quasar/wrappers';
import userAccess from "src/stores/userAccess.js";
import CookieConsent from 'vue-cookieconsent';
import { ResponseHandler } from 'src/modules/responseHandling';

export default boot(({ app, router }) => {
    /* .env Variables */
    app.config.globalProperties.$env = {
        APP_NAME: process.env.APP_NAME,
        APP_SLOGAN: process.env.APP_SLOGAN,
        APP_API_URL: process.env.APP_API_URL,
        SESSION_NAME: process.env.SESSION_NAME
    };
    
    /* Userstore */
    app.config.globalProperties.$canLogin = true; 
    app.config.globalProperties.$store = userAccess();

    /* Load Toaster */
    app.config.globalProperties.$toast = new ResponseHandler(router);

    /* 
     * Cookie-Consent accessible by this.$cc
     *  > Init Options: this.$cc.run(this.$cookieConsentOptions)
     *  > @App.vue
     */
    app.use(CookieConsent);
});
