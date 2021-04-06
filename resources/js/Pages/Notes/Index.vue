<template>
  <div :class="{ unselectable: isUnselectable }">
    <Modal v-if="showModalCreate" :x="150" :y="100" @close="showModalCreate = false" @dragEnd="isUnselectable = false" @dragStart="isUnselectable = true">
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
        <button class="btn-indigo" :loading="form.processing" type="submit" @click.prevent="store">Create Note</button>
        <button class="btn-close" @click="showModalCreate = false">
          Close
        </button>
      </div>
    </Modal>

    <Modal v-if="showModalCreateEdit" :x="150" :y="100" @close="showModalCreateEdit = false" @dragEnd="isUnselectable = false" @dragStart="isUnselectable = true">
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
        <button class="btn-indigo" :loading="form.processing" @click.prevent="update">Save Note</button>
        <button class="btn-close" @click="showModalCreateEdit = false">
          Close
        </button>
      </div>
    </Modal>

    <h1 class="mb-8 font-bold text-3xl">Categories</h1>
    <div class="mb-6 flex justify-between items-center">
      <button class="btn-indigo" @click="showModalCreate = true">
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
            <button class="btn-indigo" @click.prevent="editNote(item)">Edit Note</button>
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
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'
import SelectInput from '@/Shared/SelectInput'
import { VueEditor } from 'vue2-editor'
import pickBy from 'lodash/pickBy'
export default {
  metaInfo: { title: 'Categories' },
  components: {
    VueEditor,
    SelectInput,
    LoadingButton,
    TextInput,
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
      editForm: this.$inertia.form({
        title: null,
        category_id: null,
        body: null,
      }),
      form: this.$inertia.form({
        title: null,
        category_id: null,
        body: null,
      }),
      isUnselectable: false,
      showModalCreate: false,
      showModalCreateEdit: false,
    }
  },

  mounted: function() {
    //console.log(this.contacts.data)
  },
  methods: {
    editNote(item) {
      this.showModalCreateEdit = false
      //this.editForm = pickBy(item)
      //this.editForm = item
      this.editForm = { ...this.editForm, ...item }
      this.showModalCreateEdit = true
    },
    categoriesChange(v) {
      this.form.category_id = v
    },
    categoriesEditChange(v) {
      this.editForm.category_id = v
    },
    store() {
      this.form.post(this.route('notes.store'), {
        replace: true,
        preserveState: true,
        onSuccess: () => {
          this.form.reset()
        },
      })
    },
    update() {
      this.editForm.put(this.route('notes.update', this.editForm.id), {
        replace: true,
        preserveState: true,
        onSuccess: () => {
          this.showModalCreateEdit = false
        },
      })
    },
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
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -khtml-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
</style>
