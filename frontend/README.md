# Setup
## Initialization
 - npm install
 - Optional: Setup \src\modules\cookieConsent.js
 - Edit .env file
 - Setup package.json

## Architecture
- quasar (framework)
- vue-router (spa-approach)
- apis (axios-request)
- store (pinia)
- modules (static classes)
   - globals.js
   - responseHandling.js (this.$toast. | load() | success(Str) | error( Obj., Str))

## Structure
 - src/App.vue, application initialization
 - src/apis
      - auth.js, for authinterface
      - user.js, for userinterface
      - visitor.js, for publicinterface
      - admin.js, for admininterface
 - src/router
      - index.js, setup routes
      - auth.js, for authinterface
      - user.js, for userinterface
      - visitor.js, for publicinterface
      - admin.js, for admininterface
 - src/store
      - index.js, initialization of Pinia
      - userAccess.js, manage userinterface
 - src/modules
      - globals.js
      - cookieConsent.js
      - responseHandling.js
         - errorHandling.js
 - src/boot
      - default.js, setup projectattributes
      - axios.js, setup requesthandling

## Third-Parties Implementations
[X] Cookie-Consent (GDPR, eg. for Google Analytics)
    - https://github.com/eyecatchup/vue-cookieconsent
    - Implemented: "App.js" & "quasar.config.js" (as boot-file)
    - Cookies: Console - Anwendung - Cookies
        - cc_consent (by Cookie-Consent)
        - Google Analytics / Tag Manager included
            - Setup Tag Manager Account (Google Tag Manager)
            - Import Script to Bootfiles "cookie-consens.js"
            - Define in Cookie-Consent

# Deployment
See Vue 3