<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Orders</h1>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'symbol', defaultDirection })">Symbol</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'direction', defaultDirection })">Direction</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'quantity', defaultDirection })">Quantity</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'stop1', defaultDirection })">Stop1</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'stop1_price', defaultDirection })">Stop1 price</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'take', defaultDirection })">Take</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'take_price', defaultDirection })">Take price</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'created_at', defaultDirection })">Time</th>
          <th class="px-6 pt-6 pb-4 ">Actions</th>
        </tr>
        <tr v-for="item in items.data" :key="item.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.symbol }}</div>
          </td>

          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.direction }}</div>
          </td>

          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.quantity }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.stop1 }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.stop1_price }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.take }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.take_price }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.created_at }}</div>
          </td>
          <td class="border-t">
            <button class="btn-indigo" @click.prevent="$store.dispatch('notes/editNote', item)">Edit Note</button>
          </td>
        </tr>
        <tr v-if="items.data.length === 0">
          <td class="border-t px-6 py-4" colspan="5">No notes found.</td>
        </tr>
      </table>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import { mapGetters, mapActions } from 'vuex'

export default {
  metaInfo: { title: 'Terminal' },

  components: {},
  layout: Layout,
  props: {
    items: Object,
    defaultDirection: String,
  },

  data() {
    return {}
  },
  computed: {
    ...mapGetters('terminal', ['currentSymbol', 'symbolsForm', 'buyForm', 'sellForm', 'price']),
  },

  mounted: function() {},
  updated: function() {},
  created() {},
  methods: {
    ...mapActions('terminal', ['setCurrentSymbol', 'sendBuyForm', 'sendSellForm']),
  },
}
</script>
