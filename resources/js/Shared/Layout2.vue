<template>
  <div>
    <portal-target name="dropdown" slim />
    <div class="md:flex md:flex-col">
      <div class="md:h-screen md:flex md:flex-col">
        <div class="md:flex md:flex-grow md:overflow-hidden">
          <div class="md:flex-1 px-4 py-8 md:p-12 md:overflow-y-auto" scroll-region>
            <flash-messages />
            <div v-if="auth.user" class="bg-white border-b w-full p-4 md:py-0 md:px-12 text-sm md:text-md flex justify-between items-center">
              <div class="mt-1 mr-4">{{ auth.user.email }}</div>
              <dropdown class="mt-1" placement="bottom-end">
                <div class="flex items-center cursor-pointer select-none group">
                  <div class="text-gray-700 group-hover:text-indigo-600 focus:text-indigo-600 mr-1 whitespace-nowrap">
                    <span>{{ auth.user.first_name }}</span>
                    <span class="hidden md:inline">{{ auth.user.last_name }}</span>
                  </div>
                  <icon class="w-5 h-5 group-hover:fill-indigo-600 fill-gray-700 focus:fill-indigo-600" name="cheveron-down" />
                </div>
                <div slot="dropdown" class="mt-2 py-2 shadow-xl bg-white rounded text-sm">
                  <inertia-link class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('users.edit', auth.user.id)">My Profile</inertia-link>
                  <inertia-link class="block px-6 py-2 hover:bg-indigo-500 hover:text-white" :href="route('users')">Manage Users</inertia-link>
                  <inertia-link class="block px-6 py-2 hover:bg-indigo-500 hover:text-white w-full text-left" :href="route('logout')" method="post" as="button">Logout</inertia-link>
                </div>
              </dropdown>
            </div>
            <slot />
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Icon from '@/Shared/Icon'

import Dropdown from '@/Shared/Dropdown'

import FlashMessages from '@/Shared/FlashMessages'

export default {
  components: {
    Dropdown,
    FlashMessages,
    Icon,
  },
  data() {
    return {
      auth: this.$page.props.auth,
    }
  },
  mounted: function() {
    //console.log()
  },
}
</script>
