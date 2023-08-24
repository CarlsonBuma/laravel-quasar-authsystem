<template>

    <div>
        <q-toolbar class="q-pa-md">      
            <!-- Logo -->
            <q-toolbar-title>
                <q-avatar @click="$emit('expandDrawer')" icon="graphic_eq" font-size="34px" clickable />
                {{ $env.APP_NAME }}
            </q-toolbar-title>

            <!-- User Profile -->
            <div class="flex justify-end">
                <q-btn
                    @click="$emit('authUser')" 
                    flat 
                    icon="person" 
                    label="Member Area"
                />
            </div>
        </q-toolbar>

        <!-- Navigation -->
        <q-tabs align="center">
            <q-route-tab to="/" label="Welcome" :class="activeLink === '/' ? 'q-tab--active' : ''" :default="true" />
        </q-tabs>
    </div>

</template>

<script>

export default {
    name: 'FeaturesGuests',
    emits: [
        'expandDrawer',
        'authUser',
    ],

    data() {
        return {
            activeLink: '/',
        };
    },

    watch: {
        '$route': function(to) {
            this.activeLink = to.path;
        }
    },
};
</script>
