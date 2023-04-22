<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            title="Impressum"
            iconHeader="home"
        >
        
            <!-- Content -->
            Im Impressum

        </CardWrapper>
    </PageWrapper>

</template>

<script>
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';

export default {
    name: 'WebImpressum',
    components: {
        PageWrapper, CardWrapper
    },
};
</script>