import axios from 'axios';
import store from './../store'

export default function setup() {
    axios.interceptors.request.use((config) => {
        if(store.getters.token) config.headers.Authorization = `Bearer ${store.getters.token}`
        return config
    }, (err) => {
        let errors = [401, 403]
        if ((err?.response?.status && errors.includes(err?.esponse?.status)) || !store.getters.token) {
            store.dispatch("logout")
            return Promise.reject(err)
        }
        return Promise.resolve(err?.response || err)
    });
}