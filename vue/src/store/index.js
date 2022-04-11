import axios from "axios";
import { createStore } from "vuex";
import axiosClient from "../axios";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
        },
        topStreams: {},
        topGames: {},
        voteStream: {
            vote: {},
            votingStreamer: {},
        },
        voteGame: {
            vote: {},
            votingGame: {},
        },
        topVoted: {
            streamers: {},
            games: {},
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
                    if (res.data.imageUrl === '' || res.data.imageUrl === null) {
                        res.data.imageUrl = "../src/assets/images/default.png";
                    }
                    commit('setUser', res.data)
                })
        },
        profile() {
            return axiosClient.get('/user')
                .then(res => {
                    return res.data;
                })
        },
        voteStreamer({ commit }, voteStream) {
            return axiosClient.post('/voteStreamer', voteStream)
                .then(({ data }) => {
                    commit('setVoteStream', data);
                    return store.state.voteStream.vote;
                })
        },
        voteGame({ commit }, voteGames) {
            return axiosClient.post('/voteGame', voteGames)
                .then(({ data }) => {
                    commit('setVoteStream', data);
                    return store.state.voteGame.vote;
                })
        },
        getTopStreams({ commit }) {
            return axiosClient.get('/getTopStreams')
                .then(({ data }) => {
                    commit('setTopStreams', data)
                    return store.state.topStreams;
                })
        },
        getTopGames({ commit }) {
            return axiosClient.get('/getTopGames')
                .then(({ data }) => {
                    commit('setTopGames', data)
                    return store.state.topGames;
                })
        },

        getStreamer({ commit }, streamer_id) {
            return axiosClient.post('/getStreamer', { id: streamer_id })
                .then((data) => {
                    commit('setVotingStreamer', data)
                    return store.state.voteStream.votingStreamer;
                })
        },
        getGame({ commit }, streamer_id) {
            return axiosClient.post('/getGame', { id: streamer_id })
                .then((data) => {
                    commit('setVotingGame', data)
                    return store.state.voteGame.votingGame;
                })
        },
        getTopVoted({ commit }) {
            return axiosClient.get('/getTopVoted')
                .then((data) => {
                    commit('setTopVoted', data)
                    return store.state.topVoted;
                })
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
        setVoteStream: (state, voteStream) => {
            state.voteStream.vote = voteStream;
        },
        setVoteGame: (state, voteGame) => {
            state.voteGame.vote = voteGame;
        },
        setVotingStreamer: (state, votingStreamer) => {
            state.voteStream.votingStreamer = votingStreamer;
        },
        setVotingGame: (state, votingGame) => {
            state.voteGame.votingGame = votingGame;
        },
        setTopStreams: (state, topStreams) => {
            state.topStreams = topStreams;
        },
        setTopGames: (state, topGames) => {
            state.topGames = topGames;
        },
        setTopVoted: (state, topVoted) => {
            state.topVoted = topVoted;
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