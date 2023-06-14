<template>

    <q-scroll-area class="fit">
        <q-list padding >    
            
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
                    <p class="m-0">@owner</p>
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

            <!-- Darkmode -->
            <q-separator class="q-mt-md q-mb-md" />
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

            <!-- Superadmin -->
            <q-item 
                v-if="$store.access.admin"
                @click="() => {
                    $router.push('/backpanel');
                    $emit('showAdmin')
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
        'showAdmin'
    ],

    data() {
        return {
            darkMode: this.$q.dark.isActive,
        };
    },

    watch: {
        darkMode() {
            this.$q.dark.toggle();
        }
    },
};
</script>
