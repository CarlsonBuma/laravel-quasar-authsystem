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
const changeAvatar = (formData) => {
    return axios.post('/user-change-avatar', formData);
}

const changeName = (userName) => {
    return axios.post('/user-change-name', {
        name: userName
    });
}

const changePassword = (current, password, confirm) => {
    return axios.post('user-change-password', {
        'password_current': current,
        'password': password,
        'password_confirmation': confirm
    });
}

const changeEmailRequest = (email, password) => {
    // Transfer account
    return axios.post('user-transfer-request', {
        'email': email,
        'password': password
    });
}

const changeEmail = (signedRoute) => {
    // Redirecting Request from Client-URL to Origin-URL (SERVER)
    // Server Request to signedRoute
    return axios.get(signedRoute);
}

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
const createAccount = (user) => {
    return axios.post("/create-account", {
        'name': user.name,
        'email': user.email,
        'password': user.password,
        'password_confirmation': user.password_confirm,
        'terms': user.agreed,
    });
}

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

const requestNewPassword = (email) => {
    return axios.post("/password-reset-request", {
        'email': email
    });
}

const setNewPassword = (signedRoute, credentials) => {
    // Redirecting Request from Client-URL to Origin-URL (SERVER)
    // Server Request to signedRoute
    return axios.put(signedRoute, {
        'password': credentials.password,
        'password_confirmation': credentials.password_confirm
    });
}

export { 
    setCSRFToken,
    userLogin,
    userAuth,
    userLogout,
    changeAvatar,
    changeName,
    changeEmailRequest,
    changeEmail,
    changePassword,
    deleteUser,
    createAccount,
    emailVerificationRequest,
    emailVerification,
    requestNewPassword,
    setNewPassword
};