/* Carlson - 30.12.2022 - v.0.0.1 */
import { Notify } from 'quasar';
import store from "src/stores/storeUser.js";

/** Customizing Server-Response */
const errorHandling = (serverResponse, router) => {
    
    // Handle Custom Error here
    // Not authenticated
    if(serverResponse.status === 401) {
        store().logoutUser();
        router.push('login');
        throw 'Hmm, not authenticaded. Please login again.'
    }
}

/** Boot: Load Toast */
const loadToast = (router) => {
    return new Toaster(router);
}

/*
 * Request Handling
 *  > Loading
 *  > Success
 *  > Error
 *      > Manage Error Status
 */
class Toaster {
    constructor(router) {
        this.message = '';
        this.router = router;
        this.store = store();
        this.progressBar = null;
        this.notify = null;
        this.position = 'top-right';
        this.duration = 3400;
        this.class = "toaster-container"
        this.defaultLoadMessage = "Processing..."
        this.defaultSuccessMessage = "Your settings have been saved.";
        this.defaultErrorMessage = "Ops, some error occured.";
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

    error(responseError) {
        try {

            // Render Response String
            if (typeof responseError === 'string') this.message = responseError

            // Render Response Object
            else if (typeof responseError === 'object') {

                // Server Response
                if(responseError.data) {
                    errorHandling(responseError, this.router);
                    this.message = responseError.data.message 
                        ?  responseError.data.message
                        :  responseError.status
                            ? responseError.status
                            : this.defaultErrorMessage;
                }

                // Client Side
                else if (responseError.message) {
                    this.message = responseError.message;
                }
            }
        } catch (error) {
            // Only Client or Custom Message
            this.message = error.message ? error.message : error;
        } 
        
        // Process
        finally {
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

export default loadToast;
