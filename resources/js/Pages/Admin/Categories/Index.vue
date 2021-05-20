<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Categories</h1>
    <div class="mb-6 flex justify-between items-center">
      <inertia-link class="btn-indigo" :href="route('categories.create')">
        <span>Create</span>
        <span class="hidden md:inline">Category</span>
      </inertia-link>
    </div>
    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('id')">ID</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('name')">Name</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="sortHanle('created_at')">Crated at</th>
        </tr>
        <tr v-for="category in categories.data" :key="category.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center" :href="route('categories.edit', category.id)" tabindex="-1">
              {{ category.id }}
            </inertia-link>
          </td>

          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('categories.edit', category.id)">
              {{ category.name }}
              <icon v-if="category.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
          <td class="border-t">
            <inertia-link class="px-6 py-4 flex items-center focus:text-indigo-500" :href="route('categories.edit', category.id)">
              {{ category.created_at }}
              <icon v-if="category.deleted_at" name="trash" class="flex-shrink-0 w-3 h-3 fill-gray-400 ml-2" />
            </inertia-link>
          </td>
        </tr>
        <tr v-if="categories.data.length === 0">
          <td class="border-t px-6 py-4" colspan="4">No categories found.</td>
        </tr>
      </table>
    </div>
    <pagination class="mt-6" :links="categories.links" />
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'
//import pickBy from 'lodash/pickBy'
import Layout from '@/Shared/Layout'
//import throttle from 'lodash/throttle'
//import mapValues from 'lodash/mapValues'
import Pagination from '@/Shared/Pagination'
//import SearchFilter from '@/Shared/SearchFilter'

export default {
  metaInfo: { title: 'Categories' },
  components: {
    Icon,
    Pagination,
  },
  layout: Layout,
  props: {
    defaultDirection: String,
    categories: Object,
  },

  data() {
    return {}
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
