<template>

    <div class="fit row wrap justify-center items-center content-center">
        <div class="col-12 col-md-3 q-pa-lg text-center">
            <h6>About</h6>
            <q-tabs label="About" vertical inline-label align="left">
                <q-route-tab to="/page1" label="Page One" />
                <q-route-tab to="/page2" label="Page Two" />
                <q-route-tab to="/contact" label="Kontakt" />
            </q-tabs>
        </div>
        <div class="col-12 col-md-3 q-pa-lg text-center">
            <h6>Services</h6>
            <q-tabs label="About" vertical inline-label align="left">
                <q-route-tab to="/page1" label="Page One" />
                <q-route-tab to="/page2" label="Page Two" />
                <q-route-tab to="/page3" label="Page Three" />
            </q-tabs>
        </div>
        <div class="col-12 col-md-3 q-pa-lg text-center">
            <h6>Compliance</h6>
            <q-tabs label="About" vertical inline-label align="left">
                <q-route-tab to="/impressum" label="Impressum" />
                <q-route-tab to="/terms-and-conditions" label="Rechtliches" />
                <q-route-tab to="/sitemap" label="Sitemap" />
            </q-tabs>
        </div>
        <div class="col-12 col-md-3 q-pa-lg text-center">
            <div class="q-pa-md">
                <q-btn 
                    @click="forwardTo('https://www.linkedin.com/company/85970708/')"
                    round 
                    color="black" 
                    icon="thumb_up_alt" 
                    class="q-mr-xs"/>
                <q-btn 
                    @click="forwardTo('https://www.youtube.com/')"
                    round 
                    color="black" 
                    icon="play_circle_filled" 
                    class="q-mr-xs"/>
                <q-btn 
                    @click="forwardTo('mailto:support@bumatools.ch')"
                    round 
                    color="black" 
                    icon="email" 
                    class="q-mr-xs"/>
            </div>
            <p>© {{ $env.APP_NAME }}, 2022</p>
                
            <!-- Darkmode -->
            <q-item 
                class="flex align-center content-center items-center justify-center" 
                @click="darkMode = !darkMode"
            >
                <q-icon 
                    name="dark_mode" 
                    size="22px" 
                />
                <q-toggle
                    v-model="darkMode"
                    label="Dark"
                />
            </q-item>
        </div>
    </div>
    
</template>

<script>
import { openURL } from 'quasar';

export default {
    name: 'NavigationFoot',
    setup () {
        const forwardTo = (link) => {
            openURL(link);
        };
        return {
            forwardTo
        }
    },
    data() {
        return {
            darkMode: this.$q.dark.isActive
        };
    },
    watch: {
        darkMode() {
            this.$q.dark.toggle();
        }
    },
};
</script>