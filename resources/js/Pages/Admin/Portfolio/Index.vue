<template>
  <div :class="{ unselectable: isUnselectable }">
    <Modal v-if="showModalCreate" :x="150" :y="100" @close="$store.dispatch('portfolio/setShowModalCreate', false)" @dragEnd="$store.dispatch('portfolio/setUnselectable', false)" @dragStart="$store.dispatch('portfolio/setUnselectable', true)">
      <h3 slot="header" class="p-8 -mr-6 -mb-8 flex flex-wrap">Create Portfolio</h3>

      <form slot="body">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.title" :error="form.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />

          <div class="pr-6 pb-8 w-full">
            <file-input v-model="form.img" :error="form.errors.img" type="file" accept="image/*" label="Img" />
          </div>
          <!-- <text-input v-model="form.body" :error="form.errors.body" class="pr-6 pb-8 w-full lg:w-1/2" label="Body" /> -->
          <div class="pr-6 pb-8 w-full">
            <text-input v-model="form.url" :error="form.errors.url" class="pr-6 pb-8 w-full lg:w-1/2" label="Url" />
          </div>

          <div class="pr-6 pb-8 w-full">
            <div>Tags</div>
            <v-autocomplete v-model="form.tags" :items="tags" outlined dense chips small-chips label="" multiple />
          </div>

          <div class="pr-6 pb-8 w-full">
            <vue-editor v-model="form.description" label="Body" :class="{ error: form.errors.description }" />
            <div v-if="form.errors.description" class="form-error">{{ form.errors.description }}</div>
          </div>
        </div>
      </form>
      <div slot="footer">
        <button class="btn-indigo" type="submit" @click.prevent="store">Create Portfolio</button>
        <button class="btn-close" @click="$store.dispatch('portfolio/setShowModalCreate', false)">
          Close
        </button>
      </div>
    </Modal>

    <Modal v-if="showModalEdit" :x="150" :y="100" @close="$store.dispatch('portfolio/setShowModalEdit', false)" @dragEnd="$store.dispatch('portfolio/setUnselectable', false)" @dragStart="$store.dispatch('portfolio/setUnselectable', true)">
      <h3 slot="header" class="p-8 -mr-6 -mb-8 flex flex-wrap">Edit Portfolio</h3>

      <form slot="body">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="editForm.title" :error="editForm.errors.title" class="pr-6 pb-8 w-full lg:w-1/2" label="Title" />

          <div class="pr-6 pb-8 w-full">
            <file-input v-model="editForm.img" :error="editForm.errors.img" type="file" accept="image/*" label="Img" />
          </div>
          <div class="pr-6 pb-8 w-full">
            <text-input v-model="editForm.url" :error="editForm.errors.url" class="pr-6 pb-8 w-full lg:w-1/2" label="Url" />
          </div>

          <div class="pr-6 pb-8 w-full">
            <div>Tags</div>
            <v-autocomplete v-model="editForm.tags" :items="tags" outlined dense chips small-chips label="" multiple />
          </div>

          <div class="pr-6 pb-8 w-full">
            <vue-editor v-model="editForm.description" label="Body" :class="{ error: editForm.errors.description }" />
            <div v-if="editForm.errors.description" class="form-error">{{ editForm.errors.description }}</div>
          </div>
          <!-- <img :src="imgUrl" /> -->
          <!-- <text-input v-model="form.body" :error="form.errors.body" class="pr-6 pb-8 w-full lg:w-1/2" label="Body" /> -->
        </div>
      </form>
      <div slot="footer">
        <button class="btn-indigo" @click.prevent="update">Save Portfolio</button>
        <button class="btn-close" @click="$store.dispatch('portfolio/setShowModalEdit', false)">
          Close
        </button>
      </div>
    </Modal>

    <v-dialog class="delete-dialog " v-model="showDeleteDialog" persistent max-width="290">
      <v-card>
        <v-card-title class="headline">Delete confirmation </v-card-title>
        <v-card-text>Are you sure you want to delete portfolio "{{ deleteDialogItem ? deleteDialogItem.title : '' }}" ?</v-card-text>
        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn depressed text color="green darken-1" @click="$store.dispatch('portfolio/setDeleteDialog', false)">
            Cancel
          </v-btn>
          <v-btn depressed text color="red darken-1" @click="$store.dispatch('portfolio/delete', deleteDialogItem)">
            Delete
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>

    <h1 class="mb-8 font-bold text-3xl">Categories</h1>

    <!-- <div>{{ new Date() | moment('YYYY') }}</div> -->
    <div class="mb-6 flex justify-between items-center">
      <button class="btn-indigo" @click="$store.dispatch('portfolio/setShowModalCreate', true)">
        <span>Create</span>
        <span class="hidden md:inline">Portfolio </span>
      </button>
    </div>

    <div class="bg-white rounded-md shadow overflow-x-auto">
      <table class="w-full whitespace-nowrap">
        <tr class="text-left font-bold">
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('portfolio/sortHanle', { sort: 'id', defaultDirection })">ID</th>
          <th class="px-6 pt-6 pb-4 ">Img</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('portfolio/sortHanle', { sort: 'title', defaultDirection })">Title</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('portfolio/sortHanle', { sort: 'url', defaultDirection })">Url</th>
          <th class="px-6 pt-6 pb-4 cursor-pointer" @click="$store.dispatch('portfolio/sortHanle', { sort: 'created_at', defaultDirection })">Crated at</th>

          <th class="px-6 pt-6 pb-4 ">Actions</th>
        </tr>
        <tr v-for="item in items.data" :key="item.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.id }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">
              <img :src="item.imgUrl" />
            </div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.title }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.url }}</div>
          </td>
          <td class="border-t">
            <div class="px-6 py-4 flex items-center focus:text-indigo-500">{{ item.created_at }}</div>
          </td>

          <td class="border-t">
            <!-- <button class="btn-indigo" @click.prevent="$store.dispatch('portfolio/editPortfolio', item)">Edit</button> -->
            <v-btn depressed color="primary" @click.prevent="$store.dispatch('portfolio/editPortfolio', item)">
              Edit
            </v-btn>
            <v-btn depressed color="error" @click.prevent="$store.dispatch('portfolio/setDeleteDialogItem', item)">
              Delete
            </v-btn>
            <!-- <button class="btn-indigo" @click.prevent="$store.dispatch('portfolio/setDeleteDialogTxt', item)">Delete</button> -->
          </td>
        </tr>
        <tr v-if="items.data.length === 0">
          <td class="border-t px-6 py-4" colspan="5">No portfolio found.</td>
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

