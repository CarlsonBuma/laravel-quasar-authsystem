/*
 * Global settings
 *  > Password Requirements
*/

// Password reset
const regRules = {
    email: /^(?=[a-zA-Z0-9@._%+-]{6,254}$)[a-zA-Z0-9._%+-]{1,64}@(?:[a-zA-Z0-9-]{1,63}\.){1,8}[a-zA-Z]{2,63}$/,
    passwordPattern: {
        min_length: /^(.{7,255})$/,         // 7 Characters
        capital_letter: /[A-Z]/,            // Capital Letter
        number: /\d/                        // Number
    }
};

const passwordRequirements = (password) => {
    if (!regRules.passwordPattern.min_length.test(password)) throw 'Password must contain more than 7 characters.'
    else if (!regRules.passwordPattern.capital_letter.test(password)) throw 'Password must contain 1 capital letter.'
    else if (!regRules.passwordPattern.number.test(password)) throw 'Password must contain 1 number.';
}

export {
    regRules,
    passwordRequirements
}