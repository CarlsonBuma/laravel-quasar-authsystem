<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="400px"
            class="q-mb-md"
            title="Sitemap"
        >
            <!-- User Avatar -->
            <template #head>
                <q-icon
                    name="code"
                    color="blue"
                    class="col q-ma-md" 
                    size="220px" 
                />
            </template>

            <!-- Content -->
            Im Sitemap

        </CardWrapper>
    </PageWrapper>

</template>

<script>
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';

export default {
    name: 'WebSitemap',
    components: {
        PageWrapper, CardWrapper
    },
};
</script>