<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            title="Sitemap"
            iconHeader="code"
            cardWidth="500px"
        >

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