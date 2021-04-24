<template>
  <div>
    <h1 class="mb-8 font-bold text-3xl">Settings</h1>
    <div class="flex flex-wrap ">
      <form class="lg:w-1/2">
        <div class="pt-8 -mr-0 -mb-8 flex flex-wrap ">
          <text-input v-model="settingsForm.binApiKey" :error="settingsForm.errors.binApiKey" class="pr-6 pb-8 w-full " label="Api Key" />
          <text-input v-model="settingsForm.binApiSecret" :error="settingsForm.errors.binApiSecret" class="pr-6 pb-8 w-full " label="Api Secret" />
          <div class="flex justify-end items-center pb-2">
            <button class="btn-indigo" type="submit" @click.prevent="sendForm">Сохранить</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import Layout from '@/Shared/Layout'
import TextInput from '@/Shared/TextInput'

export default {
  metaInfo: { title: 'Settings' },
  components: {
    TextInput,
  },
  layout: Layout,
  props: {
    binApiKey: String,
    binApiSecret: String,
  },

  data() {
    return {
      settingsForm: this.$inertia.form({
        binApiKey: this.binApiKey,
        binApiSecret: this.binApiSecret,
      }),
    }
  },

  methods: {
    sendForm: function() {
      this.settingsForm.post(route('terminal.save-settings'), {
        replace: false,
        preserveState: true,
        onSuccess: () => {},
      })
    },
  },
}
</script>
