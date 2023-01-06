<style scoped>
.extra-margin {
    padding-bottom: 80px;
}
</style>

<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            cardWidth="520px"
            class="q-mb-md"
            title="Create new account"
        >
            <template #header>
                <q-icon
                    name="admin_panel_settings"
                    color="blue"
                    class="col q-ma-md" 
                    size="200px" 
                />
            </template>

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
                />

                <!-- Email -->
                <q-input
                    filled
                    type="email"
                    v-model="user.email"
                    label="Email"
                />

                <!-- Registering vs. Verification -->
                <div>
                    <q-input
                        filled
                        type="password"
                        v-model="user.password"
                        label="Password"
                        bottom-slots
                        class="extra-margin"
                    >
                        <template v-slot:hint>
                            <div>
                                <p class="flex items-center align-center">
                                    <q-icon 
                                        :name="regRulesPassword.min_length.test(user.password) ? 'check_circle_outline' : 'highlight_off'" 
                                        :color="regRulesPassword.min_length.test(user.password) ? 'green' : 'orange'"
                                    />&nbsp;At least 7 characters
                                </p>
                                <p class="flex items-center align-center">
                                    <q-icon 
                                        :name="regRulesPassword.capital_letter.test(user.password) ? 'check_circle_outline' : 'highlight_off'" 
                                        :color="regRulesPassword.capital_letter.test(user.password) ? 'green' : 'orange'"
                                    />&nbsp;1 capital letter
                                </p> 
                                <p class="flex items-center align-center">
                                    <q-icon 
                                        :name="regRulesPassword.number.test(user.password) ? 'check_circle_outline' : 'highlight_off'" 
                                        :color="regRulesPassword.number.test(user.password) ? 'green' : 'orange'"
                                    />&nbsp;1 number
                                </p>
                            </div>
                            
                        </template>
                    </q-input>

                    <!-- Password Confirm -->
                    <q-space class="xtra-space" />
                    <q-input
                        class="q-mt-md"
                        filled
                        type="password"
                        v-model="user.password_confirm"
                        label="Confirm password"
                        lazy-rules
                        :rules="[ val => val === user.password || 'Password does not match']"
                    />
                    
                    <!-- Terms & Conditions -->
                    <div class="flex items-center">
                        <q-checkbox v-model="user.agreed" label="I agree with" />&nbsp;
                        <router-link to="/terms-and-conditions">terms &amp; conditions</router-link>
                    </div>
                </div>
            </FormWrapper>

            <!-- Message -->
            <BannerNote
                :bannerType="success 
                    ? 'success' 
                    : 'error'
                "
                :text="message"
                note="*After successfull registration, you must verify your email. We send your activation-key to the provided email."
            />

        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import BannerNote from 'src/components/BannerNote.vue';
import { createAccount } from 'src/apis/auth.js';
import { passwordRequirements, regRules } from 'src/modules/globals.js';

export default {
    name: 'CreateNewAccount',
    components: {
        PageWrapper, CardWrapper, FormWrapper, BannerNote
    },
    setup() {
        return {
            loading: ref(false),
            success: ref(false),
            message: ref(''),
            regRulesPassword: regRules.passwordPattern,
            regRulesEmail: regRules.email
        };
    },
    data() {
        return {
            user: {
                name: '',
                email: '',
                password: '',
                password_confirm: '',
                agreed: false,
            },
        };
    },
    methods: {

        /**
         * User Registration
         *  > Create Account
         *      > Show Verify Email
         */
        async registerUser() {

            this.success = false;
            this.message = '';

            try {
                // Check
                if(!this.user.name) throw 'Please enter a name.';
                else if (!this.regRulesEmail.test(this.user.email)) throw 'No valid email.';
                passwordRequirements(this.user.password);
                
                // Create User
                this.loading = true;
                const response = await createAccount(this.user);
                this.message = this.$toast.success(response.data.message);
                this.success = true;

                // Redirect User to Verify Email
                this.$router.push({
                    name: 'EmailVerificationRequest', 
                    params: { 
                        email: response.data.email,
                    }
                });
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.message = this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
                this.user.password = '';
                this.user.password_confirm = '';
                this.user.agreed = false;
            }
        },
    }
};
</script>
