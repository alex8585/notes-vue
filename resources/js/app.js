import Vue from 'vue'
//import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import store from './store'
import './register-components.js'

import Echo from 'laravel-echo'
window.Pusher = require('pusher-js')
//Vue.use(VueMeta)

InertiaProgress.init()

const el = document.getElementById('app')
window.echo = new Echo({
  broadcaster: 'pusher',
  key: '6673f5e00bb33e0a31c7',
  wsHost: window.location.hostname,
  wsPort: 6001,
  forceTLS: false,
  encrypted: false,
  disableStats: true,
})

const vm = new Vue({
  metaInfo: {
    titleTemplate: title => (title ? `${title} - Ping CRM` : 'Ping CRM'),
  },
  store,
  render: h =>
    h(App, {
      props: {
        initialPage: JSON.parse(el.dataset.page),
        resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
      },
    }),
}).$mount(el)

Vue.config.devtools = process.env.NODE_ENV === 'development'
Vue.config.productionTip = false

Vue.mixin({ methods: { route: window.route } })
Vue.use(plugin)
Vue.use(PortalVue)
Vue.use(store)
Vue.use(require('vue-moment'))

window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = vm.constructor
Vue.config.devtools = process.env.NODE_ENV === 'development'
