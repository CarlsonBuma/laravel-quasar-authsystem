<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="400px"
            class="q-mb-md"
            title="Terms &amp; Conditions"
        >
            <!-- User Avatar -->
            <template #head>
                <q-icon
                    name="description"
                    color="blue"
                    class="col q-ma-md" 
                    size="220px" 
                />
            </template>

            <!-- Content -->
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