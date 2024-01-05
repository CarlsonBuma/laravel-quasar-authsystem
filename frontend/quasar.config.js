/* eslint-env node */
const { configure } = require('quasar/wrappers');
const path = require('path');

module.exports = configure(function (/* ctx */) {
    return {
        eslint: {
            // fix: true,
            // include = [],
            // exclude = [],
            // rawOptions = {},
            warnings: true,
            errors: true
        },

        boot: [
            'i18n',
            'defaults',
            'axios',
        ],

        css: [
            'app.scss',
        ],

        extras: [
            // 'ionicons-v4',
            // 'mdi-v5',
            // 'fontawesome-v6',
            // 'eva-icons',
            // 'themify',
            // 'line-awesome',
            // 'roboto-font-latin-ext', // this or either 'roboto-font', NEVER both!
            'roboto-font',
            'material-icons',
        ],

        build: {
            env: require('dotenv').config().parsed,
            target: {
                browser: [ 'es2019', 'edge88', 'firefox78', 'chrome87', 'safari13.1' ],
                node: 'node16'
            },
            vueRouterMode: 'hash',
            vitePlugins: [
                ['@intlify/vite-plugin-vue-i18n', {
                    // if you want to use Vue I18n Legacy API, you need to set `compositionOnly: false`
                    // compositionOnly: false,
                    include: path.resolve(__dirname, './src/i18n/**')
                }]
            ]
        },

        devServer: {
            // https: true,
            open: true
        },

        framework: {
            config: {
                dark: 'auto',
                notify: { /* look at QuasarConfOptions from the API card */ },
                loading: { /* look at QuasarConfOptions from the API card */ }
            },
            // iconSet: 'material-icons', // Quasar icon set
            // lang: 'en-US', // Quasar language pack
            // components: [],
            // directives: [],
            plugins: [
                'Notify',
                'Loading',
                'Dialog',
            ]
        },

        animations: [
            'bounceInLeft',
            'bounceOutRight'
        ],

        /* sourceFiles: {
              rootComponent: 'src/App.vue',
              router: 'src/router/index',
              store: 'src/store/index',
              registerServiceWorker: 'src-pwa/register-service-worker',
              serviceWorker: 'src-pwa/custom-service-worker',
              pwaManifestFile: 'src-pwa/manifest.json',
              electronMain: 'src-electron/electron-main',
              electronPreload: 'src-electron/electron-preload'
        }, */

        ssr: {
            pwa: false,
            prodPort: 3000,
            middlewares: [
                'render' // keep this as last one
            ]
        },

        pwa: {
            workboxMode: 'generateSW', // or 'injectManifest'
            injectPwaMetaTags: true,
            swFilename: 'sw.js',
            manifestFilename: 'manifest.json',
            useCredentialsForManifestTag: false,
        },

        cordova: {
            // noIosLegacyBuildFlag: true, // uncomment only if you know what you are doing
        },

        capacitor: {
            hideSplashscreen: false
        },

        electron: {
            // extendElectronMainConf (esbuildConf)
            // extendElectronPreloadConf (esbuildConf)
            inspectPort: 5858,
            bundler: 'packager', // 'packager' or 'builder'
            packager: {
                // OS X / Mac App Store
                // appBundleId: '',
                // appCategoryType: '',
                // osxSign: '',
                // protocol: 'myapp://path',

                // Windows only
                // win32metadata: { ... }
            },

            builder: {
                appId: 'bumatools'
            }
        },

        bex: {
            contentScripts: [
                'my-content-script'
            ],
        }
    }
});
