import Vue from 'vue';
import Vuex from 'vuex';
Vue.use(Vuex)

const store = new Vuex.Store({
    state: {
      token:'',
      login_status:false,
      dataPrower:[],
      currentNav:{}
    },
    mutations: {
      setToken(state,payload){
        state.token = payload
      },
      setLoginStatus(state,payload){
        state.login_status = payload
      },
      setDataPrower(state,payload){
        state.dataPrower = payload
      },
      setcurrentNav(state,payload){
        state.currentNav = payload
      }
    },
    actions: {
       
    },
    getters: {
      
    }
})

export default store