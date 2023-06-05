<template>
    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Reset password"
            iconHeader="lock_clock"
            note="*You will receive an email with the provided token. Please click the link, we sent to your email."
        >
            <q-input
                filled
                type="email"
                label="Enter your email"
                v-model="email"
            >
                <template #prepend>
                    <q-icon name="email" />
                </template>
            </q-input>
            

            <div class="flex items-center justify-end">
                <ButtonSubmit 
                    :loading="loading"
                    buttonText="Send Token"
                    @submit="resetPasswordRequest()"
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
import { passwordResetRequest } from 'src/apis/auth.js';

export default {
    name: 'EmailVerificationRequest',
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
        };
    },
    methods: {
        /**
         * Send Email Verification to User
         */
        async resetPasswordRequest() {
            try {
                if(!this.email) throw 'Please enter your email.'
                this.loading = true;
                const response = await passwordResetRequest(this.email);
                this.$toast.success(response.data.message);
                this.$router.push('/')
            } catch (error) {
                const errorMessage = error.response ? error.response : error
                this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
