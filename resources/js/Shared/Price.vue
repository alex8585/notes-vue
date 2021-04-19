<template>
  <div class="pt-8 -mr-0 -mb-8 flex flex-wrap" @setCurrentSymbolHandler="setCurrentSymbolHandler()">
    <span class="mt-10 text-lg font-bold pr-6 pb-8 w-full lg:w-1/2">Купить / {{ price ? parseFloat(price.ask).toFixed(4) : '' }} $</span>
    <span class="mt-10 text-lg font-bold pr-6 pb-8 w-full lg:w-1/2">Продать / {{ price ? parseFloat(price.bid).toFixed(4) : '' }} $</span>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex'
export default {
  props: {
    strSymbol: String,
    markets: Object,
  },
  data() {
    return {
      oldStrSymbol: null,
    }
  },
  computed: mapGetters('terminal', ['price']),
  watch: {
    strSymbol() {
      this.unsubscribeChannel()
      this.subscribeChannel(this.strSymbol)
    },
  },
  mounted() {
    this.subscribeChannel(this.strSymbol)
  },

  methods: {
    ...mapActions('terminal', ['setPrice']),
    subscribeChannel(strSymbol) {
      let symbol = this.markets[strSymbol]
      let $store = this.$store
      window.echo.channel(`ticker.${symbol.id}`).listen('TickerUpdateEvent', e => {
        $store.dispatch('terminal/setPrice', e.symbol)
      })
      this.oldStrSymbol = strSymbol
    },
    unsubscribeChannel() {
      if (this.oldStrSymbol) {
        let symbol = this.markets[this.oldStrSymbol]
        window.echo.leave(`ticker.${symbol.id}`)
      }
    },
    setCurrentSymbolHandler: function() {},
  },
}
</script>
