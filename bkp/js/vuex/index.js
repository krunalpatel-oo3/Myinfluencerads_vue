import Vue from 'vue';
import Vuex from 'vuex';

import SecureLS from 'secure-ls';
const ls=new SecureLS({
    isCompression: false
});

Vue.use(Vuex);

export default new Vuex.Store({
    state: {
        showLogin: false,
        isAuthenticated: false,
        token: null
    },
    mutations: {
        refreshToken(state, accessToken) {
            localStorage.setItem("sgtoken", accessToken)
        },
    },
    actions: {
        refreshToken({ commit }, accessToken) {
            commit('refreshToken', accessToken)
        }
    },
})
