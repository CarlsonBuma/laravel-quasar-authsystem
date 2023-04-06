<template>

    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Transfer Account"
            iconHeader="verified"
            note="*You are able to change your password now. Afterwards, you are able to login with your new password."
        >
            <p>Transfer from:</p>
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

            <p>To:</p>
            <q-input
                filled
                type="email"
                v-model="transfer"
                readonly
                class="q-mb-md"
            >
                <template #prepend>
                    <q-icon name="email" />
                </template>
            </q-input>

            <!-- Set New Password -->
            <p>Choose your password:</p>
            <SetPassword
            :reset="resetPw"
                @input="(pw, pw_confirm) => {
                    this.password = pw;
                    this.password_confirm = pw_confirm;
                }"
            />

            <div class="flex items-center justify-end">
                <ButtonSubmit 
                    :loading="loading"
                    buttonText="Transfer account"
                    @submit="makeValidationRequest()"
                    class="q-mt-md"
                />
            </div>
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import ButtonSubmit from 'src/components/ButtonSubmit.vue';
import CardWrapper from 'components/CardWrapper.vue';
import SetPassword from 'src/components/SetPassword.vue';
import { updateEmail } from 'src/apis/auth.js';
import { passwordRequirements } from 'src/modules/globals.js';

export default {
    name: 'TransferAccount',
    components: {
        PageWrapper, CardWrapper, ButtonSubmit, SetPassword
    },

    setup() {
        return {
            loading: ref(false),
            resetPw: ref(false)
        };
    },
    
    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key,
            transfer: this.$route.params.transfer,
            password: '',
            password_confirm: '',
        };
    },
    
    methods: {
        async makeValidationRequest() {

            try {
                // Transfer
                // Fullpath includes Token to verify its user
                passwordRequirements(this.password, this.password_confirm);
                this.loading = true;
                const response = await updateEmail(this.$route.fullPath, this.password, this.password_confirm);
                this.$toast.success(response.data.message)
                this.$router.push('/login')
                this.resetPw = true;
            } catch (error) {
                if(error.response) this.$router.push('/')
                this.message = this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
                this.resetPw = false;
            }
        }
    }
};
</script>
