<template>

    <PageWrapper title="Dashboard" :directory="directory">
        <div>
            <h1 class="flex flex-center">Dashboard</h1>
            <h3 class="flex flex-center">Logged in</h3>
            <p class="flex flex-center">Create something awesome!</p>
        </div>
    </PageWrapper>

</template>

<script>
import PageWrapper from 'components/PageWrapper.vue';

export default {
    name: 'DashboardPage',
    components: {
        PageWrapper
    },
    setup() {
        return {
            directory: [{
                label: 'Home',
                redirect: '/dashboard'
            }],
        };
    },
    methods: {
        // Some methods
    },
};
</script>
