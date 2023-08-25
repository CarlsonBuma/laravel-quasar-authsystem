<template>

    <PageWrapper title="My Profile" goBack>
        <div class="flex justify-center q-mt-md">
            <CardWrapper
                cardWidth="400px"
                class="q-ma-sm"
                title="Credentials"
                :allowHeader="true"
                :allowActions="true"
            >
                <template #head>
                    <q-icon
                        v-if="! $user.user.avatar"
                        name="account_circle"
                        class="col q-ma-md" 
                        size="220px" 
                    />
                    <q-img
                        v-else
                        :src="$user.user.avatar"
                        alt="userAvatar"
                        class="col q-ma-xs"
                    />
                    <input
                        type="file"
                        name="image"
                        ref="file"
                        accept="image/*"
                        @change="(event) => getImage(event)"
                        hidden
                    />
                </template>

                <!-- Action -->
                <template #actions>
                    <q-btn
                        @click="$refs.file.click()" 
                        flat 
                        round 
                        color="primary"
                        icon="restart_alt" 
                    />
                    <q-btn 
                        @click="removeImage()"
                        flat 
                        round 
                        color="red" 
                        icon="delete" 
                    />
                    <q-btn
                        @click="saveAvatar()" 
                        flat 
                        round 
                        color="secondary" 
                        icon="save" />
                </template>

                <!-- Credentials -->
                <p><b>ID:</b>&nbsp;{{ $user.user.id }}</p>
                <p><b>Username:</b>&nbsp;{{ $user.user.name }}</p>
                <p><b>Email:</b>&nbsp;{{ $user.user.email }}</p>
            </CardWrapper>

            <!-- UserName -->
            <CardWrapper
                cardWidth="400px"
                class="q-ma-sm"
                title="Change Username"
            >
                <!-- Name -->
                <FormWrapper
                    buttonText="Change name"
                    buttonIcon="person"
                    @submit="submitUsername()"
                >
                    <q-input
                        filled
                        v-model="$user.user.name"
                        label="Username"
                    />
                </FormWrapper>
                

                <!-- Password -->
                <div class="flex items-center text-h5 _overflow-hidden">Reset Password</div>
                <q-separator class="q-mt-md q-mb-lg" />
                <FormWrapper
                    buttonText="Change password"
                    buttonIcon="lock"
                    @submit="submitPassword(password.current, password.new, password.confirm)"
                >
                    <q-input
                        filled
                        type="password"
                        v-model="password.current"
                        label="Confirm current password"
                    />
                    <div>
                        <q-input
                            filled
                            type="password"
                            v-model="password.new"
                            label="Enter new password"
                        >
                            <!-- Validation -->
                            <template v-slot:append>
                                <q-icon name="info">
                                    <q-tooltip>
                                        <PasswordCheck
                                            :password="password.new"
                                            :password_confirm="password.confirm"
                                        />
                                    </q-tooltip>
                                </q-icon>
                            </template>
                        </q-input>
                        <q-input
                            filled
                            type="password"
                            v-model="password.confirm"
                            label="Confirm new password"
                        />
                    </div>
                </FormWrapper>
            </CardWrapper>

            <!-- Transfer Account -->
            <CardWrapper
                title="Transfer Account"
                note="*To interrupt your transfer process, please login with your current credentials and follow the procedure."
                iconClass="info"
                iconColor="orange"
                class="q-ma-sm"
                cardWidth="400px"
            >
                <template #tooltip>
                    Transfer your account to another user. 
                    A token will be sent to the provided email.<br>
                    After the verification, the email will be updated and a new password will be set. 
                </template>

                <FormWrapper
                    buttonText="Change owner"
                    buttonIcon="people_alt"
                    @submit="submitEmail()"
                >
                    <q-input
                        filled
                        disable
                        v-model="$user.user.email"
                        label="Current owner"
                    />

                    <q-input
                        filled
                        v-model="transferEmail"
                        label="Transfer account to"
                        placeholder="Enter email"
                    />

                    <q-input
                        filled
                        type="password"
                        v-model="emailPassword"
                        label="Confirm by password"
                    />
                </FormWrapper>
            </CardWrapper>

            <!-- Delete Account -->
            <CardWrapper
                title="Delete Account"
                note="*After deleting, all of your data is removed form our system."
                iconClass="info"
                iconColor="red"
                cardWidth="400px"
                class="q-ma-sm"
            >
                <template #tooltip>
                    After deleting your account, all your data will be lost!
                </template>

                <FormWrapper
                    buttonText="Delete account"
                    buttonIcon="delete"
                    buttonColor="red"
                    @submit="deleteAccount()"
                >
                    <q-input
                        filled
                        type="password"
                        v-model="deletePassword"
                        label="Confirm by password"
                    />
                </FormWrapper>
            </CardWrapper>
        </div>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import { passwordRequirements, regRules } from 'src/modules/globals.js';
