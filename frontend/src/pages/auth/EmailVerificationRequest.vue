<template>

    <PageWrapper class="q-mt-lg">
        <CardWrapper
            title="Email verification"
            iconHeader="verified"
            note="*We send the verification token to the provided email. After successful verification you are able to login."
            goBack
        >
            <FormWrapper
                buttonText="Send Token"
                buttonIcon="send"
                @submit="sendEmailVerification(email)"
            >
                <q-input
                    filled
                    type="email"
                    v-model="email"
                    label="Enter your email"
                    readonly
                >
                    <template #prepend>
                        <q-icon name="email" />
                    </template>
                </q-input>
            </FormWrapper>
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { emailVerificationRequest } from 'src/apis/auth.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';

export default {
    name: 'EmailVerificationRequest',
    components: {
        PageWrapper, CardWrapper, FormWrapper
    },
    
    data() {
        return {
            email: this.$route.params.email,
        };
    },

    methods: {
        async sendEmailVerification(email) {
            try {
                this.$toast.load();
                const response = await emailVerificationRequest(email);
                this.message = this.$toast.success(response.data.message);
                this.$router.push('/')
            } catch (error) {
                this.message = this.$toast.error(error.response ? error.response : error);
            } finally {
                this.$toast.done();
            }
        }
    }
};
</script>
