<template>
    
    <div>
        <q-input
            filled
            type="password"
            v-model="password"
            label="Enter password"
        >
            <!-- Icon -->
            <template v-slot:prepend>
                <q-icon :name="iconName ? iconName : 'lock'" />
            </template>

            <!-- Validation -->
            <template v-slot:append>
                <q-icon :name="
                        regRulesPassword.min_length.test(password)
                        && regRulesPassword.capital_letter.test(password)
                        && regRulesPassword.number.test(password)
                        && password && password === password_confirm
                        ? 'lock'
                        : 'lock_open'"
                >
                    <q-tooltip>
                        <p class="flex items-center align-center">
                            <q-icon 
                                :name="regRulesPassword.min_length.test(password) ? 'check_circle_outline' : 'highlight_off'" 
                                :color="regRulesPassword.min_length.test(password) ? 'green' : 'orange'"
                            />&nbsp;At least 7 characters
                        </p>
                        <p class="flex items-center align-center">
                            <q-icon 
                                :name="regRulesPassword.capital_letter.test(password) ? 'check_circle_outline' : 'highlight_off'" 
                                :color="regRulesPassword.capital_letter.test(password) ? 'green' : 'orange'"
                            />&nbsp;1 capital letter
                        </p> 
                        <p class="flex items-center align-center">
                            <q-icon 
                                :name="regRulesPassword.number.test(password) ? 'check_circle_outline' : 'highlight_off'" 
                                :color="regRulesPassword.number.test(password) ? 'green' : 'orange'"
                            />&nbsp;1 number
                        </p>
                        <p class="flex items-center align-center">
                            <q-icon 
                                :name="password && password === password_confirm ? 'check_circle_outline' : 'highlight_off'" 
                                :color="password && password === password_confirm ? 'green' : 'orange'"
                            />&nbsp;Confirmed
                        </p>
                    </q-tooltip>
                </q-icon>
            </template>
        </q-input>
    
        <!-- Password_confirm -->
        <q-input
            filled
            type="password"
            v-model="password_confirm"
            label="Confirm password"
        >
            <template v-slot:prepend>
                <q-icon :name="iconName ? iconName : 'lock'" />
            </template>
        </q-input>
    </div>

</template>

<script>
import { regRules } from 'src/modules/globals.js';

export default {
    name: 'SetPassword',
    emits: [
        'input'
    ],
    props: {
        iconName: String,
        reset: Boolean
    },
    setup() {
        return {
            regRulesPassword: regRules.passwordPattern
        };
    },
    data() {
        return {
            password: '',
            password_confirm: ''
        }
    },
    watch: {
        reset(value) {
            if(!value) return;
            this.resetPassword();
        },
        password() {
            this.emitValues();
        },
        password_confirm() {
            this.emitValues();
        }
    },

    methods: {
        emitValues() {
            this.$emit('input', this.password, this.password_confirm)
        },
        resetPassword() {
            this.password = '';
            this.password_confirm = '';
        }
    }
};
</script>