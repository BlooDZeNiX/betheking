import axios from "axios";
import store from "./store";
import router from "../router";

const axiosClient2 = axios.create({
    baseURL: `${import.meta.env.VITE_API_BASE_URL}/api`

})

axiosClient2.interceptors.request.use(config => {
    config.headers.Authorization = `Bearer ${store.state.user.token}`
    config.headers.common.Accept = 'multipart/form-data'
    return config;
})

axiosClient2.interceptors.response.use(response => {
    return response;
}, error => {
    if (error.response.status === 401) {
        sessionStorage.removeItem('TOKEN')
        router.push({ name: 'Login' })
    } else if (error.response.status === 404) {
        router.push({ name: 'NotFound' })
    }
    throw error;
})

export default axiosClient2;