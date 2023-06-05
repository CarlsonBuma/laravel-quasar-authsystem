import { boot } from 'quasar/wrappers';
import axios from 'axios';

export default boot(({ app }) => {
    // axios.defaults.headers.common['Authorization'] = ""
    // Is set in storeUser
    axios.defaults.baseURL = process.env.APP_API_URL;
    axios.defaults.withCredentials = true;
    app.config.globalProperties.$axios = axios;
});
