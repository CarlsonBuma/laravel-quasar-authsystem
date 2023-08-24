'use strict';

/* ********************************
 * Global settings
 *  > Email, Password Requirements
 *  > Define your own Globals
*********************************** */

const regRules = {
    email: /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/,
    passwordPattern: {
        min_length: /^(.{7,255})$/,         // 7 Characters
        capital_letter: /[A-Z]/,            // Capital Letter
        number: /\d/                        // Number
    },
    sanitizeLink: /^https?:\/\/|www\./
};

const passwordRequirements = (password, password_confirm) => {
    if (!regRules.passwordPattern.min_length.test(password)) return 'Password must contain more than 7 characters.'
    else if (!regRules.passwordPattern.capital_letter.test(password)) return 'Password must contain 1 capital letter.'
    else if (!regRules.passwordPattern.number.test(password)) return 'Password must contain 1 number.';
    else if(!password_confirm || password !== password_confirm) return 'Password does not match.'
    return '';
}

export {
    regRules,
    passwordRequirements,
}
