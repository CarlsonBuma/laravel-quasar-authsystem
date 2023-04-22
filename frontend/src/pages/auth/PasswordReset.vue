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
            <SetPassword
                :reset="resetPw"
                @input="(pw, pw_confirm) => {
                    this.password = pw;
                    this.password_confirm = pw_confirm;
                }"
            />

            <!-- Submit -->
            <div class="flex items-center justify-end">
                <ButtonSubmit 
                    :loading="loading"
                    buttonText="Set password"
                    @submit="setUserPassword(this.password, this.password_confirm)"
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
import SetPassword from 'src/components/SetPassword.vue';
import { passwordReset } from 'src/apis/auth.js';
import { passwordRequirements, regRules } from 'src/modules/globals.js';

export default {
    name: 'PasswordSet',
    components: {
        PageWrapper, CardWrapper, ButtonSubmit, SetPassword
    },
    setup() {
        return {
            loading: ref(false),
            resetPw: ref(false),
            regRulesPassword: regRules.passwordPattern
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
                this.loading = true;
                passwordRequirements(password, password_confirm);
                const response = await passwordReset(this.$route.fullPath, password, password_confirm);
                this.$toast.success(response.data.message);
                this.$router.push('/login');
                this.resetPw = true;
            } catch (error) {
                if(error.response) this.$router.push('/')
                this.message = this.$toast.error(error.response ? error.response : error);
            } finally {
                this.resetPw = false;
                this.loading = false;
            }
        },
    }
};
</script>
