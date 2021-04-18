<template>
  <div :class="{ unselectable: isUnselectable }">
    <Modal v-if="showModalCreate" :x="150" :y="100" @close="$store.dispatch('notes/setShowModalCreate', false)" @dragEnd="$store.dispatch('notes/setUnselectable', false)" @dragStart="$store.dispatch('notes/setUnselectable', true)">
      <h3 slot="header" class="p-8 -mr-6 -mb-8 flex flex-wrap">Create Note</h3>

      <form slot="body">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <select-input :value="form.category_id" :error="form.errors.category_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Category" @change="categoriesChange">
            <option :value="null" />
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select-input>
          <div class="pr-6 pb-8 w-full">
            <vue-editor v-model="form.body" label="Body" :class="{ error: form.errors.body }" />
            <div v-if="form.errors.body" class="form-error">{{ form.errors.body }}</div>
          </div>

          <!-- <text-input v-model="form.body" :error="form.errors.body" class="pr-6 pb-8 w-full lg:w-1/2" label="Body" /> -->
        </div>
      </form>
      <div slot="footer">
        <button class="btn-indigo" type="submit" @click.prevent="store">Create Note</button>
        <button class="btn-close" @click="$store.dispatch('notes/setShowModalCreate', false)">
          Close
        </button>
      </div>
    </Modal>

    <Modal v-if="showModalEdit" :x="150" :y="100" @close="$store.dispatch('notes/setShowModalEdit', false)" @dragEnd="$store.dispatch('notes/setUnselectable', false)" @dragStart="$store.dispatch('notes/setUnselectable', true)">
      <h3 slot="header" class="p-8 -mr-6 -mb-8 flex flex-wrap">Edit Note</h3>

      <form slot="body">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="editForm.title" :error="editForm.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />
          <select-input :value="editForm.category_id" :error="editForm.errors.category_id" class="pr-6 pb-8 w-full lg:w-1/2" label="Category" @change="categoriesEditChange">
            <option :value="null" />
            <option v-for="category in categories" :key="category.id" :value="category.id">{{ category.name }}</option>
          </select-input>
          <div class="pr-6 pb-8 w-full">
            <vue-editor v-model="editForm.body" label="Body" :class="{ error: editForm.errors.body }" />
            <div v-if="editForm.errors.body" class="form-error">{{ editForm.errors.body }}</div>
          </div>

          <!-- <text-input v-model="form.body" :error="form.errors.body" class="pr-6 pb-8 w-full lg:w-1/2" label="Body" /> -->
        </div>
      </form>
      <div slot="footer">
        <button class="btn-indigo" @click.prevent="update">Save Note</button>
        <button class="btn-close" @click="$store.dispatch('notes/setShowModalEdit', false)">
          Close
        </button>
      </div>
    </Modal>

    <h1 class="mb-8 font-bold text-3xl">Categories</h1>
    <!-- <div>{{ new Date() | moment('YYYY') }}</div> -->
    <div class="mb-6 flex justify-between items-center">
      <button class="btn-indigo" @click="$store.dispatch('notes/setShowModalCreate', true)">
        <span>Create</span>
        <span class="hidden md:inline">Note</span>
      </button>
      <search-filter v-model="filterForm.search" class="w-full max-w-md mr-4" @reset="$store.dispatch('notes/filterChange', 'reset')" @input="$store.dispatch('notes/filterChange')">
        <label class="block text-gray-700">Trashed:</label>
        <select v-model="filterForm.trashed" class="mt-1 w-full form-select" @change="$store.dispatch('notes/filterChange')">
          <option :value="null" />
          <option value="with">With Trashed</option>
          <option value="only">Only Trashed</option>
        </select>
      </search-filter>
    </div>

    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('notes/sortHanle', { sort: 'id', defaultDirection })">ID</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('notes/sortHanle', { sort: 'title', defaultDirection })">Title</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('notes/sortHanle', { sort: 'created_at', defaultDirection })">Crated at</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('notes/sortHanle', { sort: 'category', defaultDirection })">Category</th>
          <th class="px-6 pt-6 pb-4 ">Actions</th>
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
          <td class="border-t">
            <button class="btn-indigo" @click.prevent="$store.dispatch('notes/editNote', item)">Edit Note</button>
          </td>
        </tr>
        <tr v-if="items.data.length === 0">
          <td class="border-t px-6 py-4" colspan="5">No notes found.</td>
        </tr>
      </table>
    </div>

    <pagination class="mt-6" :links="items.links" />
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
//import Pagination from '@/Shared/Pagination'
//import Modal from '@/Shared/Modal'
//import TextInput from '@/Shared/TextInput'
import { mapGetters, mapActions } from 'vuex'
//import SelectInput from '@/Shared/SelectInput'
import { VueEditor } from 'vue2-editor'
import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')
//import SearchFilter from '@/Shared/SearchFilter'
export default {
  metaInfo: { title: 'Categories' },
  components: {
    VueEditor,
    //SelectInput,
    //TextInput,
    //Pagination,
    //Modal,
    //SearchFilter,
  },
  layout: Layout,
  props: {
    defaultDirection: String,
    categories: Array,
    items: Object,
  },

  data() {
    return {}
  },
  computed: mapGetters('notes', ['form', 'editForm', 'filterForm', 'showModalEdit', 'isUnselectable', 'showModalCreate']),
  mounted: function() {
    let echo = new Echo({
      broadcaster: 'pusher',
      key: '6673f5e00bb33e0a31c7',
      wsHost: window.location.hostname,
      wsPort: 6001,
      forceTLS: false,
      encrypted: false,
      disableStats: true,
    })
    echo.channel('chat').listen('TestEvent', e => {
      console.log(e)
    })
    console.log('22')
  },
  methods: {
    ...mapActions('notes', ['store', 'update', 'setShowModalCreate', 'setUnselectable', 'setShowModalEdit', 'editNote', 'filterChange', 'sortHanle']),

    categoriesChange(v) {
      this.form.category_id = v
    },
    categoriesEditChange(v) {
      this.editForm.category_id = v
    },
  },
}
</script>
<style scoped></style>
