<template>

    <PageWrapper class="q-mt-lg">
        <CardWrapper
            title="Login"
            iconHeader="verified_user"
            goBack
        >
            <FormWrapper
                buttonText="Login"
                buttonIcon="verified_user"
                @submit="loginUser(login.email, login.password)"
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
            </FormWrapper>

            <!-- Auth -->
            <q-separator class="q-mb-lg" />
            <div class="row">
                <q-btn @click="$router.push('password-reset-request')" flat class="col-12" label="Reset password" />
                <q-btn @click="$router.push('create-account')" flat class="col-12" label="Create an account" />
                <q-btn @click="$router.push('terms-and-conditions')" flat class="col-12" label="Terms &amp; Conditions" />
            </div>
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { userLogin } from 'src/apis/auth.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';

export default {
    name: 'UserLogin',
    components: {
        PageWrapper, CardWrapper, FormWrapper
    },

    emits: [
        'authorize'
    ],
    
    data() {
        return {
            login: {
                email: '',
                password: '',
            }
        };
    },
    
    methods: {
        async loginUser(email, password) {
            try {
                if(!password || !email) throw "Please enter credentials."
                this.$toast.load();
                const response = await userLogin(this.login);
                // Login
                this.$user.setToken(response.data.token);
                this.$emit('authorize');
            } catch (error) {
                // Wrong Credentials && Email_Not_Verified
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.login.password = '';
            }
        }
    }
};
</script>
