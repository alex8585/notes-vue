import Form from '@inertiajs/inertia-vue/src/form.js'
import throttle from 'lodash/throttle'
//import pickBy from 'lodash/pickBy'
import { Inertia } from '@inertiajs/inertia'
import { getUrlQuery } from '@/utils'
import axios from 'axios'

const state = {
  currentSymbol: null,
  price: null,
  symbolsForm: Form({
    symbol: 'BTC/USDT',
    leverage: null,
  }),
}

const getters = {
  // price() {
  //   return state.price
  // },
  currentSymbol() {
    return state.currentSymbol
  },
  symbolsForm() {
    return state.symbolsForm
  },
}

const actions = {
  setCurrentSymbol: ({ commit }, v) => {
    //axios.get(`get-last-price/${v.id}`).then(response => {
    commit('SET_CURRENT_SYMBOL', v)
    //})
  },
  setLeverage: ({ commit }, v) => commit('SET_LEVERAGE', v),
  setPrice: ({ commit }, v) => commit('SET_PRICE', v),
}

const mutations = {
  SET_CURRENT_SYMBOL: (state, v) => {
    state.currentSymbol = v
    state.symbolsForm.symbol = v['symbol']
    state.symbolsForm.leverage = v.leverage[0]
  },

  SET_LEVERAGE: (state, v) => (state.symbolsForm.leverage = v),
  SET_PRICE: (state, v) => (state.price = v),
}

export default {
  state,
  getters,
  actions,
  mutations,
}
