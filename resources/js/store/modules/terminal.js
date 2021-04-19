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
  buyForm: Form({
    direction: 'buy',
    symbol: null,
    quantity: null,
    stop1: null,
    stop2: null,
    take: null,
    stop1_price: null,
    stop2_price: null,
    take_price: null,
  }),
  sellForm: Form({
    direction: 'sell',
    symbol: null,
    quantity: null,
    stop1: null,
    stop2: null,
    take: null,
    stop1_price: null,
    stop2_price: null,
    take_price: null,
  }),
}

const getters = {
  price() {
    return state.price
  },
  currentSymbol() {
    return state.currentSymbol
  },
  symbolsForm() {
    return state.symbolsForm
  },
  buyForm() {
    return state.buyForm
  },
  sellForm() {
    return state.sellForm
  },
}

const actions = {
  setCurrentSymbol: ({ commit }, v) => {
    commit('SET_CURRENT_SYMBOL', v)
  },
  setLeverage: ({ commit }, v) => commit('SET_LEVERAGE', v),
  setPrice: ({ commit }, v) => commit('SET_PRICE', v),
  sendBuyForm: ({ commit }, v) => {
    // axios.get(`get-last-price/${v.id}`).then(response => {
    //   commit('SET_PRICE', v)
    // })
    state.buyForm.symbol = state.currentSymbol.symbol
    state.buyForm.post(route('terminal.create_order'), {
      replace: false,
      preserveState: true,
      onSuccess: () => {
        //commit('SET_MODAL_EDIT', false)
      },
    })
  },
  sendSellForm: ({ commit }, v) => {
    state.sellForm.symbol = state.currentSymbol.symbol
    state.sellForm.post(route('terminal.create_order'), {
      replace: false,
      preserveState: true,
      onSuccess: () => {},
    })
  },
  sortHanle({ commit }, { sort, defaultDirection }) {
    let query = getUrlQuery()

    let direction = query.direction ? query.direction : defaultDirection

    direction = direction == 'asc' ? 'desc' : 'asc'

    query = { ...query, direction, sort }

    Inertia.get(route(route().current()), query, {
      //preserveScroll: true,
      replace: true,
      preserveState: true,
    })
  },
}

const mutations = {
  SET_CURRENT_SYMBOL: (state, v) => {
    state.currentSymbol = v
    state.symbolsForm.symbol = v['symbol']
    state.symbolsForm.leverage = v.leverage[0]
  },

  SET_LEVERAGE: (state, v) => (state.symbolsForm.leverage = v),
  SET_PRICE: (state, v) => {
    state.price = v
    if (state.buyForm.stop1) {
      let priceAsk = parseFloat(state.price.ask)

      let pesentValbuy = (priceAsk * state.buyForm.stop1) / 100
      if (pesentValbuy) {
        state.buyForm.stop1_price = (priceAsk - pesentValbuy).toFixed(4)
      }

      let pesentValbuyTake = (priceAsk * state.buyForm.take) / 100
      if (pesentValbuyTake) {
        state.buyForm.take_price = (priceAsk + pesentValbuyTake).toFixed(4)
      }
    }
    if (state.sellForm.stop1) {
      let priceBid = parseFloat(state.price.bid)

      let pesentValsell = (priceBid * state.sellForm.stop1) / 100
      if (pesentValsell) {
        state.sellForm.stop1_price = (priceBid + pesentValsell).toFixed(4)
      }

      let pesentValsellTake = (priceBid * state.sellForm.take) / 100
      if (pesentValsellTake) {
        state.sellForm.take_price = (priceBid - pesentValsellTake).toFixed(4)
      }
    }
  },
}

export default {
  state,
  getters,
  actions,
  mutations,
}
