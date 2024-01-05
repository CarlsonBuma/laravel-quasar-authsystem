'use strict';
import { defineStore } from "pinia";
import { LocalStorage } from 'quasar'
import axios from 'axios';

const storeUser = defineStore({
    id: "user",
    state: () => ({
        access: {
            user: false,        // Access to memberarea
            admin: false,       // Access to adminarea
        },
        user: {
            id: 0,
            name: 'User',
            avatar: '',
            email: '',
        },
    }),
    actions: {
        setUser(user) {
            this.user.id = user.id
            this.user.name = user.name
            this.user.avatar = user.avatar;
            this.user.email = user.email;
            this.access.user = true;
            this.access.admin = user.is_admin
        },

        setToken(sessionToken) {
            LocalStorage.set(process.env.SESSION_NAME, sessionToken)
        },

        setSession() {
            const token = LocalStorage.getItem(process.env.SESSION_NAME);
            if(!token) throw 'No token set.';
            axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
        },

        removeToken() {
            LocalStorage.remove(process.env.SESSION_NAME)
        },

        removeSession() {
            axios.defaults.headers.common['Authorization'] = '';
            this.access.user = false;
            this.access.admin = false;
            this.user = {
                id: 0,
                name: 'User',
                avatar: '',
                email: '',
            }
        },

        removeAdmin() {
            this.access.admin = false;
        },
    }
});

export default storeUser;
