<template>    
    
    <div id="app-wrapper">
        <div id="app-design"></div>
        <q-layout view="hhh LpR fff">
            
            <!-- Header Top -->
            <q-header 
                reveal
                elevated 
                height-hint="98"
                class="text-white"
                :class="{
                    'bg-dark': $q.dark.isActive,
                    'bg-header-bright-mode': !$q.dark.isActive,
                }">
                <FeaturesUser 
                    v-if="$user.access.user"
                    :isAdmin="showAdmin"
                    @logoutUser="logoutUser()"
                    @showAdmin="showAdmin ? goDashboard() : goBackPanel()"
                    @expandDrawer="$drawerLeft.value = !$drawerLeft.value"
                />
                <FeaturesGuest 
                    v-else
                    @authUser="authUser()"
                    @expandDrawer="$drawerLeft.value = !$drawerLeft.value"
                />
            </q-header>

            <!-- Content -->
            <q-page-container 
                id="app-content"
                :class="{
                    'background': !$q.dark.isActive,
                    'background-dark': $q.dark.isActive
                }"
            >
                <router-view 
                    @authorize="() => authUser()"
                    @removeSession="(message) => removeSession()"
                    class="q-pt-lg"
                />
            </q-page-container>

            <!-- Footer -->
            <q-footer
                bordered 
                :class="{
                    'bg-dark': $q.dark.isActive,
                    'bg-grey-1': !$q.dark.isActive,
                    'text-white': $q.dark.isActive,
                    'text-dark': !$q.dark.isActive,
                }">
                <FeaturesFoot />
            </q-footer>
        </q-layout>
    </div>
    
</template>

<script>
import { ref } from 'vue';
import { userAuth, userLogout } from 'src/apis/auth.js';
import FeaturesGuest from 'src/pages/layout/FeaturesGuest.vue';
import FeaturesUser from 'src/pages/layout/FeaturesUser.vue';
import FeaturesFoot from 'src/pages/layout/FeaturesFoot.vue';
import CookieConsentOptions from 'src/modules/cookieConsent';

export default {
    name: 'App',
    components: {
        FeaturesGuest, FeaturesUser, FeaturesFoot
    },

    data() {
        return {
            loading: false,
            activeLink: '/',
        };
    },

    watch: {
        '$route': function(to) {
            this.activeLink = to.path;
        }
    },

    setup() {
        return {
            showDrawerLeft: ref(false),
            expandDrawerLeft: ref(false),
            showAdmin: ref(false),
        };
    },

    /* Setup App */
    mounted() {
        const darkMode = false;         // this.$q.dark.isActive;
        this.$q.dark.set(darkMode);
        this.$cc.run(CookieConsentOptions);
    },

    methods: {

        goBackPanel() {
            this.showAdmin = true;
            this.$router.push('/backpanel');
        },

        goDashboard() {
            this.showAdmin = false;
            this.$router.push('/dashboard');
        },

        async authUser() {
            try {
                this.$toast.load();
                // Check Session Storage
                // Bearer Token - OAuth2
                this.$user.setSession();
                const response = await userAuth();
                this.$user.setUser(response.data);
                this.$toast.success('Session started');
                this.$router.push('/dashboard');
            } catch (error) {
                this.$router.push('/login');
                if(error.response) {
                    this.removeSession();
                    this.$toast.error(error.response)
                }
            } finally {
                this.$toast.done()
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
                this.$toast.done()
            }
        },

        removeSession() {
            this.$user.removeToken();
            this.$user.removeSession(this.$env.SESSION_NAME);
            this.$router.push('/');
        },

        showLogs() {
            console.log('Cookie', this.$cc);
            console.log('Quasar', this.$q);
            console.log('Axios', this.$axios);
            console.log('ENV', this.$env);
            console.log('Store', this.$user);
            console.log('Toast', this.$toast);
            console.log('Toast', this.$meta);
        }
    },
};
</script>
