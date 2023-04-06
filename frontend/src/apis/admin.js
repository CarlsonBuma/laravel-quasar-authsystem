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
    return axios.post("/admin-backpanel");
}

export { 
    loginBackpanel,
};
