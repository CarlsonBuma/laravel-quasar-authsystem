<template>

    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Login"
            iconHeader="verified_user"
        >
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
import { userLogin } from 'src/apis/auth.js';

export default {
    name: 'UserLogin',
    components: {
        PageWrapper, CardWrapper, FormWrapper
    },
    emits: [
        'authorize'
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

        // Login User here
        // Auth User in App.vue
        async loginUser() {
            try {
                if(!this.login.password || !this.login.email) throw "Please enter credentials."
                this.loading = true;
                await userLogin(this.login);
                this.$store.setSession();
                this.$emit('authorize');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                // Wrong Credentials
                // Email_Not_Verified
                this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
                this.login.password = '';
            }
        }
    }
};
</script>
