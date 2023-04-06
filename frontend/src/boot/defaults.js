import { boot } from 'quasar/wrappers';
import userStore from "src/stores/storeUser.js";
import CookieConsent from 'vue-cookieconsent';
import CookieConsentOptions from 'src/modules/cookieConsent';
import responseHandling from 'src/modules/responseHandling';

export default boot(({ app, router }) => {
    
    // .ENV Variables
    app.config.globalProperties.$env = {
        APP_NAME: process.env.APP_NAME,
        APP_SLOGAN: process.env.APP_SLOGAN,
        APP_API_URL: process.env.APP_API_URL,
        SESSION_NAME: process.env.SESSION_NAME
    };
    
    // USER
    app.config.globalProperties.$canLogin = true; 
    app.config.globalProperties.$store = userStore();

    // Load Toaster
    app.config.globalProperties.$toast = responseHandling(router);

    /* 
     * Cookie-Consent accessible by this.$cc
     *  > Init Options: this.$cc.run(this.$cookieConsentOptions)
     *  > @App.vue
     */
    app.config.globalProperties.$cookieConsentOptions = CookieConsentOptions;
    app.use(CookieConsent);

    
});
