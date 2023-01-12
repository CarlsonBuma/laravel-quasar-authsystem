<template>

    <div>
        <q-toolbar class="q-pa-md border-left">
            
            <!-- Left-Drawer -->
            <q-btn 
                v-if="allowLeftDrawer"
                @click="$emit('drawerLeft')" 
                flat 
                round 
                dense 
                icon="menu" 
            />

            <!-- Welcome -->
            <q-toolbar-title class="row items-center">
                <router-link
                    @click="$router.push('/')" 
                    to="/" 
                    class="row items-center default-link"
                    :class="{
                        'text-white': $q.dark.isActive,
                        'text-dark': !$q.dark.isActive,
                    }"
                >
                    <img
                        src="/logo/bumaLogo.png"
                        width="36"
                        height="36"
                        class="q-mr-sm"
                    />
                    
                    <!-- User Credits -->
                    <div>
                        <p class="m-0 text-subtitle2 c-margin-adjust">{{$env.APP_NAME }}</p>
                        <p class="m-0 text-caption">{{$env.APP_SLOGAN }}</p>
                    </div>
                </router-link>
            </q-toolbar-title>

            <!-- Navigation -->
            <!-- BigScreen: Navbar -->
            <q-tabs 
                v-model="selectedTab"
                class="gt-sm"
                inline-label 
            >
                <q-separator v-if="$canLogin" vertical inset />
                <q-tab
                    v-if="$canLogin"
                    @click="$emit('login')"
                    class="text-blue-6"
                    icon="perm_identity"
                    label="Memeber Area"
                    exact
                />
            </q-tabs>

            <!-- Pages: Dropdown -->
            <q-fab
                class="lt-md"
                vertical-actions-align="right"
                v-model="showDropdown"
                label=""
                label-position="bottom"
                glossy
                color="primary"
                icon="list"
                direction="down"
            >
                <q-fab-action 
                    v-if="$canLogin" 
                    @click="$emit('login')"
                    color="primary"  
                    icon="perm_identity" 
                    label="Member Login" />
            </q-fab>
        </q-toolbar>

        <!-- Progressbar -->
        <q-linear-progress id="progressBar" indeterminate hidden />

        <!-- Sub - Navigation -->
        <q-tabs 
            v-if="allowSubNav"
            v-model="selectedSubTab" 
            class="bg-primal-blue text-white"
            :vertical="$q.screen.width < $q.screen.sizes.md"
        >

            <!-- ServicePortfolio -->
            <q-tab v-if="selectedTab === 'serviceportfolio'" @click="goToSub()" name="1" label="Our Solution" />
            <q-tab v-if="selectedTab === 'serviceportfolio'" @click="goToSub()" name="2" label="Beratung" />
            <q-tab v-if="selectedTab === 'serviceportfolio'" @click="goToSub()" name="3" label="Backlogs" />

            <!-- about -->
            <q-tab v-if="selectedTab === 'about'" @click="goToSub()" name="2" label="Unser Service" />
            <q-tab v-if="selectedTab === 'about'" @click="goToSub()" name="1" label="Our Framework" />
            <q-tab v-if="selectedTab === 'about'" @click="goToSub()" name="3" label="Unser Team" />
            <q-tab v-if="selectedTab === 'about'" @click="goToSub()" name="4" label="Service &amp; Conditions" />
        </q-tabs>
    </div>
    
</template>

<script>

import { ref } from 'vue';
export default {
    name: 'NavTop',
    props: {
        allowSubNav: Boolean,
        allowLeftDrawer: Boolean,
    },
    emits: [
        'drawerLeft',
        'login'
    ],
    setup () {
        return {
            selectedTab: ref('/'),
            selectedSubTab: ref('0'),
            showDropdown: ref(false)
        }
    },
    methods: { 
        goTo(page) {
            if (!page) return;
            this.selectedTab = page;
            this.selectedSubTab = '0';
            this.$router.push(page)
        },
        goToSub(page) {
            if (!page) return;
            // Only if small screen, we want to hide subNav after click
            if(this.$q.screen.width < this.$q.screen.sizes.md) {
                this.selectedTab = '/';
            }
            this.$router.push(page);
        },
    }
};
</script>
