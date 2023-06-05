<template>

    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Transfer Account"
            iconHeader="verified"
            note="*After verify your account, you will be able to login with your new credentials."
        >
            <!-- Roots -->
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

            <!-- Terms & Conditions -->
            <div class="flex items-center q-mt-sm">
                <q-checkbox v-model="agreed" label="I agree with" />&nbsp;
                <div @click="showTerms = true"><u>terms &amp; conditions</u></div>
            </div>
            <q-dialog v-model="showTerms">
                <TermsConditions class="q-mt-xl" />
            </q-dialog>

            <!-- Submit -->
            <div class="flex items-center justify-end">
                <ButtonSubmit 
                    :loading="loading"
                    buttonText="Transfer Account"
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
import TermsConditions from 'src/pages/guest/compliance/TermsConditions.vue';
import { updateEmail } from 'src/apis/auth.js';
import { passwordRequirements} from 'src/modules/globals.js';

export default {
    name: 'TransferAccount',
    components: {
        PageWrapper, CardWrapper, PasswordCheck, ButtonSubmit, TermsConditions
    },
    emits: [
        'authorize'
    ],
    setup() {
        return {
            loading: ref(false),
            showTerms: ref(false)
        };
    },
    
    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key,
            transfer: this.$route.params.transfer,
            password: '',
            password_confirm: '',
            agreed: false
        };
    },
    
    methods: {
        async makeValidationRequest(pw, pw_confirm) {
            try {
                const passwordCheck = passwordRequirements(pw, pw_confirm);
                if(passwordCheck) throw passwordCheck;
                if(!this.agreed) throw 'Please agree to our terms & conditions.'
                // Transfer
                // Fullpath includes Token to verify its user
                this.loading = true;
                const response = await updateEmail(this.$route.fullPath, pw, pw_confirm, this.agreed);
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
