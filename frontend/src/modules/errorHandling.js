'use strict';

import store from "src/stores/storeUser.js";

/** 
 * Customizing Server-Response 
 */
const errorHandling = (serverResponse, router) => {
    
    // Handle Custom Error here
    // Redirect User to Verify Email
    if(serverResponse.status === 401 && serverResponse.data.status === 'email_not_verified') {
        store().logoutUser();
        router.push({
            name: 'EmailVerificationRequest', 
            params: { 
                email: serverResponse.data.email,
            }
        });
        throw serverResponse.data.message;
    }

    else if (serverResponse.status === 401 && serverResponse.data.status === 'no_admin') {
        store().removeAdmin();
        router.push('/dashboard');
        throw serverResponse.data.message;
    }

    // Not authenticated
    else if(serverResponse.status === 401) {
        store().logoutUser();
        router.push('/login');
        throw serverResponse.data.message ? serverResponse.data.message : 'Hmm, some error occured. Please try again.'
    }

    else if(serverResponse.status === 422) {
        // router.push('/');
    }
}

export default errorHandling;