<template>
  <div :class="{ unselectable: isUnselectable }">
    <Modal v-if="showModal" :x="150" @close="showModal = false" @dragEnd="isUnselectable = false" @dragStart="isUnselectable = true">
      <h3 slot="header">custom header</h3>
    </Modal>

    <h1 class="mb-8 font-bold text-3xl">Categories</h1>
    <div class="mb-6 flex justify-between items-center">
      <button class="btn-indigo" @click="showModal = true">
        <span>Create</span>
        <span class="hidden md:inline">Note</span>
      </button>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('id')">ID</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('title')">Title</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('created_at')">Crated at</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('category')">Category</th>
        </tr>
        <tr v-for="item in items.data" :key="item.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.id }}</div>
          </td>

          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.title }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.created_at }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.cat_name }}</div>
          </td>
        </tr>
        <tr v-if="items.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No notes found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="items.links" />
  </div>
</template>

<script>
//import Icon from '@/Shared/Icon'
//import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
//import throttle from 'lodash/throttle'
//import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
import Modal from '@/Shared/Modal'
//import SearchFilter from '@/Shared/SearchFilter'

import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
import VueDraggableResizable from 'vue-draggable-resizable'
import 'vue-draggable-resizable/dist/VueDraggableResizable.css'
export default {
  metaInfo: { title: 'Categories' },
  components: {
    VueDraggableResizable,
    Pagination,
    Modal,
  },
  layout: Layout,
  props: {
    defaultDirection: String,
    categories: Array,
    items: Object,
  },

  data() {
    return {
      isUnselectable: false,
      showModal: false,
      dialog: null,
      enabled: true,
      list: [
        { name: 'John', id: 0 },
        { name: 'Joao', id: 1 },
        { name: 'Jean', id: 2 },
      ],
      dragging: true,
    }
  },

  mounted: function() {
    //console.log(this.contacts.data)
  },
  methods: {
    getUrlQuery(param = null) {
      let url = new URL(window.location.href)
      if (param) {
        return url.searchParams.get(param)
      }

      let params = {}
      url.searchParams.forEach((v, k) => (params[k] = v))
      return params
    },

    sortHanle(sort) {
      let query = this.getUrlQuery()

      let direction = query.direction ? query.direction : this.defaultDirection

      direction = direction == 'asc' ? 'desc' : 'asc'

      query = { ...query, direction, sort }

      this.$inertia.get(route(route().current()), query, {
        //preserveScroll: true,
        replace: true,
        preserveState: true,
      })
    },
  },
}
</script>
<style scoped>
.unselectable {
  -webkit-touch-callout: none; /* iOS Safari */
  -webkit-user-select: none; /* Chrome/Safari/Opera */
  -khtml-user-select: none; /* Konqueror */
  -moz-user-select: none; /* Firefox */
  -ms-user-select: none; /* Internet Explorer/Edge */
  user-select: none; /* Non-prefixed version, currently
                                  not supported by any browser */
}
</style>
