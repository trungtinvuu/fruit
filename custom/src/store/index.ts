import { createStore } from 'vuex';

export default createStore({
  state: {
    infoUser: {},
    isLoggedIn: false,
  },
  mutations: {
    setUserInfo(state, info) {
      state.infoUser = info;
    },
    setUserLogin(state, status) {
      state.isLoggedIn = status;
    },
  },
  actions: {
    setupInfoUser(context,info) {
      context.commit('setUserInfo', info);
    },
    setLoginStatus({ commit }, status) {
      commit('setUserLogin', status);
    },
  },
  getters: {
    getInfoUser: state => state.infoUser,
    isLoggedIn: state => state.isLoggedIn,
  },
});
