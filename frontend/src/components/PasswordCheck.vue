<template>
    
    <div>
        
        
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
            
    
    </div>

</template>

<script>
import { regRules } from 'src/modules/globals.js';

export default {
    name: 'PasswordCheck',

    props: {
        password: String,
        password_confirm: Boolean
    },

    setup() {
        return {
            regRulesPassword: regRules.passwordPattern
        };
    },
};
</script>