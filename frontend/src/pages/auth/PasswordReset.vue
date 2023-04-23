<template>

    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Set new password"
            iconHeader="lock_person"
            note="*You are able to change your password now. Afterwards, you are able to login with your new password."
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
                filled
                v-model="key"
                disable
                readonly
            >
                <template #prepend>
                    <q-icon name="key" />
                </template>
            </q-input>
            
            <!-- Set Password -->
            <q-separator class="q-mt-lg"/>
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
                    buttonText="Set password"
                    @submit="setUserPassword(password, password_confirm)"
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
import PasswordCheck from 'components/PasswordCheck.vue';
import { passwordReset } from 'src/apis/auth.js';
import { passwordRequirements } from 'src/modules/globals.js';

export default {
    name: 'PasswordSet',
    components: {
        PageWrapper, CardWrapper, ButtonSubmit, PasswordCheck
    },
    setup() {
        return {
            loading: ref(false),
            resetPw: ref(false),
        };
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
                const passwordCheck = passwordRequirements(password, password_confirm);
                if(passwordCheck) throw passwordCheck;
                this.loading = true;
                const response = await passwordReset(this.$route.fullPath, password, password_confirm);
                this.$toast.success(response.data.message);
                this.$router.push('/login');
            } catch (error) {
                if(error.response) this.$router.push('/')
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
            }
        },
    }
};
</script>
