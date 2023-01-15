<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="520px"
            class="q-mb-md"
            title="Login"
        >
            <template #header>
                <q-icon
                    name="verified_user"
                    color="blue"
                    class="col q-ma-md" 
                    size="200px" 
                />
            </template>

            <!-- Login -->
            <FormWrapper
                buttonText="Login"
                buttonIcon="verified_user"
                :loading="loading"
                @submit="loginUser()"
            >
                <q-input
                    filled
                    type="email"
                    v-model="login.email"
                    label="Enter email"
                />

                <q-input
                    filled
                    type="password"
                    v-model="login.password"
                    label="Enter password"
                />

                <q-checkbox v-model="login.remember" label="Remember me" />
            </FormWrapper>

            <!-- Auth -->
            <q-separator class="q-mb-lg" />
            <div class="row">
                <q-btn @click="$router.push('password-reset-request')" flat class="col-12" label="Reset password" />
                <q-btn @click="$router.push('create-account')" flat class="col-12" label="Create an account" />
                <q-btn @click="$router.push('terms-and-conditions')" flat class="col-12" label="Terms &amp; Conditions" />
            </div>

            <!-- Testing: Verify & Reset Password -->
            <!-- <div class="flex justify-center">
                <q-btn color="primary" class="q-ma-lg" label="Verify" @click="$router.push({
                    name: 'EmailVerificationRequest',
                    params: {
                        email: 'email@email.com',
                        key: '123svdfs'
                    }
                })" />
                <q-btn color="primary" class="q-ma-lg" label="Reset Password" @click="$router.push({
                    name: 'PasswordSet',
                    params: {
                        email: 'email@email.com',
                        key: '123svdfs'
                    }
                })" />
            </div> -->

        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import { setCSRFToken, userLogin } from 'src/apis/auth.js';

export default {
    name: 'UserLogin',
    components: {
        PageWrapper, CardWrapper, FormWrapper
    },
    emits: [
        'login'
    ],
    setup() {
        return {
            loading: ref(false),
        };
    },
    data() {
        return {
            login: {
                email: '',
                password: '',
                remember: false,
            }
        };
    },
    methods: {
        async loginUser() {
            try {
                this.loading = true;

                // CSRF Protection
                await setCSRFToken();

                // Auth User here
                // Set here Local Session Token
                const response = await userLogin(this.login);
                
                // Set Storage
                localStorage.setItem(this.$env.SESSION_NAME, 'true');

                // Success
                this.$toast.success(response.data.message);
                this.$emit('login'); 
                 
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);

                // Not verified
                if(errorMessage.data && errorMessage.data.email) {
                    this.$router.push({
                        name: 'EmailVerificationRequest',
                        params: {
                            email: this.login.email,
                        }
                    })
                }
            } finally {
                this.loading = false;
                this.login.password = '';
            }
        }
    }
};
</script>
