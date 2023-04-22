'use strict';
import { defineStore } from "pinia";
import axios from 'axios';

const userStore = defineStore({
    id: "user",
    state: () => ({
        accessToken: localStorage.getItem(process.env.SESSION_NAME),
        access: {
            user: false,
            admin: false,
            role: 'guest',          // Default roles as 'user', 'admin'
        },
        user: {
            id: 0,
            name: 'User',
            avatar: '',
            email: ''
        },
    }),
    actions: {

        removeAdmin() {
            this.access.admin = false;
        },
        
        setUser(user) {
            // Credits
            this.user.id = user.id
            this.user.name = user.name
            this.user.avatar = user.avatar;
            this.user.email = user.email;

            // User Auth
            this.access.user = true;
            this.access.admin = user.is_admin
            this.access.role = user.role
        },

        createSession(sessionToken) {
            localStorage.setItem(process.env.SESSION_NAME, sessionToken);
            axios.interceptors.request.use((config) => {
                config.headers["Authorization"] = `Bearer ${sessionToken}`
                return config;
            });
        },

        setSession() {
            const token = localStorage.getItem(process.env.SESSION_NAME);
            if(!token) return false;
            axios.interceptors.request.use((config) => {
                config.headers["Authorization"] = `Bearer ${token}`
                return config;
            });
            return true;
        },

        removeSession() {
            // Remove Session
            localStorage.removeItem(process.env.SESSION_NAME);
            axios.interceptors.request.use((config) => {
                config.headers["Authorization"] = '';
                return config;
            });  

            // User Auth
            this.access.user = false;
            this.access.admin = false;
            this.access.role = 'guest';

            this.user = {
                id: 0,
                name: 'User',
                avatar: '',
                email: ''
            };
        },
    }
});

export default userStore;
