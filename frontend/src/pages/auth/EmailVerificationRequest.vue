<template>
    <PageWrapper :rendering="this.loading">
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            title="Email verification"
            iconHeader="verified"
            note="*We send the verification token to the provided email. After successful verification you are able to login."
            class="q-mb-md"
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
            
            <!-- Submit Request -->
            <div class="flex items-center justify-end">
                <ButtonSubmit
                    :loading="loading"
                    buttonText="Send Me Token"
                    @submit="sendEmailVerification()"
                    class="q-mt-md"
                />
            </div>
        </CardWrapper>
    </PageWrapper>
</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import ButtonSubmit from 'src/components/ButtonSubmit.vue';
import { emailVerificationRequest } from 'src/apis/auth.js';

export default {
    name: 'EmailVerificationRequest',
    components: {
        PageWrapper, CardWrapper, ButtonSubmit
    },
    setup() {
        return {
            loading: ref(false),
            message: ref(''),
        };
    },
    data() {
        return {
            email: this.$route.params.email,
        };
    },
    methods: {
        /**
         * Send Email Verification to User
         */
        async sendEmailVerification() {
            try {
                this.loading = true;
                const response = await emailVerificationRequest(this.email);
                this.message = this.$toast.success(response.data.message);
                this.$router.push('/')
            } catch (error) {
                this.message = this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
