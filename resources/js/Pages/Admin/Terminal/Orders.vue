<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Orders</h1>
    <div class="my-7">
      <inertia-link class="btn-indigo " :href="route('terminal.orders')" :data="{ status: 'active' }">Active</inertia-link>
      <inertia-link class="btn-indigo " :href="route('terminal.orders')" :data="{ status: 'closed' }">Closed</inertia-link>
    </div>

    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'symbol', defaultDirection })">Symbol</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'direction', defaultDirection })">Side</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'quantity', defaultDirection })">Amount</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'cost', defaultDirection })">Cost ($)</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'price', defaultDirection })">Price ($)</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'stop1', defaultDirection })">Stop1</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'stop1_price', defaultDirection })">Stop1 price</th>
          <!-- <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'take', defaultDirection })">Take</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'take_price', defaultDirection })">Take price</th> -->

          <th v-if="status == 'closed'" class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'sell_price', defaultDirection })">Sell price</th>
          <th v-if="status == 'closed'" class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'result', defaultDirection })">Result</th>
          <th v-if="status == 'closed'" class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'result_percent', defaultDirection })">Percent</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('terminal/sortHanle', { sort: 'created_at', defaultDirection })">Time</th>
          <th v-if="status == 'active'" class="px-6 pt-6 pb-4 ">Actions</th>
        </tr>
        <tr v-for="item in items.data" :key="item.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.symbol }}</div>
          </td>

          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.side }}</div>
          </td>

          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.amount }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.cost }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.price }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.stop1 }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.stop1_price }}</div>
          </td>
          <!-- <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.take }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.take_price }}</div>
          </td> -->
          <td v-if="status == 'closed'" class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.sell_price }}</div>
          </td>
          <td v-if="status == 'closed'" class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.result }}</div>
          </td>
          <td v-if="status == 'closed'" class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.result_percent ? parseFloat(item.result_percent).toFixed(2) : '' }}</div>
          </td>

          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.created_at }}</div>
          </td>
          <td v-if="status == 'active'" class="border-t">
            <inertia-link as="button" class="btn-indigo " method="delete" :href="route('terminal.close-order', item.id)">Close</inertia-link>
            <!-- <button class="btn-indigo" @click.prevent="$store.dispatch('notes/editNote', item)">Close</button> -->
          </td>
        </tr>
        <tr v-if="items.data.length === 0">
          <td class="border-t px-6 py-4" colspan="12">No notes found.</td>
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
    status: String,
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
