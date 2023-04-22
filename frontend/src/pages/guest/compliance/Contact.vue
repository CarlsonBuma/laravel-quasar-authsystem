<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            title="Kontakt"
            iconHeader="support_agent"
        >
            <!-- Content -->
            Im Contact

        </CardWrapper>
    </PageWrapper>

</template>

<script>
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';

export default {
    name: 'WebContact',
    components: {
        PageWrapper, CardWrapper
    },
};
</script>