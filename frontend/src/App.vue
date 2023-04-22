<!-- Gigup Design - 06.01.2023, v.0.0.1 -->
<template>    

    <div id="app-wrapper">
        <!-- Design -->
        <div id="app-design"></div>

        <!-- Layout: hHh lpr fff, lHh lpr fff -->
        <q-layout view="lHh Lpr lff">
            
            <!-- Top -->
            <q-header 
                id="app-header"
                elevated
                :class="{
                    'bg-dark': $q.dark.isActive,
                    'bg-white': !$q.dark.isActive,
                    'text-white': $q.dark.isActive,
                    'text-dark': !$q.dark.isActive,
                }">
                <NavTopGuest
                    v-if="!$store.access.user"
                    :allowSubNav="true"
                    :allowLeftDrawer="false"
                    @drawerLeft="expandDrawerLeft = !expandDrawerLeft"
                    @login="authUser()" 
                />
                <NavTopUser
                    v-else-if="$store.access.user"
                    :allowLeftDrawer="true"
                    @showDrawerLeft="showDrawerLeft = true"
                    @expandDrawerLeft="expandDrawerLeft = !expandDrawerLeft" 
                />
            </q-header>

            <!-- Drawers -->
            <q-drawer
                v-if="$store.access.user"
                v-model="showDrawerLeft"
                :mini="expandDrawerLeft"
                show-if-above
                bordered
            >
                <LeftDrawer 
                    @logout="logoutUser()" 
                />
            </q-drawer>

            <!-- Content -->
            <q-page-container 
                :class="{
                    'background': !$q.dark.isActive,
                    'background-dark': $q.dark.isActive
                }"
            >
                <router-view 
                    @authorize="() => authUser()"
                    @removeSession="(message) => removeSession()"
                />
            </q-page-container>

            <!-- Footer -->
            <q-footer
                v-if="!$store.access.user"
                bordered 
                :class="{
                    'bg-dark': $q.dark.isActive,
                    'bg-grey-1': !$q.dark.isActive,
                    'text-white': $q.dark.isActive,
                    'text-dark': !$q.dark.isActive,
                }">
                <NavFoot />
            </q-footer>
        </q-layout>
    </div>
    
</template>

<script>
import { ref } from 'vue';
import NavTopGuest from 'src/layouts/NavTop_Guest.vue';
import NavTopUser from 'src/layouts/NavTop_User.vue';
import NavFoot from 'src/layouts/NavFoot.vue';
import LeftDrawer from 'src/layouts/LeftDrawer.vue';
import { userAuth, userLogout, setCSRFToken } from 'src/apis/auth.js';

export default {
    name: 'App',
    components: {
        NavTopGuest, NavTopUser, NavFoot, LeftDrawer
    },
    setup() {
        return {
            showDrawerLeft: ref(false),
            expandDrawerLeft: ref(false),
        };
    },
    mounted() {
        // CSRF - Token - needed JWT?
        // this.getCSRFToken();

        // Darkmode
        const darkMode = this.$q.dark.isActive;
        this.$q.dark.set(darkMode);

        // Init CookieConsent
        this.$cc.run(this.$cookieConsentOptions);

        // ConsoleLogs
        // this.showLogs();
    },
    methods: { 

        async getCSRFToken() {
            console.log(this.$axios.defaults.headers.common)
            console.log(localStorage)
            await setCSRFToken();
        },

        async authUser() {
            try {
                // Session Storage
                // Bearer Token - OAuth2
                if(!this.$store.setSession()) throw 'No token set.';
                this.$toast.load();
                const response = await userAuth();
                this.$store.setUser(response.data);
                this.$router.push('/dashboard');
                this.$toast.success('Session started');
            } catch (error) {
                if(error.response) this.$toast.error(error.response)
                else this.$router.push('/login');
                console.log(error);
            } finally {
                this.$toast.loaded();
            }
        },

        async logoutUser() {
            try {
                this.$toast.load();
                const response = await userLogout();
                this.$toast.success(response.data.message);
                this.removeSession();
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.$toast.loaded();
            }
        },

        removeSession() {
            this.$store.removeSession(this.$env.SESSION_NAME);
            this.$router.push('/');
        },

        showLogs() {
            console.log('Cookie', this.$cc);
            console.log('Quasar', this.$q);
            console.log('Axios', this.$axios);
            console.log('ENV', this.$env);
            console.log("Store", this.$store);
            console.log('Toast', this.$toast);
        }
    },
};
</script>
