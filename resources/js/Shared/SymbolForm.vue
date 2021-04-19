<template>
  <form>
    <div class="pt-8 -mr-0 -mb-8 flex flex-wrap">
      <select-input v-cloak v-model="symbolsForm.symbol" :error="symbolsForm.errors.symbol" class="pr-6 pb-8 w-full lg:w-1/3" label="Пара" @change="setCurrentSymbolHandler($event)">
        <option v-for="market in markets" :key="market.id" :value="market.symbol">{{ market.symbol }}</option>
      </select-input>
      <select-input v-cloak v-if="currentSymbol" v-model="symbolsForm.leverage" :error="symbolsForm.errors.leverage" class="pr-6 pb-8 w-full lg:w-1/3" label="Плечо" @change="$store.dispatch('terminal/setLeverage', $event)">
        <option v-for="l in currentSymbol.leverage" :key="l" :value="l">{{ l }}</option>
      </select-input>

      <!-- <div class="flex justify-end items-center pb-2">
          <loading-button :loading="symbolsForm.processing" class="btn-indigo " type="submit">Ok</loading-button>
        </div> -->
    </div>
  </form>
</template>

<script>
import SelectInput from '@/Shared/SelectInput'
import { mapGetters, mapActions } from 'vuex'
export default {
  components: {
    SelectInput,
  },
  props: {
    markets: Object,
  },
  data() {
    return {
      oldStrSymbol: null,
    }
  },
  computed: mapGetters('terminal', ['symbolsForm', 'currentSymbol']),

  mounted() {},

  methods: {
    ...mapActions('terminal', ['setPrice', 'setLeverage']),
    setCurrentSymbolHandler: function($event) {
      let symbol = this.markets[$event]
      this.$store.dispatch('terminal/setCurrentSymbol', symbol)
    },
  },
}
</script>