import { changeAvatar, changeName, transferAccount, changePassword, deleteUser } from 'src/apis/auth.js';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import FormWrapper from 'components/FormWrapper.vue';
import PasswordCheck from 'components/PasswordCheck.vue';

export default {
    name: 'UserAccountSettings',
    components: {
        PageWrapper, CardWrapper, FormWrapper, PasswordCheck
    },
    
    emits: [
        'removeSession'
    ],

    setup() {
        return {
            errorMessage: '',
            loading: ref(false),
            regRulesEmail: regRules.email,
        };
    },
    data() {
        return {
            imageSize: 2000000,
            // Data
            userAvatar: {
                image: null,
                deleteAvatar: false,
            },
            password: {
                current: '',
                new: '',
                confirm: ''
            },
            emailPassword: '',
            transferEmail: '',
            deletePassword: ''
        };
    },
    methods: {
        /** Credentials */
        async submitUsername() {
            try {
                if(this.$user.user.name.length === 0) throw ('Please enter name.');
                this.$toast.load();
                const response = await changeName(this.$user.user.name);
                this.$toast.success(response.data.message);
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            }
        },
        
        async submitEmail() {
            try {
                if(!this.regRulesEmail.test(this.transferEmail)) throw 'Please enter valid email.';
                if(!this.emailPassword) throw 'Please cofirm by password.';
                this.$toast.load();
                const response = await transferAccount(this.transferEmail, this.emailPassword);
                this.$toast.success(response.data.message);
                this.$emit('removeSession');
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.emailPassword = '';
            }
        },

        async submitPassword(current, newPw, confirmed) {
            try {
                if(!current) throw 'Please enter new password.';
                const passwordCheck = passwordRequirements(newPw, confirmed);
                if(passwordCheck) throw passwordCheck;
                this.$toast.load();
                const response = await changePassword(current, newPw, confirmed)
                this.$toast.success(response.data.message)
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.password.current = '';
                this.password.new = '';
                this.password.confirm = '';
            }
        },
        
        async deleteAccount() {
            try {
                if(!this.deletePassword) throw 'Please enter password.'
                this.$toast.load();
                const response = await deleteUser(this.deletePassword);
                this.$toast.success(response.data.message);
                this.$emit('removeSession');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            }
        },

        /** User Avatar */
        async saveAvatar() {
            if(!this.userAvatar.image && !this.userAvatar.deleteAvatar ) return;
            this.$toast.load();
            try {
                const formData = new FormData;
                formData.append("avatar", this.userAvatar.image);
                formData.append("delete", this.userAvatar.deleteAvatar ? '1' : '0');
                const response = await changeAvatar(formData);
                this.$toast.success(response.data.message);
                this.userAvatar.image = null;
                this.userAvatar.deleteAvatar = false;
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            }
        },

        getImage(event) {
            const imageSize = this.imageSize;
            this.userAvatar.image = event.target.files[0];
            if ( this.userAvatar.image.size > imageSize) {
                this.$toast.error('Ups, the size is bigger than ' + imageSize / 1000000 + ' MB')
            } else {
                let reader = new FileReader();
                reader.readAsDataURL( this.userAvatar.image);
                reader.onload = (e) => {
                    this.$user.user.avatar = e.target.result;
                    this.userAvatar.deleteAvatar = false;
                };
            }
        },

        removeImage() {
            this.userAvatar.deleteAvatar = true;
            this.userAvatar.image = '';
            this.$user.user.avatar = '';
            this.$refs.file.value = '';
        },
    }
};
</script>
