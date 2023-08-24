<template>

    <div>
        <q-toolbar class="q-pa-md">
                    
            <!-- Logo -->
            <q-toolbar-title>
                <q-avatar @click="$emit('expandDrawer')" icon="graphic_eq" font-size="34px" clickable />
                {{ $env.APP_NAME }}
            </q-toolbar-title>

            <!-- User Account -->
            <div class="flex justify-end">
                <q-item clickable v-ripple>
                    <q-item-section>My Account</q-item-section>

                    <!-- Dropdown -->
                    <q-menu>
                        <div class="row no-wrap q-pa-md">

                            <!-- Profile Settings -->
                            <div class="column">
                                <div class="text-h6">Mein Profil</div>
                                <q-list padding >
                                    <q-item 
                                        @click="$router.push('/my-account')"
                                        class="q-pa-md"
                                        clickable 
                                        v-ripple 
                                    >
                                        <div class="flex items-center">
                                            <q-icon name="settings" class="q-mr-sm" />Settings
                                        </div>
                                    </q-item>
                                </q-list>
                                <q-toggle v-model="darkMode" label="Darkmode"/>
                            </div>

                            <!-- Profile Management -->
                            <q-separator vertical inset class="q-mx-lg" />
                            <div class="column items-center">
                                <q-avatar 
                                    v-if="$user.user.avatar"
                                    size="72px"
                                    text-color="white">
                                    <img :src="$user.user.avatar">
                                </q-avatar>
                                <q-avatar 
                                    v-else
                                    size="72px"
                                    color="primary" 
                                    text-color="white">U
                                </q-avatar>
                                <div class="text-overline q-sm-md q-mb-xs">{{ $user.user.name }}</div>
                                <q-btn
                                    @click="$emit('logoutUser')"
                                    color="primary"
                                    label="Logout"
                                    push
                                    size="sm"
                                    v-close-popup
                                />
                                <q-btn
                                    v-if="$user.access.admin"
                                    @click="$emit('showAdmin')"
                                    :label="isAdmin ? 'Dashboard' : 'Backpanel'"
                                    class="q-mt-sm"
                                    color="primary"
                                    push
                                    size="sm"
                                    v-close-popup
                                />
                            </div>
                        </div>
                    </q-menu>
                </q-item>
            </div>
        </q-toolbar>

        <!-- Navigation -->
        <q-tabs align="center">
            <q-route-tab to="/dashboard" label="Dashboard" />
        </q-tabs>
    </div>

</template>

<script>
export default {
    name: 'FeaturesUser',
    props: {
        isAdmin: Boolean
    },
    emits: [
        'expandDrawer',
        'logoutUser',
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
