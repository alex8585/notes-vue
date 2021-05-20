<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">
      <inertia-link class="text-indigo-400 hover:text-indigo-600" :href="route('categories')">Categories</inertia-link>
      <span class="text-indigo-400 font-medium">/</span>
      {{ form.name }}
    </h1>

    <div class="bg-white rounded-md shadow overflow-hidden max-w-3xl">
      <form @submit.prevent="update">
        <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
          <text-input v-model="form.name" :error="form.errors.name" class="pr-6 pb-8 w-full lg:w-1/2" label="First name" />
        </div>
        <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
          <button class="text-red-600 hover:underline" tabindex="-1" type="button" @click="destroy">Delete Category</button>
          <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update Category</loading-button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'
import LoadingButton from '@/Shared/LoadingButton'

export default {
  metaInfo() {
    return {
      title: `${this.form.name} `,
    }
  },
  components: {
    LoadingButton,
    TextInput,
  },
  layout: Layout,
  props: {
    category: Object,
  },
  remember: 'form',
  data() {
    return {
      form: this.$inertia.form({
        name: this.category.name,
      }),
    }
  },
  methods: {
    update() {
      this.form.put(this.route('categories.update', this.category.id))
    },
    destroy() {
      if (confirm('Are you sure you want to delete this contact?')) {
        this.$inertia.delete(this.route('categories.destroy', this.category.id))
      }
    },
  },
}
</script>
