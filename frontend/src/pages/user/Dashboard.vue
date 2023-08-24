<template>

    <PageWrapper title="Dashboard" leftDrawer>
        <template #leftDrawer>
            <NavigationUser />
        </template>

        <!-- Content -->
        <div>
            <h1 class="flex flex-center">Dashboard</h1>
            <h3 class="flex flex-center">Logged in</h3>
            <p class="flex flex-center">Create something awesome!</p>
        </div>
    </PageWrapper>

</template>

<script>
import PageWrapper from 'components/PageWrapper.vue';
import NavigationUser from 'src/pages/layout/NavigationUser.vue';

export default {
    name: 'DashboardPage',
    components: {
        PageWrapper, NavigationUser
    },
    setup() {
        return {
            // Setup
        };
    },
    methods: {
        // Some methods
    },
};
</script>
