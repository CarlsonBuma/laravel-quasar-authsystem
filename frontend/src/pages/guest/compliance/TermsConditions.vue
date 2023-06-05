<template>
    <PageWrapper>
        <CardWrapper
            :goBack="true"
            title="Terms &amp; Conditions"
            iconHeader="description"
        >
            <!-- Enter content -->
            Im Terms &amp; Conditions
        </CardWrapper>
    </PageWrapper>
</template>

<script>
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';

export default {
    name: 'TermsNConditions',
    components: {
        PageWrapper, CardWrapper
    },
};
</script>