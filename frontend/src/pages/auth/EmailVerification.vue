<template>
    <PageWrapper class="q-mt-lg">
        <CardWrapper
            title="Email verification"
            iconHeader="verified"
            note="*After verify your email, you will be logged into your account."
            goBack
        >
            <FormWrapper
                buttonText="Verify account"
                buttonIcon="verified"
                @submit="makeValidationRequest(password, password_confirm)"
            >
                <!-- Email -->
                <q-input
                    v-model="email"
                    type="email"
                    filled
                    readonly
                >
                    <template #prepend>
                        <q-icon name="email" />
                    </template>
                </q-input>

                <!-- Token -->
                <q-input
                    v-model="key"
                    class="q-mt-none"
                    filled
                    disable
                    readonly
                >
                    <template #prepend>
                        <q-icon name="key" />
                    </template>
                </q-input>

                <!-- Set New Password -->
                <p>Choose your password:</p>
                <div>
                    <q-input
                        filled
                        type="password"
                        v-model="password"
                        label="Enter password"
                    >
                        <!-- Icon -->
                        <template v-slot:prepend>
                            <q-icon name="lock" />
                        </template>
                        <!-- Validation -->
                        <template v-slot:append>
                            <q-icon name="info">
                                <q-tooltip>
                                    <PasswordCheck
                                        :password="password"
                                        :password_confirm="password_confirm"
                                    />
                                </q-tooltip>
                            </q-icon>
                        </template>
                    </q-input>
                    <q-input
                        filled
                        type="password"
                        v-model="password_confirm"
                        label="Confirm password"
                    >
                        <template v-slot:prepend>
                            <q-icon name="lock" />
                        </template>
                    </q-input>
                </div>
            </FormWrapper>
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { emailVerification } from 'src/apis/auth.js';
import { passwordRequirements } from 'src/modules/globals.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import PasswordCheck from 'components/PasswordCheck.vue';

export default {
    name: 'EmailVerification',
    components: {
        PageWrapper, CardWrapper, FormWrapper, PasswordCheck
    },

    emits: [
        'authorize'
    ],

    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key,
            password: '',
            password_confirm: '',
        };
    },

    methods: {
        async makeValidationRequest(pw, pw_confirm) {
            try {
                // Verify Password
                const passwordCheck = passwordRequirements(pw, pw_confirm);
                if(passwordCheck) throw passwordCheck;
                // Request
                this.$toast.load();
                const response = await emailVerification(this.$route.fullPath, pw, pw_confirm);
                this.$toast.success(response.data.message)
                this.password = '';
                this.password_confirm = '';
                // Login
                this.$user.setToken(response.data.token);
                this.$emit('authorize');
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            }
        }
    }
};
</script>
