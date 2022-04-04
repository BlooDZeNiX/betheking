import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
        dashboard: {
            loading: false,
            data: {}
        },
        notification: {
            show: false,
            type: 'success',
            message: ''
        }
    },
    getters: {},
    actions: {

        signUp({ commit }, user) {
            return axiosClient.post('/signup', user)
                .then(({ data }) => {
                    commit('setUser', data.user);
                    commit('setToken', data.token)
                    return data;
                })
        },
        login({ commit }, user) {
            return axiosClient.post('/login', user)
                .then(({ data }) => {
                    commit('setUser', data.user);
                    commit('setToken', data.token)
                    return store.user;
                })
        },
        logout({ commit }) {
            return axiosClient.post('/logout')
                .then(response => {
                    commit('logout')
                    return response;
                })
        },
        getUser({ commit }) {
            return axiosClient.get('/user')
                .then(res => {
                    commit('setUser', res.data)
                })
        },
        profile() {
            return axiosClient.get('/user')
                .then(res => {
                    return res.data;
                })
        },
        voteStreamer() {
            return axiosClient.post('/voting/streamer', vote)
                .then(({ data }) => {

                });
        }
    },
    mutations: {
        setUser: (state, user) => {
            state.user.data = user;
        },
        setToken: (state, token) => {
            state.user.token = token;
            sessionStorage.setItem('TOKEN', token);
        },
        logout: (state) => {
            state.user.token = null;
            state.user.data = {};
            sessionStorage.removeItem("TOKEN");
        },

    },
    modules: {},

});
export default store;