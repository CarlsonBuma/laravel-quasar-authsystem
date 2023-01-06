<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="520px"
            class="q-mb-md"
            title="Email verification"
        >
            <template #header>
                <q-icon
                    name="verified"
                    color="blue"
                    class="col q-ma-md" 
                    size="200px" 
                />
            </template>
            
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
                    class="q-ma-sm" 
                    :loading="loading"
                    :disable="bannerType === 'success'"
                    buttonText="Send verification key"
                    @submit="sendEmailVerification()"
                />
            </div>
            
            <!-- Message -->
            <BannerNote
                :bannerType="bannerType"
                :text="message"
                note="*You will receive an email with a signed Link. This will redirect you to the verification page."
            />
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import ButtonSubmit from 'src/components/ButtonSubmit.vue';
import BannerNote from 'src/components/BannerNote.vue';
import { emailVerificationRequest } from 'src/apis/auth.js';

export default {
    name: 'EmailVerificationRequest',
    components: {
        PageWrapper, CardWrapper, ButtonSubmit, BannerNote
    },
    setup() {
        return {
            loading: ref(false),
            bannerType: ref(''),        // 'loading', 'success', 'error'
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
                this.bannerType = '';
                this.loading = true;
                const response = await emailVerificationRequest(this.email);
                this.bannerType = "success"
                this.message = this.$toast.success(response.data.message);
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.message = this.$toast.error(errorMessage);
                this.bannerType = "error"
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>