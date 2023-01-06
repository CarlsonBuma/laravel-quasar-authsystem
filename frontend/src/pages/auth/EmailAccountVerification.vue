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
                    v-if="success"
                    class="q-ma-md" 
                    buttonText="Go to login"
                    buttonIcon="login"
                    @submit="$router.push('/login')"
                />
                <ButtonSubmit 
                    v-else
                    :loading="loading"
                    :disabled="bannerType === 'success'"
                    buttonText="Verify account"
                    @submit="makeValidationRequest()"
                />
            </div>

            <!-- Message -->
            <BannerNote
                :bannerType="bannerType"
                :text="message"
                note="*Please, verify your email here. Aftwards you are able to login."
            />
            
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import ButtonSubmit from 'src/components/ButtonSubmit.vue';
import CardWrapper from 'components/CardWrapper.vue';
import BannerNote from 'src/components/BannerNote.vue';
import { emailVerification } from 'src/apis/auth.js';

export default {
    name: 'EmailAccountVerification',
    components: {
        PageWrapper, CardWrapper, BannerNote, ButtonSubmit
    },
    
    setup() {
        return {
            loading: ref(false),
            success: ref(false),
            bannerType: ref(''),        // 'loading', 'success', 'error'
            message: ref(''),
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
                this.bannerType = '';
                this.loading = true;

                // We want to redirect user
                // from Clientpath to it's Origin Path
                const response = await emailVerification(this.$route.fullPath);
                
                // Success
                this.success = true;
                this.bannerType = 'success';
                this.message = this.$toast.success(response.data.message);
            } catch (error) {
                const message = error.response 
                    ? error.response
                    : error
                this.message = this.$toast.error(message);
                this.bannerType = 'error';
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
