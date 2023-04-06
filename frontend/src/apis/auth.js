"use strict";

import axios from 'axios';

/*
 * AUTH System
 *  > CSRF
 *  > Login
 *      > AUTH
 *      > Logout
 */
const setCSRFToken = () => {
    return axios.get("/sanctum/csrf-cookie");
}

const userLogin = (credentials) => {
    return axios.post("/login", {
        'email': credentials.email,
        'password': credentials.password,
        'remember': credentials.remember,
    });
}

const userAuth = () => {
    return axios.get('/auth')
}

const userLogout = () => {
    return axios.post('/logout');
}

/*
 * User Account Management
 *  > change Avatar
 *  > change Name
 *  > change Password
 *  > > Change Email
 *      > Request changing email
 *      > Verify transfer
 *  > delete Account
 */

// User - Update Avatar
const changeAvatar = (formData) => {
    return axios.post('/user-change-avatar', formData);
}

// User - Change Name
const changeName = (userName) => {
    return axios.post('/user-change-name', {
        name: userName
    });
}

// User - Change Password
const changePassword = (current, password, confirm) => {
    return axios.post('user-change-password', {
        'password_current': current,
        'password': password,
        'password_confirmation': confirm
    });
}

// User - Transfer Account
const transferAccount = (email, password) => {
    return axios.post('user-transfer-account', {
        'email': email,
        'password': password
    });
}

const updateEmail = (signedRoute, pw, pw_confirm) => {
    // transferAccount is in progress - Request to origin URL (Client)
    // Redirecting Request from Client-URL to Origin-URL (SERVER)
    return axios.put(signedRoute, {
        'password': pw,
        'password_confirmation': pw_confirm
    });
}

// User - Delete Account
const deleteUser = (password) => {
    return axios.post('user-delete-account', {
        'password': password,
    });
}

/*
 * Account Managemenr
 *  > create Account
 *  > verify Account
 *      > Request verify email 
 *      > Verify email
 *  > reset Password
 *      > Request reseting password
 *      > Reset Password
 */

// Register
const createAccount = (user) => {
    return axios.post("/create-account", {
        'name': user.name,
        'email': user.email,
        'password': user.password,
        'password_confirmation': user.password_confirm,
        'terms': user.agreed,
    });
}

// Email Verification
const emailVerificationRequest = (email) => {
    return axios.post("/email-verification-request", {
        'email': email,
    });
}

const emailVerification = (signedRoute) => {
    // Redirecting Request from Client-URL to Origin-URL (SERVER)
    // Server Request to signedRoute
    return axios.get(signedRoute);
}

// Password Reset
const passwordResetRequest = (email) => {
    return axios.post("/password-reset-request", {
        'email': email
    });
}

const passwordReset = (signedRoute, password, password_confirm) => {
    // Redirecting Request from Client-URL to Origin-URL (SERVER)
    // Server Request to signedRoute
    return axios.put(signedRoute, {
        'password': password,
        'password_confirmation': password_confirm
    });
}

export { 
    setCSRFToken,
    userLogin,
    userAuth,
    userLogout,
    changeAvatar,
    changeName,
    transferAccount,
    updateEmail,
    changePassword,
    deleteUser,
    createAccount,
    emailVerificationRequest,
    emailVerification,
    passwordResetRequest,
    passwordReset
};