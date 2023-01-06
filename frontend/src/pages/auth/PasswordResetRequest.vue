<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="520px"
            class="q-mb-md"
            title="Reset password"
        >
            <template #header>
                <q-icon
                    name="lock_clock"
                    color="blue"
                    class="col q-ma-md" 
                    size="200px" 
                />
            </template>

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
                    class="q-ma-sm" 
                    :loading="loading"
                    :disable="bannerType === 'success'"
                    buttonText="Send verification key"
                    @submit="resetPasswordRequest()"
                />
            </div>
            
            <!-- Message -->
            <BannerNote
                :bannerType="bannerType"
                :text="message"
                note="*Please verify your account. You will reveice an email shortly. Please, also check your spam folder"
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
import { requestNewPassword } from 'src/apis/auth.js';

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
        async resetPasswordRequest() {
            try {
                this.bannerType = '';
                this.loading = true;
                const response = await requestNewPassword(this.email);
                this.bannerType = "success"
                this.message = this.$toast.success(response.data.message);
            } catch (error) {
                this.bannerType = "error"
                const errorMessage = error.response ? error.response : error
                this.message = this.$toast.error(errorMessage);
                console.log(error.response)
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
