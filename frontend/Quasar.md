# Quasar: Cross-Platform
Website: https://quasar.dev/introduction-to-quasar
> npm install
> quasar dev          // Dev Mode
> quasar build        // Production Mode
> npm run lint
> npm run format

## Quasar Grid
quasar ext add qgrid
    - https://next-quasar-qgrid.netlify.app/
    
## IconGenie
npm install -g @quasar/icongenie
package.json in scripts [npm run icons]:
    - "icons": "icongenie generate -i public/logo/bumaLogo.png --skip-trim --theme-color FFFFFF"

## Android by Capacitor
Android Studio must be installed & all its environment Variables
https://quasar.dev/quasar-cli-vite/developing-capacitor-apps/preparation
    > Set Enviromentsvariables Manually!
    > Install Packages: https://capacitorjs.com/docs/apis/

1. quasar mode add capacitor
2. quasar dev -m capacitor -T [android|ios]
    > Do not update any recommended Update in Android Studio!

## IOs by Capacitor
macOS with Xcode
> Capacitor, see Android
