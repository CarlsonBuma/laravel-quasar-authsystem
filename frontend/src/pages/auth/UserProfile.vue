<template>

    <PageWrapper 
        title="My Profile" 
        :directory="directory"
        :rendering="loading"
    >
        <CardWrapper
            cardWidth="400px"
            class="q-ma-sm"
            title="Credentials"
            :allowHeader="true"
            :allowActions="true"
        >
            <template #head>
                <q-icon
                    v-if="! $store.user.avatar"
                    name="account_circle"
                    class="col q-ma-md" 
                    size="220px" 
                />
                <q-img
                    v-else
                    :src="$store.user.avatar"
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
            <p><b>ID:</b>&nbsp;{{ $store.user.id }}</p>
            <p><b>Username:</b>&nbsp;{{ $store.user.name }}</p>
            <p><b>Email:</b>&nbsp;{{ $store.user.email }}</p>
            <p><b>Role:</b>&nbsp;{{ $store.access.role }}</p>
        </CardWrapper>

        <!-- UserName -->
        <CardWrapper
            cardWidth="400px"
            class="q-ma-sm"
            title="Change Username"
        >
            <FormWrapper
                buttonText="Change name"
                buttonIcon="person"
                @submit="submitUsername()"
            >
                <q-input
                    filled
                    v-model="$store.user.name"
                    label="Username"
                />
            </FormWrapper>
        </CardWrapper>

        <!-- UserPassword -->
        <CardWrapper
            title="Change Password"
            cardWidth="400px"
            class="q-ma-sm"
        >
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
            iconClass="info"
            iconColor="orange"
            class="q-ma-sm"
            cardWidth="400px"
        >
            <template #tooltip>
                Transfer your account to another user. 
                This user, must verify it's email again.<br>
                After successfull verification your email will be updated. 
            </template>

            <FormWrapper
                buttonText="Change owner"
                buttonIcon="people_alt"
                @submit="submitEmail()"
            >
                <q-input
                    filled
                    disable
                    v-model="$store.user.email"
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

            <!-- Message -->
            <BannerNote
                note="*To interrupt your transferring process, please login with your current credentials and follow the procedure."
            />
        </CardWrapper>

        <!-- Delete Account -->
        <CardWrapper
            title="Delete Account"
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

            <!-- Message -->
            <BannerNote
                note="*After deleting, all of your data is removed form our system."
            />
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import BannerNote from 'src/components/BannerNote.vue';
import PasswordCheck from 'components/PasswordCheck.vue';
import FormWrapper from 'components/FormWrapper.vue';
import { passwordRequirements, regRules } from 'src/modules/globals.js';
import { changeAvatar, changeName, transferAccount, changePassword, deleteUser } from 'src/apis/auth.js';

export default {
    name: 'UserAccountSettings',
    components: {
        PageWrapper, CardWrapper, BannerNote, FormWrapper, PasswordCheck
    },
    
    emits: [
        'removeSession'
    ],

    setup() {
        return {
            errorMessage: '',
            loading: ref(false),
            regRulesEmail: regRules.email,
            directory: [{
                label: 'Home',
                redirect: '/dashboard'
            }, {
                label: 'My Profile',
                redirect: '/my-account'
            }],
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
        /*
         * Credentials
         */
        async submitUsername() {
            try {
                if(this.$store.user.name.length === 0) throw ('Please enter name.');
                this.loading = true;
                const response = await changeName(this.$store.user.name);
                this.$toast.success(response.data.message);
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
            }
        },
        
        async submitEmail() {
            try {
                if(!this.regRulesEmail.test(this.transferEmail)) throw 'Please enter valid email.';
                if(!this.emailPassword) throw 'Please cofirm by password.';
                this.loading = true;
                const response = await transferAccount(this.transferEmail, this.emailPassword);
                this.$toast.success(response.data.message);
                this.$emit('removeSession');
            } catch (error) {
                this.$toast.error(error.response ? error.response : error);
            } finally {
                this.loading = false;
                this.emailPassword = '';
            }
        },

        async submitPassword(current, newPw, confirmed) {
            try {
                if(!current) throw 'Please enter new password.';
                const passwordCheck = passwordRequirements(newPw, confirmed);
                if(passwordCheck) throw passwordCheck;
                this.loading = true;
                const response = await changePassword(current, newPw, confirmed)
                this.$toast.success(response.data.message)
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
                this.password.current = '';
                this.password.new = '';
                this.password.confirm = '';
            }
        },
        
        async deleteAccount() {
            try {
                if(!this.deletePassword) throw 'Please enter password.'
                this.loading = true;
                const response = await deleteUser(this.deletePassword);
                this.$toast.success(response.data.message);
                this.$emit('removeSession');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
            }
        },

        /*
         * User Avatar
         */
        async saveAvatar() {
            if(this.loading) return;
            if(!this.userAvatar.image && !this.userAvatar.deleteAvatar ) return;
            try {
                // Upload Image
                const formData = new FormData;
                formData.append("avatar", this.userAvatar.image);
                formData.append("delete", this.userAvatar.deleteAvatar ? '1' : '0');
                this.loading = true;
                const response = await changeAvatar(formData);
                this.$toast.success(response.data.message);
                this.userAvatar.image = null;
                this.userAvatar.deleteAvatar = false;
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading = false;
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
                    this.$store.user.avatar = e.target.result;
                    this.userAvatar.deleteAvatar = false;
                };
            }
        },

        removeImage() {
            this.userAvatar.deleteAvatar = true;
            this.userAvatar.image = '';
            this.$store.user.avatar = '';
            this.$refs.file.value = '';
        },
    }
};
</script>
