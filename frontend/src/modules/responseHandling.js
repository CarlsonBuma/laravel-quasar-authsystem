'use strict';

import { Notify } from 'quasar';
import store from "src/stores/storeUser.js";

/* ***********************************************
 * Request Handling
 *  > Constructor
 *      > Default Attributes
 *      > Custom ErrorHandling
 *  > Loading, waiting for response
 *  > Success, response is successful
 *  > Error Handling, there was an error
 ************************************************ */

export class ResponseHandler {

    /**
     * Default Setup
     * @param {Object} router 
     */
    constructor(router) {
        this.message = '';
        this.router = router;
        this.progressBar = null;
        this.notify = null;
        this.position = 'top-right';
        this.duration = 3400;
        this.class = "toaster-container"
        this.defaultLoadMessage = "Processing..."
        this.defaultSuccessMessage = "Your settings have been saved.";
        this.defaultErrorMessage = "Ops, some error occured.";

        /**
         * Error Server Responses are managed here
         * @param {Object} serverResponse 
         * @param {Object} router 
         */
        this.errorHandling = (serverResponse, router) => {
            // Email not verified
            if(serverResponse.status === 401 && serverResponse.data.status === 'email_not_verified') {
                store().removeToken;
                store().removeSession();
                router.push({
                    name: 'EmailVerificationRequest', 
                    params: { 
                        email: serverResponse.data.email,
                    }
                });
                throw serverResponse.data.message;
            }
    
            // No Admin
            else if (serverResponse.status === 401 && serverResponse.data.status === 'no_admin') {
                store().removeAdmin();
                router.push('/dashboard');
                throw serverResponse.data.message;
            }
    
            // Not authenticated
            else if(serverResponse.status === 401) {
                store().removeSession();
                router.push('/login');
                throw serverResponse.data.message ? serverResponse.data.message : 'Hmm, some error occured. Please try again.'
            }
    
            else if(serverResponse.status === 422) {
                // router.push('/');
            }
        }
    }

    load() {
        this.progressBar = document.querySelector('#progressBar');
        this.progressBar.hidden = false;
        return true;
    }

    loaded() {
        if(this.progressBar) this.progressBar.hidden = true;
        return false;
    }

    success(successMessage = this.defaultSuccessMessage) {
        if(this.notify) this.notify();
        if(this.progressBar) this.progressBar.hidden = true;
        this.notify = Notify.create({
            position: this.position,
            type: 'positive',
            message: successMessage,
            timeout: this.duration,
            classes: this.class
        });
        
        return successMessage;
    }

    /**
     * Show Error by Notification
     * String (as Customerror) vs Object (as Serverresponse)
     * @param {*} responseError String | Object
     * @return { String } 
     */
    error(responseError) {
        try {
            if (typeof responseError === 'string') this.message = responseError
            else if (typeof responseError === 'object') {           // Serverside
                if(responseError.data) {
                    this.errorHandling(responseError, this.router);
                    this.message = responseError.data.message 
                        ?  responseError.data.message
                        :  responseError.status
                            ? responseError.status
                            : this.defaultErrorMessage;
                } else if (responseError.message) {                 // Clientside
                    this.message = responseError.message;
                }
            }
        } catch (error) {
            this.message = error.message ? error.message : error;   // Only Client or Custom Message
        } finally {                                                 // Show Notification
            try {
                if(this.notify) this.notify();
                if(this.progressBar) this.progressBar.hidden = true;
                this.notify = Notify.create({
                    position: this.position,
                    type: 'negative',
                    message: this.message,
                    timeout: this.duration,
                    classes: this.class
                });
            } catch (error) {
                console.log('Toast_Notification_Error', error)
            }
        }
        console.log('Error Response:', this.message)
        return this.message;
    }
}