//import SearchFilter from '@/Shared/SearchFilter'
export default {
  metaInfo: { title: 'Portfolio' },
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
    tags: Array,
  },

  data() {
    return {
      deleteDialog: false,
    }
  },
  computed: mapGetters('portfolio', ['deleteDialogItem', 'imgUrl', 'showDeleteDialog', 'form', 'editForm', 'filterForm', 'showModalEdit', 'isUnselectable', 'showModalCreate']),
  mounted: function() {},
  methods: {
    ...mapActions('portfolio', ['store', 'update', 'setShowModalCreate', 'setUnselectable', 'setShowModalEdit', 'editPortfolio ', 'filterChange', 'sortHanle']),

    categoriesChange(v) {
      this.form.category_id = v
    },
    categoriesEditChange(v) {
      this.editForm.category_id = v
    },
  },
}
</script>
<style>
.theme--light.v-card .v-card__subtitle,
.theme--light.v-card > .v-card__text {
  color: rgba(241, 14, 14, 0.6);
}
.delete-dialog .v-card__subtitle,
.v-card__text {
  font-size: 16px;
  font-weight: 800;
}
.green--text.text--darken-1 {
  color: #43a047 !important;
  caret-color: #43a047 !important;
  font-weight: 600;
}
.red--text.text--darken-1 {
  color: #e62a11 !important;
  caret-color: #e62a11 !important;
  font-weight: 600;
}
</style>
