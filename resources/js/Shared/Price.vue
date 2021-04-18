<template>
  <div @setCurrentSymbolHandler="setCurrentSymbolHandler()">
    <span class="mt-10 text-lg font-bold">Купить / {{ price ? parseFloat(price.bid).toFixed(4) : '' }} $</span>
    <span class="mt-10 text-lg font-bold">Продать / {{ price ? parseFloat(price.ask).toFixed(4) : '' }} $</span>
  </div>
</template>

<script>
export default {
  props: {
    strSymbol: String,

    markets: Object,
  },
  data() {
    return {
      price: '',
      oldStrSymbol: null,
    }
  },
  watch: {
    strSymbol() {
      console.log('2')
      this.unsubscribeChannel()
      this.subscribeChannel(this.strSymbol)
    },
  },
  mounted() {
    console.log('1')
    this.subscribeChannel(this.strSymbol)
  },

  methods: {
    subscribeChannel(strSymbol) {
      let symbol = this.markets[strSymbol]
      window.echo.channel(`ticker.${symbol.id}`).listen('TickerUpdateEvent', e => {
        this.price = e.symbol
        //$store.dispatch('terminal/setPrice', e.symbol)
      })
      this.oldStrSymbol = strSymbol
    },
    unsubscribeChannel() {
      let symbol = this.markets[this.oldStrSymbol]
      window.echo.leave(`ticker.${symbol.id}`)
    },
    setCurrentSymbolHandler: function() {},
  },
}
</script>
