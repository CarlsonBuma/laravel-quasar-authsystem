<template>

    <q-scroll-area class="fit">

        <!-- Normal User -->
        <q-list
            v-if="showAdmin && $store.access.admin"
            padding
        >  
            <!-- User Profile -->
            <q-item 
                @click="$router.push('/my-account')"
                clickable 
                v-ripple 
                class="q-pt-lg q-pb-lg"
                :class="{
                    'bg-grey-9': $q.dark.isActive,
                    'bg-grey-4': !$q.dark.isActive,
                }"
            >
                <q-item-section avatar>
                    <q-avatar 
                        v-if="$store.user.avatar"
                        size="xl" 
                        color="primary" 
                        text-color="white">
                        <img :src="$store.user.avatar">
                    </q-avatar>
                    <q-avatar 
                        v-else
                        size="xl" 
                        color="primary" 
                        text-color="white">U
                    </q-avatar>
                </q-item-section>

                <q-item-section>
                    <p class="m-0"><b>{{ $store.user.name }}</b></p>
                    <p class="m-0">@{{ $store.access.role }}</p>
                </q-item-section>
            </q-item>

            <!-- Superadmin -->
            <!-- Dashboard -->
            <q-item 
                @click="$router.push('/backpanel')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="dashboard" />
                </q-item-section>
                <q-item-section>
                    Backpanel
                </q-item-section>
            </q-item>

            <!-- Account -->
            <q-separator class="q-mt-md q-mb-md" />
            <!-- Logout -->
            <q-item 
                @click="$emit('logout')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="logout" />
                </q-item-section>
                <q-item-section>
                    Logout
                </q-item-section>
            </q-item>

            <!-- Darkmode -->
            <q-item clickable v-ripple @click="darkMode = !darkMode">
                <q-item-section avatar>
                    <q-icon name="dark_mode" />
                </q-item-section>

                <q-item-section>
                    <q-toggle
                        v-model="darkMode"
                        label="Mode"
                    />
                </q-item-section>
            </q-item>

            <!-- Superadmin -->
            <q-item 
                @click="() => {
                    showAdmin = false;
                    $router.push('/dashboard');
                }"
                clickable
            >
                <q-item-section avatar>
                    <q-icon name="manage_accounts" />
                </q-item-section>

                <q-item-section>
                    Go Account
                </q-item-section>
            </q-item>
        </q-list>
        



        <!-- Normal User -->
        <q-list
            v-else
            padding
        >    
            <!-- User Profile -->
            <q-item 
                @click="$router.push('/my-account')"
                clickable 
                v-ripple 
                class="q-pt-lg q-pb-lg"
                :class="{
                    'bg-grey-9': $q.dark.isActive,
                    'bg-grey-4': !$q.dark.isActive,
                }"
            >
                <q-item-section avatar>
                    <q-avatar 
                        v-if="$store.user.avatar"
                        size="xl" 
                        color="primary" 
                        text-color="white">
                        <img :src="$store.user.avatar">
                    </q-avatar>
                    <q-avatar 
                        v-else
                        size="xl" 
                        color="primary" 
                        text-color="white">U
                    </q-avatar>
                </q-item-section>

                <q-item-section>
                    <p class="m-0"><b>{{ $store.user.name }}</b></p>
                    <p class="m-0">@{{ $store.access.role }}</p>
                </q-item-section>
            </q-item>

            <!-- Dashboard -->
            <q-item 
                @click="$router.push('/dashboard')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="dashboard" />
                </q-item-section>
                <q-item-section>
                    Dashboard
                </q-item-section>
            </q-item>

            <!-- User-Modules -->
            <q-item 
                @click="$router.push('/my-gigs')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="construction" />
                </q-item-section>
                <q-item-section>
                    My Gigs
                </q-item-section>
            </q-item>

            <q-separator class="q-mt-md q-mb-md" />
            <!-- Logout -->
            <q-item 
                @click="$emit('logout')"
                clickable 
                v-ripple
            >
                <q-item-section avatar>
                    <q-icon name="logout" />
                </q-item-section>
                <q-item-section>
                    Logout
                </q-item-section>
            </q-item>

            <!-- Darkmode -->
            <q-item clickable v-ripple @click="darkMode = !darkMode">
                <q-item-section avatar>
                    <q-icon name="dark_mode" />
                </q-item-section>

                <q-item-section>
                    <q-toggle
                        v-model="darkMode"
                        label="Mode"
                    />
                </q-item-section>
            </q-item>

            <!-- Superadmin -->
            <q-item 
                v-if="$store.access.admin"
                @click="() => {
                    showAdmin = true;
                    $router.push('/backpanel');
                }"
                clickable
            >
                <q-item-section avatar>
                    <q-icon name="manage_accounts" />
                </q-item-section>

                <q-item-section>
                    Go Backpanel
                </q-item-section>
            </q-item>
        </q-list>
    </q-scroll-area>
    
</template>

<script>
export default {
    name: 'LeftDrawer',

    emits: [
        'logout',
    ],

    data() {
        return {
            darkMode: this.$q.dark.isActive,
            showAdmin: false
        };
    },

    watch: {
        darkMode() {
            this.$q.dark.toggle();
        }
    },
};
</script>
