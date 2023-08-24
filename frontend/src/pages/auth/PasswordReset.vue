<template>

    <PageWrapper class="q-mt-lg">
        <CardWrapper
            title="Password reset"
            iconHeader="lock_person"
            note="*You are able to change your password now. Afterwards, you are able to login with your new password."
            goBack
        >
            <FormWrapper
                buttonText="Set password"
                buttonIcon="password"
                @submit="setUserPassword(password, password_confirm)"
            >
                <!-- Email -->
                <q-input
                    filled
                    v-model="email"
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
                
                <!-- Set Password -->
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
import { passwordReset } from 'src/apis/auth.js';
import { passwordRequirements } from 'src/modules/globals.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import PasswordCheck from 'components/PasswordCheck.vue';

export default {
    name: 'PasswordSet',
    components: {
        PageWrapper, CardWrapper, FormWrapper, PasswordCheck
    },
    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key,
            password: '',
            password_confirm: ''
        };
    },
    methods: {
        async setUserPassword(password, password_confirm) {
            try {
                // Validate
                const passwordCheck = passwordRequirements(password, password_confirm);
                if(passwordCheck) throw passwordCheck;
                // Request
                this.$toast.load();
                const response = await passwordReset(this.$route.fullPath, password, password_confirm);
                this.$toast.success(response.data.message);
                // Login
                this.$user.setToken(response.data.token);
                this.$emit('authorize');
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.password = '';
                this.password_confirm = '';
            }
        },
    }
};
</script>
