import { defineStore } from "pinia";

const userStore = defineStore({
    id: "user",
    state: () => ({
        access: {
            logged: false,
            role: 'guest'       // Default roles as 'user', 'admin'
        },
        user: {
            id: 0,
            name: 'bumaUser',
            avatar: '',
            email: 'email@email.com'
        },
    }),
    actions: {
        
        loginUser(user) {
            // Baerer Token API
            // this.$axios.defaults.headers.common["Authorization"] = "Bearer_" + user.token;
            
            // User Auth
            this.access.logged = true;
            this.access.role = user.role

            // Credits
            this.user.id = user.id
            this.user.name = user.name
            this.user.avatar = user.avatar;
            this.user.email = user.email;
        },

        logoutUser() {
            // Remove Baerer Token
            // this.$axios.defaults.headers.common["Authorization"] = "";

            // User Auth
            this.access.logged = false;
            this.access.role = 'guest'

            this.user = {
                id: 0,
                name: 'bumaUser',
                avatar: '',
                email: 'email@email.com'
            };
        }
    }
});

export default userStore;
