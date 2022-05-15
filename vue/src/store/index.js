import axios from "axios";
import { createStore } from "vuex";
import axiosClient from "../axios";
import axiosClient2 from "../axios2";

const store = createStore({
    state: {
        user: {
            data: {},
            token: sessionStorage.getItem("TOKEN"),
            votes: {},
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
            dashboard: {
                todayVotes: {}
            },
            loading: false,
            edit: {
                user: {},
                streamer: {},
                game: {},
            },
            data: {
                users: {},
                streamers: {},
                games: {},
            },
        },
        notification: {
            show: false,
            type: 'success',
            message: ''
        }
    },
    getters: {},
    actions: {
        //Auth Functions
        /**
         * Function to sign in the web and set user and token data in the Store
         * @param {*} user
         * @returns
         */
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

        //User Functions
        getUser({ commit }) {
            return axiosClient.get('/user')
                .then(res => {
                    if (res.data.imageUrl === '' || res.data.imageUrl === null) {
                        res.data.imageUrl = "../src/assets/images/default.png";
                    }
                    commit('setUser', res.data)
                })
        },
        getUserById({ commit }, id) {
            return axiosClient.post('/getUserById', id)
                .then(res => {
                    commit('setEditUser', res.data)
                    return res;
                })
        },
        getUsersDashboard({ commit }) {
            return axiosClient.get('/getUsers')
                .then(res => {
                    commit('setUsersDashboard', res.data)
                    return res;
                })
        },
        getTodayUsers({ commit }) {
            return axiosClient.get('/getTodayUsers')
                .then((data) => {
                    commit('setTodayUsers', data);
                    return data;
                })
        },
        editUserImage({ commit }, formData) {
            return axiosClient2.post('/editUserImage', formData)
                .then(res => {
                    commit('setUserImage', res.data.fileName);
                    return res;
                })
                .catch(error => {
                    console.log(error)
                })
        },
        editUserPassword({ commit }, changePassword) {
            return axiosClient.post('/editUserPassword', changePassword)
                .then(res => {
                    return res;
                })
        },
        editUserData({ commit }, edit) {
            return axiosClient.post('/editUserData', edit)
                .then(response => {
                    return response;
                })
        },
        disableUser({ commit }, user) {
            return axiosClient.post('/disableUser', user)
                .then(response => {
                    return response;
                })
        },
        enableUser({ commit }, user) {
            return axiosClient.post('/enableUser', user)
                .then(response => {
                    return response;
                })
        },
        deleteUserData({ commit }, user) {
            return axiosClient.post('/deleteUserData', user);
        },
        getUserVotes({ commit }, user) {
            return axiosClient.post('/userVotes', user)
                .then(response => {
                    commit('setUserVotes', response.data);
                    return response.data;
                })
        },
        verifyEmail({ commit }, data) {
            console.log(data)
            return axiosClient.post('/verifyEmail', data)
                .then(response => {
                    commit('setUserVerification', response.data);
                });
        },
        profile() {
            return axiosClient.get('/user')
                .then(res => {
                    return res.data;
                })
        },

        //Streamers Functions
        getStreamersDashboard({ commit }) {
            return axiosClient.get('/getStreamers')
                .then(res => {
                    commit('setStreamersDashboard', res.data)
                    return res;
                })
        },
        getTopStreams({ commit }) {
            return axiosClient.get('/getTopStreams')
                .then(({ data }) => {
                    commit('setTopStreams', data)
                    return store.state.topStreams;
                })
        },
        getStreamer({ commit }, streamer_id) {
            return axiosClient.post('/getStreamer', { id: streamer_id })
                .then((data) => {
                    commit('setVotingStreamer', data)
                    return store.state.voteStream.votingStreamer;
                })
        },
        deleteStreamer({ commit }, streamer) {
            return axiosClient.post('/deleteStreamer', streamer);
        },

        //Voting Functions
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
                    commit('setVoteGame', data);
                    return data;
                })
        },
        getTopVoted({ commit }) {
            return axiosClient.get('/TopVoted')
                .then((data) => {
                    commit('setTopVoted', data)
                    return store.state.topVoted;
                })
        },
        getTodayVotes({ commit }) {
            return axiosClient.get('/getTodayVotes')
                .then((data) => {
                    commit('setTodayVotes', data);
                    return data;
                })
        },

        //Games Functions
        getGamesDashboard({ commit }) {
            return axiosClient.get('/getGames')
                .then(res => {
                    commit('setGamesDashboard', res.data)
                    return res;
                })
        },
        getTopGames({ commit }) {
            return axiosClient.get('/getTopGames')
                .then(({ data }) => {
                    commit('setTopGames', data)
                    return store.state.topGames;
                })
        },
        getGame({ commit }, streamer_id) {
            return axiosClient.post('/getGame', { id: streamer_id })
                .then((data) => {
                    commit('setVotingGame', data)
                    return store.state.voteGame.votingGame;
                })
        },
        deleteGame({ commit }, game) {
            return axiosClient.post('/deleteGame', game);
        },

    },
    mutations: {
        setUser: (state, user) => {
            state.user.data = user;
        },
        setEditUser: (state, user) => {
            state.dashboard.edit.user = user;
        },
        setUserVerification: (state, verification) => {
            state.user.data.email = verification.email;
            state.user.data.email_verified_at = verification.email_verified_at;
        },
        setTodayVotes: (state, votes) => {
            state.dashboard.dashboard.todayVotes = votes;
        },
        setTodayUsers: (state, users) => {
            state.dashboard.dashboard.todayUsers = users;
        },
        setUsersDashboard: (state, users) => {
            state.dashboard.data.users = users;
        },
        setStreamersDashboard: (state, streamers) => {
            state.dashboard.data.streamers = streamers;
        },
        setGamesDashboard: (state, Games) => {
            state.dashboard.data.Games = Games;
        },
        setUserImage: (state, imageUrl) => {
            state.user.data.imageUrl = imageUrl;
        },
        setUserVotes: (state, votes) => {
            state.user.votes = votes;
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
            state.user.votes = {};
            sessionStorage.removeItem("TOKEN");
        },

    },
    modules: {},

});
export default store;