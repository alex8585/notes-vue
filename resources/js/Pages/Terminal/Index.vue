<template>
  <div>
    Terminal

    <form>
      <div class="pt-8 -mr-0 -mb-8 flex flex-wrap">
        <select-input v-cloak v-model="symbolsForm.symbol" :error="symbolsForm.errors.symbol" class="pr-6 pb-8 w-full lg:w-1/3" label="Пара" @change="setCurrentSymbolHandler($event)">
          <option v-for="market in markets" :key="market.id" :value="market.symbol">{{ market.symbol }}</option>
        </select-input>
        <select-input v-cloak v-if="currentSymbol" v-model="symbolsForm.leverage" :error="symbolsForm.errors.leverage" class="pr-6 pb-8 w-full lg:w-1/3" label="Плечо" @change="$store.dispatch('terminal/setLeverage', $event)">
          <option v-for="l in currentSymbol.leverage" :key="l" :value="l">{{ l }}</option>
        </select-input>

        <div class="flex justify-end items-center pb-2">
          <loading-button :loading="symbolsForm.processing" class="btn-indigo " type="submit">Ok</loading-button>
        </div>
      </div>
    </form>
    <Price :str-symbol="symbolsForm.symbol" :markets="markets" />
    <div class="flex flex-wrap ">
      <form class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          <text-input v-model="buyForm.quantity" :error="buyForm.errors.quantity" class="pr-6 pb-8 w-full " label="Количество USDT" />
          <text-input v-model="buyForm.stop1" :error="buyForm.errors.stop1" class="pr-6 pb-8 w-full lg:w-1/2" label="Stop Loss 1" />
          <text-input v-model="buyForm.stop1_price" :error="buyForm.errors.stop1_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Цена" />
          <text-input v-model="buyForm.stop2" :error="buyForm.errors.stop2" class="pr-6 pb-8 w-full lg:w-1/2" label="Stop Loss 2" />
          <text-input v-model="buyForm.stop2_price" :error="buyForm.errors.stop2_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Цена" />
          <text-input v-model="buyForm.take" :error="buyForm.errors.take" class="pr-6 pb-8 w-full lg:w-1/2" label="Take profit" />
          <text-input v-model="buyForm.take_price" :error="buyForm.errors.take_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Цена" />
          <div class="flex justify-end items-center pb-2">
            <loading-button :loading="symbolsForm.processing" class="btn-indigo " type="submit">Ok</loading-button>
          </div>
        </div>
      </form>

      <form class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          <text-input v-model="sellForm.quantity" :error="sellForm.errors.quantity" class="pr-6 pb-8 w-full " label="Количество USDT" />
          <text-input v-model="sellForm.stop1" :error="sellForm.errors.stop1" class="pr-6 pb-8 w-full lg:w-1/2" label="Stop Loss 1" />
          <text-input v-model="sellForm.stop1_price" :error="sellForm.errors.stop1_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Цена" />
          <text-input v-model="sellForm.stop2" :error="sellForm.errors.stop2" class="pr-6 pb-8 w-full lg:w-1/2" label="Stop Loss 2" />
          <text-input v-model="sellForm.stop2_price" :error="sellForm.errors.stop2_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Цена" />
          <text-input v-model="sellForm.take" :error="sellForm.errors.take" class="pr-6 pb-8 w-full lg:w-1/2" label="Take profit" />
          <text-input v-model="sellForm.take_price" :error="sellForm.errors.take_price" class="pr-6 pb-8 w-full lg:w-1/2" label="Цена" />
          <div class="flex justify-end items-center pb-2">
            <loading-button :loading="symbolsForm.processing" class="btn-indigo " type="submit">Ok</loading-button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import SelectInput from '@/Shared/SelectInput'
import LoadingButton from '@/Shared/LoadingButton'
import Price from '@/Shared/Price'
import { mapGetters, mapActions } from 'vuex'

export default {
  metaInfo: { title: 'Terminal' },

  components: {
    Price,
    LoadingButton,
    SelectInput,
    TextInput,
  },
  layout: Layout,
  props: {
    markets: Object,
  },

  data() {
    return {
      price: null,
      // symbolsForm: this.$inertia.form({
      //   symbol: 'BTC/USDT',
      //   leverage: null,
      // }),
      buyForm: this.$inertia.form({
        quantity: null,
        stop1: null,
        stop2: null,
        take: null,
        stop1_price: null,
        stop2_price: null,
        take_price: null,
      }),
      sellForm: this.$inertia.form({
        quantity: null,
        stop1: null,
        stop2: null,
        take: null,
        stop1_price: null,
        stop2_price: null,
        take_price: null,
      }),
    }
  },
  computed: mapGetters('terminal', ['currentSymbol', 'symbolsForm']),
  mounted: function() {
    let symbol = this.markets[this.symbolsForm.symbol]

    //this.subscribeChannel(symbol)
    this.$store.dispatch('terminal/setCurrentSymbol', symbol)
  },
  updated: function() {
    if (this.currentSymbol) {
      //console.log('2')
    }
  },
  created() {},
  methods: {
    ...mapActions('terminal', ['setCurrentSymbol', 'setLeverage', 'setPrice']),
    setCurrentSymbolHandler: function($event) {
      // let oldSymbol = this.markets[this.symbolsForm.symbol]
      // this.unsubscribeChannel(oldSymbol)

      let symbol = this.markets[$event]
      //this.subscribeChannel(symbol)

      this.$store.dispatch('terminal/setCurrentSymbol', symbol)
    },
  },
}
</script>
