<template>

    <PageWrapper :rendering="loading">
        <CardWrapper
            :goBack="true"
            title="Create account"
            iconHeader="admin_panel_settings"
            note="*After registration, plese verify your account by the provided link we send you by email. You are able to set your password, after successful verification."
        >
            <!-- Registration -->
            <FormWrapper
                buttonText="Create account"
                buttonIcon="admin_panel_settings"
                :loading="loading"
                @submit="registerUser()"
            >
                <!-- Username -->
                <q-input
                    filled
                    v-model="user.name"
                    label="Username"
                >
                    <template v-slot:prepend>
                        <q-icon name="person" />
                    </template>
                </q-input>

                <!-- Email -->
                <q-input
                    filled
                    type="email"
                    v-model="user.email"
                    label="Email"
                >
                    <template v-slot:prepend>
                        <q-icon name="mail" />
                    </template>
                </q-input>

                <!-- Terms & Conditions -->
                <div class="flex items-center">
                    <q-checkbox v-model="user.agreed" label="I agree with" />&nbsp;
                    <div @click="showTerms = true"><u>terms &amp; conditions</u></div>
                </div>
            </FormWrapper>
        </CardWrapper>

        <!-- Terms & Conditions -->
        <q-dialog v-model="showTerms">
                <TermsConditions class="q-mt-xl" />
        </q-dialog>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import TermsConditions from 'src/pages/guest/compliance/TermsConditions.vue';
import { createAccount } from 'src/apis/auth.js';
import { regRules } from 'src/modules/globals.js';

export default {
    name: 'CreateNewAccount',
    components: {
        PageWrapper, CardWrapper, FormWrapper, 
        TermsConditions
    },
    setup() {
        return {
            regRulesEmail: regRules.email,
            loading: ref(false),
            showTerms: ref(false)
        };
    },
    data() {
        return {
            user: {
                name: '',
                email: '',
                agreed: false,
            },
        };
    },
    methods: {
        async registerUser() {
            try {
                // Validate
                if(!this.user.name) throw 'Please enter a name.';
                if (!this.regRulesEmail.test(this.user.email)) throw 'No valid email.';
                if (!this.user.agreed) throw 'Please agree with our Terms & Conditions.';

                // Create User
                this.loading = true;
                const response = await createAccount(this.user);
                this.$toast.success(response.data.message);
                this.user.agreed = false;

                // Redirect User to Verify Email
                this.$router.push({
                    name: 'EmailVerificationRequest', 
                    params: { 
                        email: this.user.email,
                    }
                });
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
            }
        },
    }
};
</script>
