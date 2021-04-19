<template>
  <div>
    Terminal

    <SymbolForm :str-symbol="symbolsForm.symbol" :markets="markets" />
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
            <button class="btn-indigo" type="submit" @click.prevent="sendBuyForm">Купить</button>
            <!-- <loading-button :loading="symbolsForm.processing" class="btn-indigo " type="submit">Ok</loading-button> -->
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
            <button class="btn-indigo" type="submit" @click.prevent="sendSellForm">Продать</button>
            <!-- <loading-button :loading="symbolsForm.processing" class="btn-indigo " type="submit">Ok</loading-button> -->
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import Price from '@/Shared/Price'
import SymbolForm from '@/Shared/SymbolForm'
import { mapGetters, mapActions } from 'vuex'

export default {
  metaInfo: { title: 'Terminal' },

  components: {
    Price,
    LoadingButton,
    SymbolForm,
    TextInput,
  },
  layout: Layout,
  props: {
    markets: Object,
  },

  data() {
    return {}
  },
  computed: {
    ...mapGetters('terminal', ['currentSymbol', 'symbolsForm', 'buyForm', 'sellForm', 'price']),
  },

  mounted: function() {
    let symbol = this.markets[this.symbolsForm.symbol]
    this.$store.dispatch('terminal/setCurrentSymbol', symbol)
  },
  updated: function() {},
  created() {},
  methods: {
    ...mapActions('terminal', ['setCurrentSymbol', 'sendBuyForm', 'sendSellForm']),
  },
}
</script>
