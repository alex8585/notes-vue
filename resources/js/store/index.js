import Vuex from 'vuex'
import Vue from 'vue'
import modules from './modules'
//import todos from './modules/todos'
//import notes from './modules/notes'
// Load Vuex

//console.log(modules)
// Create store
Vue.use(Vuex)
export default new Vuex.Store({
  modules,
})
