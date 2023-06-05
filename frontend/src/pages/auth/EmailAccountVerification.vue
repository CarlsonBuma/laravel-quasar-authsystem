<template>
    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Email verification"
            iconHeader="verified"
            note="*After verify your email, you will be login to your account."
        >
            <!-- Roots -->
            <p>Token:</p>
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
                class="q-mb-md"
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

            <!-- Submit -->
            <div class="flex items-center justify-end">
                <ButtonSubmit 
                    :loading="loading"
                    buttonText="Verify account"
                    @submit="makeValidationRequest(password, password_confirm)"
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
import PasswordCheck from 'components/PasswordCheck.vue';
import ButtonSubmit from 'src/components/ButtonSubmit.vue';
import { emailVerification } from 'src/apis/auth.js';
import { passwordRequirements } from 'src/modules/globals.js';

export default {
    name: 'EmailAccountVerification',
    components: {
        PageWrapper, CardWrapper, PasswordCheck, ButtonSubmit
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
            email: this.$route.params.email,
            key: this.$route.params.key,
            password: '',
            password_confirm: '',
        };
    },
    methods: {
        async makeValidationRequest(pw, pw_confirm) {
            try {
                // Verify Account
                const passwordCheck = passwordRequirements(pw, pw_confirm);
                if(passwordCheck) throw passwordCheck;
                this.loading = true;
                const response = await emailVerification(this.$route.fullPath, pw, pw_confirm);
                this.$toast.success(response.data.message)
                // Authorize
                this.$store.setToken(response.data.token);
                this.$emit('authorize');
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
            }
        }
    }
};
</script>
