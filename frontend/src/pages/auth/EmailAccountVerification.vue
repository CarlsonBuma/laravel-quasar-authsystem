<template>

    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Account verification"
            iconHeader="verified"
            note="*After verification, you are able to login into your account."
        >
            <q-input
                filled
                type="email"
                v-model="email"
                readonly
            >
                <template #prepend>
                    <q-icon name="email" />
                </template>
            </q-input>
            <q-input
                filled
                v-model="key"
                disable
                readonly
            >
                <template #prepend>
                    <q-icon name="key" />
                </template>
            </q-input>

            <div class="flex items-center justify-end">
                <ButtonSubmit 
                    buttonText="Verify account"
                    @submit="makeValidationRequest()"
                    class="q-mt-md"
                />
            </div>
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import ButtonSubmit from 'src/components/ButtonSubmit.vue';
import CardWrapper from 'components/CardWrapper.vue';
import { emailVerification } from 'src/apis/auth.js';

export default {
    name: 'EmailAccountVerification',
    components: {
        PageWrapper, CardWrapper, ButtonSubmit
    },
    
    setup() {
        return {
            loading: ref(false),
        };
    },
    
    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key
        };
    },

    methods: {
        async makeValidationRequest() {
            try {
                this.loading = true;
                const response = await emailVerification(this.$route.fullPath);
                this.$toast.success(response.data.message);
                this.$router.push('/login');
            } catch (error) {
                this.message = this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
