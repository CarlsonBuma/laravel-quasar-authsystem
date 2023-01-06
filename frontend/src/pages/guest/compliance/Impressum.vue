<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="400px"
            class="q-mb-md"
            title="Impressum"
        >
            <!-- User Avatar -->
            <template #head>
                <q-icon
                    name="home"
                    color="blue"
                    class="col q-ma-md" 
                    size="220px" 
                />
            </template>

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