<template>
  <div>
    <div>
      <h1 class="mb-8 font-bold text-3xl title">Cup Constructor</h1>
      <div style="text-align: center;">Use our constructor to create Cup and order it now!</div>
    </div>
    <div class="flex flex-wrap ">
      <div class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          1111
        </div>
      </div>

      <div class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          <form @submit.prevent="sendForm">
            <div class="p-8 -mr-6 -mb-8 flex flex-wrap">
              <file-input v-model="form.photo" :error="form.errors.photo" class="pr-6 pb-8 w-full lg:w-1/2" type="file" accept="image/*" label="Photo" />
            </div>
            <div class="px-8 py-4 bg-gray-50 border-t border-gray-100 flex items-center">
              <loading-button :loading="form.processing" class="btn-indigo ml-auto" type="submit">Update User</loading-button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {{ path }}
  </div>
</template>

<script>
import LoadingButton from '@/Shared/LoadingButton'
import Layout from '@/Shared/Layout2'
import FileInput from '@/Shared/FileInput'
export default {
  metaInfo: { title: 'Cup Constructor' },
  components: { FileInput, LoadingButton },
  layout: Layout,

  props: {
    path: String,
    categories: Object,
  },

  data() {
    return {
      form: this.$inertia.form({
        photo: null,
      }),
    }
  },

  mounted: function() {},

  methods: {
    sendForm() {
      this.form.post(this.route('cup-constructor.saveImage'), {
        onSuccess: r => {
          console.log(r)
        },
      })
    },
  },
}
</script>

<style scoped>
.title {
  flex: 1 100%;
  text-align: center;
  font-size: 40px;
  line-height: 45px;
}
</style>
