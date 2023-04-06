'use strict';
import { defineStore } from "pinia";

const sessionName = process.env.SESSION_NAME;

const userStore = defineStore({
    id: "user",
    state: () => ({
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
        
        loginUser(user) {
            // User Auth
            this.access.user = true;
            this.access.admin = user.is_admin
            this.access.role = user.role

            // Credits
            this.user.id = user.id
            this.user.name = user.name
            this.user.avatar = user.avatar;
            this.user.email = user.email;
        },

        logoutUser() {
            // Remove Session everytime
            this.removeSession();

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

        setSession() {
            // Baerer Token API
            // this.$axios.defaults.headers.common["Authorization"] = "Bearer_" + user.token;

            // Set Session
            localStorage.setItem(sessionName, 'true');
        },

        removeSession() {
            // Remove Baerer Token
            // this.$axios.defaults.headers.common["Authorization"] = "";

            // Remove Sesseion
            localStorage.removeItem(sessionName);
        },

        removeAdmin() {
            this.access.admin = false;
        }
    }
});

export default userStore;
