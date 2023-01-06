module.exports = {
    root: true,

    parserOptions: {
        ecmaVersion: '2021',
    },

    env: {
        node: true,
        browser: true,
        'vue/setup-compiler-macros': true
    },
    
    extends: [
        'eslint:recommended',
        'plugin:vue/vue3-essential',
        'prettier'
    ],

    plugins: [
        'vue',
    ],

    globals: {
        ga: 'readonly', // Google Analytics
        cordova: 'readonly',
        __statics: 'readonly',
        __QUASAR_SSR__: 'readonly',
        __QUASAR_SSR_SERVER__: 'readonly',
        __QUASAR_SSR_CLIENT__: 'readonly',
        __QUASAR_SSR_PWA__: 'readonly',
        process: 'readonly',
        Capacitor: 'readonly',
        chrome: 'readonly'
    },

    rules: {
        
        'prefer-promise-reject-errors': 'off',
        'no-debugger': process.env.NODE_ENV === 'production' ? 'error' : 'off'
    }
}
