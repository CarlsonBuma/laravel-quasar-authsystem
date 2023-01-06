import { boot } from 'quasar/wrappers';
import axios from 'axios';

export default boot(({ app }) => {
    
    // Base URL
    axios.defaults.baseURL = process.env.APP_API_URL;

    // Auth Header
    axios.defaults.headers.common["Authorization"] = "";
    axios.defaults.withCredentials = true;

    // Global Access
    app.config.globalProperties.$axios = axios;
});
