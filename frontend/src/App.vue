<!-- Gigup Design - 06.01.2023, v.0.0.1 -->
<template>    

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
                v-if="!$store.access.logged"
                :allowSubNav="true"
                :allowLeftDrawer="false"
                @drawerLeft="expandDrawerLeft = !expandDrawerLeft"
                @login="authUser()" 
            />
            <NavTopUser
                v-else-if="$store.access.logged"
                :allowLeftDrawer="true"
                @showDrawerLeft="showDrawerLeft = true"
                @expandDrawerLeft="expandDrawerLeft = !expandDrawerLeft" 
            />
        </q-header>

        <!-- Drawers -->
        <q-drawer
            v-if="$store.access.logged"
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
                @login="() => authUser()"
                @logout="(message) => removeSession(message)"
            />
        </q-page-container>

        <!-- Footer -->
        <q-footer
            v-if="!$store.access.logged"
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
    
</template>

<script>
import { ref } from 'vue';
import NavTopGuest from 'src/layouts/NavTop_Guest.vue';
import NavTopUser from 'src/layouts/NavTop_User.vue';
import NavFoot from 'src/layouts/NavFoot.vue';
import LeftDrawer from 'src/layouts/LeftDrawer.vue';
import { userAuth, userLogout } from 'src/apis/auth.js';

export default {
    name: 'App',
    components: {
        NavTopGuest, NavTopUser, NavFoot, LeftDrawer
    },
    data() {
        return {
            showDrawerLeft: ref(false),
            expandDrawerLeft: ref(false),
        }
    },
    mounted() {
        // Darkmode
        const darkMode = this.$q.dark.isActive;
        this.$q.dark.set(darkMode);

        // Init CookieConsent
        this.$cc.run(this.$cookieConsentOptions);

        // ConsoleLogs
        // this.showLogs();
    },
    methods: { 

        async authUser() {
            try {
                // Check if we can load User-Session
                const sessionSet = localStorage.getItem(this.$env.SESSION_NAME); 
                if(sessionSet !== 'true' || this.$store.access.logged) throw 'Please login manually.';
                
                // Set New Session
                this.$toast.load();
                const response = await userAuth();
                this.$store.loginUser(response.data);
                this.$router.push('/dashboard');
            } catch (error) {
                this.$router.push('/login');
                console.log(error)
            } finally {
                this.$toast.loaded();
            }
        },

        // Logout & Remove Session
        async logoutUser() {
            try {
                this.$toast.load();
                const response = await userLogout();
                this.removeSession(response.data.message);
                this.$router.push('/');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.$toast.loaded();
            }
        },

        // Remove Session
        removeSession(message) {
            localStorage.removeItem(this.$env.SESSION_NAME);
            this.$store.logoutUser();
            this.$toast.success(message);
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
