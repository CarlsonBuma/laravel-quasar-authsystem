'use strict';
import 'vue-cookieconsent/vendor/cookieconsent.css';

/* *************************************************************
 * GDPR: Cookie Consent
 *  > https://github.com/eyecatchup/vue-cookieconsent
 *  > https://github.com/orestbida/cookieconsent
 *      > Enter Consent-Options
 *          > Enter Analytics Scripts in "onAccept()"
 *      > Init consentOptions in App.js
 *  CHECK: Console > Anwendung > Cookies
************************************************************* */

/** Optionnal cookies will be rendered here! */
const runCookies = () => {
    // (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
    // new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
    // j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
    // 'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    // })(window,document,'script','dataLayer','GTM-ID');
}

const consentOptions = {
    autorun: true,
    current_lang: 'en',
    autoclear_cookies: true,                   // default: false
    page_scripts: true,                        // default: false

    // mode: 'opt-in'                          // default: 'opt-in'; value: 'opt-in' or 'opt-out'
    // delay: 0,                               // default: 0
    // auto_language: null                     // default: null; could also be 'browser' or 'document'
    // autorun: true,                          // default: true
    // force_consent: false,                   // default: false
    // hide_from_bots: false,                  // default: false
    // remove_cookie_tables: false             // default: false
    // cookie_name: 'cc_cookie',               // default: 'cc_cookie'
    // cookie_expiration: 182,                    // default: 182 (days)
    // cookie_necessary_only_expiration: 182   // default: disabled
    // cookie_domain: location.hostname,       // default: current domain
    // cookie_path: '/',                       // default: root
    // cookie_same_site: 'Lax',                // default: 'Lax'
    // use_rfc_cookie: false,                  // default: false
    // revision: 0,                            // default: 0

    // onFirstAction: function(user_preferences, cookie){
    //     console.log('CookieConsens_FirstAction', user_preferences, cookie)
    // },

    // onChange: function (cookie, changed_preferences) {
    //     console.log(cookie, changed_preferences)
    // },

    /** Process consent on accept */
    onAccept: function (cookie) {
        let allowAnalytics = false;
        cookie.level.forEach((level) => {
            if(level === 'analytics') allowAnalytics = true;
        });

        if(!allowAnalytics) return;
        console.log("Consent to analyze has been given!");
        runCookies();
    },

    /** Edit Content here */
    languages: {
        'en': {
            consent_modal: {
                title: 'We use cookies!',
                description: 'Hi there, this website uses essential cookies to ensure its proper operation and tracking cookies to understand how you interact with it. The latter will be set only after consent. <button type="button" data-cc="c-settings" class="cc-link">Let me choose</button>',
                primary_btn: {
                    text: 'Accept all',
                    role: 'accept_all'
                },
                secondary_btn: {
                    text: 'Reject all',
                    role: 'accept_necessary'
                }
            },
            settings_modal: {
                title: 'Cookie preferences',
                save_settings_btn: 'Save settings',
                accept_all_btn: 'Accept all',
                reject_all_btn: 'Reject all',
                close_btn_label: 'Close',
                cookie_table_headers: [
                    {col1: 'Name'},
                    {col2: 'Domain'},
                    {col3: 'Expiration'},
                    {col4: 'Description'},
                ],
                blocks: [
                    {
                        title: 'Cookie usage',
                        description: 'We use cookies to ensure the basic functionalities of the website and to enhance your online experience. You can choose for each category to opt-in/out whenever you want. For more details relative to cookies and other sensitive data, please read the full <a href="#terms-and-conditions" class="cc-link">privacy policy</a>.'
                    },
                    {
                        title: 'Strictly necessary cookies',
                        description: 'These cookies are essential for the proper functioning of my website. Without these cookies, the website would not work properly',
                        toggle: {
                            value: 'necessary',
                            enabled: true,
                            readonly: true          // cookie categories with readonly=true are all treated as "necessary cookies"
                        },
                        cookie_table: [             // list of all expected cookies
                            {
                                col1: 'cc_cookie',
                                col2: process.env.VUE_APP_URL,
                                col3: '160 days',
                                col4: 'Cookie Consent - Defines, if consent to analyze data has been given.',
                            }, {
                                col1: 'Usersession',
                                col2: process.env.SESSION_NAME,
                                col3: '365 days',
                                col4: 'Local JWT Session, to verify your client and allow you to interact with your account.',
                            },
                        ]
                    },
                    {
                        title: 'Performance and Analytics cookies',
                        description: 'These cookies collect information about how you use the website, which pages you visited and which links you clicked on. All of the data is anonymized and cannot be used to identify you.',
                        toggle: {
                            value: 'analytics',     // your cookie category
                            enabled: false,
                            readonly: false
                        },
                        cookie_table: [             // list of all expected cookies
                            {
                                col1: '^_ga',
                                col2: 'google.com',
                                col3: '1 years',
                                col4: 'Google Analytics (GA-4) - session statistics, approx. geolocation, device infos, default events, user properties, client ID, etc. See https://support.google.com/analytics/answer/11593727?hl=en',
                                is_regex: true
                            },
                        ]
                    },
                    {
                        title: 'More information',
                        description: 'For any queries in relation to our policy on cookies and your choices, please <a class="cc-link" href="#contact">contact us</a>.',
                    }
                ]
            }
        }
    }
}

export default consentOptions;
