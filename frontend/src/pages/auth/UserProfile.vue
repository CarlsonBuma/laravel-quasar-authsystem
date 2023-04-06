<style scoped>
.extra-margin {
    padding-bottom: 80px;
}
</style>

<template>

    <PageWrapper 
        title="My Profile" 
        :directory="directory"
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
                :loading="loading['name']"
                @submit="submitUsername()"
            >
                <q-input
                    filled
                    v-model="$store.user.name"
                    label="Username"
                />
            </FormWrapper>
           
        </CardWrapper>

        <!-- UserEmail -->
        <CardWrapper
            title="Transfer Account"
            iconClass="info"
            iconColor="orange"
            class="q-ma-sm"
            cardWidth="400px"
        >
            <template #tooltip>
                Transfer your account to another user.<br> 
                <em>*To undo your transfer process, login with your old credentials &amp;<br>
                verify your email again.</em>
            </template>

            <FormWrapper
                buttonText="Change owner"
                buttonIcon="email"
                :loading="loading['email']"
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
                    label="Transfer account"
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
                note="The new owner has to verify the new account, by the verification link sent to the provided email. 
                    You will have no access to this account anymore!"
            />
        </CardWrapper>
        

        <!-- UserPassword -->
        <CardWrapper
            title="Change Password"
            cardWidth="400px"
            class="q-ma-sm"
        >
            <FormWrapper
                buttonText="Change password"
                buttonIcon="password"
                :loading="loading['password']"
                @submit="submitPassword()"
            >
                <q-input
                    filled
                    type="password"
                    v-model="password.current"
                    label="Confirm by password"
                />
                <!-- Password -->
                <q-input
                    filled
                    type="password"
                    v-model="password.new"
                    label="Enter new password"
                    bottom-slots
                    class="extra-margin"
                >
                    <template v-slot:hint>
                        <div>
                            <p class="flex items-center align-center">
                                <q-icon 
                                    :name="passwordPattern.min_length.test(password.new) ? 'check_circle_outline' : 'highlight_off'" 
                                    :color="passwordPattern.min_length.test(password.new) ? 'green' : 'orange'"
                                />&nbsp;At least 7 characters
                            </p>
                            <p class="flex items-center align-center">
                                <q-icon 
                                    :name="passwordPattern.capital_letter.test(password.new) ? 'check_circle_outline' : 'highlight_off'" 
                                    :color="passwordPattern.capital_letter.test(password.new) ? 'green' : 'orange'"
                                />&nbsp;1 capital letter
                            </p> 
                            <p class="flex items-center align-center">
                                <q-icon 
                                    :name="passwordPattern.number.test(password.new) ? 'check_circle_outline' : 'highlight_off'" 
                                    :color="passwordPattern.number.test(password.new) ? 'green' : 'orange'"
                                />&nbsp;1 number
                            </p>
                        </div>
                        
                    </template>
                </q-input>
                <q-space class="xtra-space" />
                <q-input
                    filled
                    type="password"
                    v-model="password.confirm"
                    label="Confirm new password"
                />
            </FormWrapper>
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
                :loading="loading['delete']"
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
                note="*After deleting, all of your data is removed form our system.  "
            />
        </CardWrapper>
    </PageWrapper>

</template>

<script>
import { ref } from 'vue';
import PageWrapper from 'components/PageWrapper.vue';
import CardWrapper from 'components/CardWrapper.vue';
import BannerNote from 'src/components/BannerNote.vue';
import FormWrapper from 'components/FormWrapper.vue';
import { passwordRequirements, regRules } from 'src/modules/globals.js';
import { changeAvatar, changeName, transferAccount, changePassword, deleteUser } from 'src/apis/auth.js';

export default {
    name: 'UserAccountSettings',
    components: {
        PageWrapper, CardWrapper, BannerNote, FormWrapper
    },
    
    emits: [
        'removeSession'
    ],

    setup() {
        return {
            errorMessage: '',
            passwordPattern: regRules.passwordPattern,
            regRulesEmail: regRules.email,
            loading: ref({
                'name': false,
                'email': false,
                'password': false,
                'delete': false,
                'avatar': false
            }),
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
                confirm: '',
            },
            transferEmail: '',
            emailPassword: '',
            deletePassword: ''
        };
    },
    methods: {
        /*
         * Credentials
         */
        async submitUsername() {
            console.log('PathAvatar', this.$store.user.avatar)
            try {
                if(this.$store.user.name.length === 0) throw ('Please enter name.');
                this.loading['name'] = this.$toast.load();
                const response = await changeName(this.$store.user.name);
                this.$toast.success(response.data.message);
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading['name'] = false;
            }
        },
        
        async submitEmail() {
            try {
                if(!this.regRulesEmail.test(this.transferEmail)) throw ('Please enter valid email.');
                if(!this.emailPassword) return;
                this.loading['email'] = this.$toast.load();
                const response = await transferAccount(this.transferEmail, this.emailPassword);
                this.$toast.success(response.data.message);
                this.$emit('removeSession');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading['email'] = false;
                this.emailPassword = '';
            }
        },

        async submitPassword() {
            try {
                this.loading['password'] = this.$toast.load();
                passwordRequirements(this.password.new);
                const response = await changePassword(this.password.current, this.password.new, this.password.confirm)
                this.$toast.success(response.data.message)
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.message = this.$toast.error(errorMessage);
            } finally {
                this.loading['password'] = false;
                this.password.current = '';
                this.password.new = '';
                this.password.confirm = '';
            }
        },
        
        async deleteAccount() {
            try {
                this.loading['delete'] = this.$toast.load();
                const response = await deleteUser(this.deletePassword);
                this.$toast.success(response.data.message);
                this.$emit('removeSession');
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading['delete'] = false;
            }
        },

        /*
         * User Avatar
         */
        async saveAvatar() {
            if(this.loading['avatar']) return;
            if(!this.userAvatar.image && !this.userAvatar.deleteAvatar ) return;
            try {
                console.log('Avarar')
                // Upload Image
                const formData = new FormData;
                formData.append("avatar", this.userAvatar.image);
                formData.append("delete", this.userAvatar.deleteAvatar ? '1' : '0');
                this.loading['avatar'] = this.$toast.load();
                const response = await changeAvatar(formData);
                this.$toast.success(response.data.message);
                this.userAvatar.image = null;
                this.userAvatar.deleteAvatar = false;
            } catch (error) {
                const errorMessage = error.response ? error.response : error;
                this.$toast.error(errorMessage);
            } finally {
                this.loading['avatar'] = false;
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
