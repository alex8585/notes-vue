<template>
  <div class="pt-8 -mr-0 -mb-8 flex flex-wrap" @setCurrentSymbolHandler="setCurrentSymbolHandler()">
    <span class="mt-10 text-lg font-bold pr-6 pb-8 w-full lg:w-1/2">Купить / {{ price ? parseFloat(price.ask).toFixed(4) : '' }} $</span>
    <span class="mt-10 text-lg font-bold pr-6 pb-8 w-full lg:w-1/2">Продать / {{ price ? parseFloat(price.bid).toFixed(4) : '' }} $</span>
  </div>
</template>

<script>
import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')
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
    this.echo = new Echo({
      broadcaster: 'pusher',
      key: process.env.MIX_PUSHER_APP_KEY,
      wsHost: window.location.hostname,
      wsPort: 6001,
      forceTLS: false,
      encrypted: false,
      disableStats: true,
    })

    this.subscribeChannel(this.strSymbol)
  },

  methods: {
    ...mapActions('terminal', ['setPrice']),
    subscribeChannel(strSymbol) {
      let symbol = this.markets[strSymbol]
      let $store = this.$store
      this.echo.channel(`ticker.${symbol.id}`).listen('TickerUpdateEvent', e => {
        $store.dispatch('terminal/setPrice', e.symbol)
      })
      this.oldStrSymbol = strSymbol
    },
    unsubscribeChannel() {
      if (this.oldStrSymbol) {
        let symbol = this.markets[this.oldStrSymbol]
        this.echo.leave(`ticker.${symbol.id}`)
      }
    },
    setCurrentSymbolHandler: function() {},
  },
}
</script>
