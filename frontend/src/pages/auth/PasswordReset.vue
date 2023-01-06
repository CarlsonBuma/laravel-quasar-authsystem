<style scoped>
.extra-margin {
    padding-bottom: 80px;
}
</style>

<template>

    <PageWrapper>
        <CardWrapper
            :goBack="true"
            :allowHeader="true"
            cardWidth="520px"
            class="q-mb-md"
            title="Set new password"
        >
            <template #header>
                <q-icon
                    name="lock_person"
                    color="blue"
                    class="col q-ma-md" 
                    size="200px" 
                />
            </template>

            <!-- Key -->
            <q-input
                filled
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
            >
                <template #prepend>
                    <q-icon name="key" />
                </template>
            </q-input>
            <q-separator class="q-mt-lg"/>

            <!-- Set password -->
            <FormWrapper
                buttonText="Set password"
                buttonIcon="key"
                :loading="loading"
                :buttonDisabled="bannerType === 'success'"
                @submit="setUserPassword()"
            >
                <!-- Password -->
                <q-input
                    filled
                    type="password"
                    v-model="password.password"
                    label="Enter new password"
                    bottom-slots
                    class="extra-margin"
                >
                    <template v-slot:hint>
                        <div>
                            <p class="flex items-center align-center">
                                <q-icon 
                                    :name="regRulesPassword.min_length.test(password.password) ? 'check_circle_outline' : 'highlight_off'" 
                                    :color="regRulesPassword.min_length.test(password.password) ? 'green' : 'orange'"
                                />&nbsp;At least 7 characters
                            </p>
                            <p class="flex items-center align-center">
                                <q-icon 
                                    :name="regRulesPassword.capital_letter.test(password.password) ? 'check_circle_outline' : 'highlight_off'" 
                                    :color="regRulesPassword.capital_letter.test(password.password) ? 'green' : 'orange'"
                                />&nbsp;1 capital letter
                            </p> 
                            <p class="flex items-center align-center">
                                <q-icon 
                                    :name="regRulesPassword.number.test(password.password) ? 'check_circle_outline' : 'highlight_off'" 
                                    :color="regRulesPassword.number.test(password.password) ? 'green' : 'orange'"
                                />&nbsp;1 number
                            </p>
                        </div>
                        
                    </template>
                </q-input>

                <!-- Password Confirm -->
                <q-space class="xtra-space" />
                <q-input
                    filled
                    type="password"
                    v-model="password.password_confirm"
                    label="Confirm new password"
                    lazy-rules
                    :rules="[ val => val === password.password || 'Password does not match']"
                />
            </FormWrapper>

            <!-- Message -->
            <BannerNote
                :bannerType="bannerType"
                :text="message"
                note="*You are able to change your password now. Afterwards, you are able to login with your new password."
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
import { setNewPassword } from 'src/apis/auth.js';
import { passwordRequirements, regRules } from 'src/modules/globals.js';

export default {
    name: 'PasswordSet',
    components: {
        PageWrapper, CardWrapper, FormWrapper, BannerNote
    },
    setup() {
        return {
            loading: ref(false),
            bannerType: ref(''),        // 'loading', 'success', 'error'
            message: ref(''),
            regRulesPassword: regRules.passwordPattern
        };
    },
    data() {
        return {
            email: this.$route.params.email,
            key: this.$route.params.key,
            password: {
                password: '',
                password_confirm: ''
            },
        };
    },
    methods: {

        async setUserPassword() {
            try {
                this.bannerType = '';
                passwordRequirements(this.password.password);
                this.loading = true;
                const response = await setNewPassword(this.$route.fullPath, this.password);
                this.bannerType = "success"
                this.message = this.$toast.success(response.data.message);
                this.$router.push('/login');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.message = this.$toast.error(errorMessage);
                this.bannerType = "error"
            } finally {
                this.loading = false;
            }
        },
    }
};
</script>
