"use strict";
import axios from 'axios';

/*
 * AUTH System
 *  > CSRF
 *  > Login
 *      > AUTH
 *      > Logout
 */
const loginBackpanel = () => {
    return axios.get("/admin-backpanel");
}

export { 
    loginBackpanel,
};
