import Vue from 'vue'
//import VueMeta from 'vue-meta'
import PortalVue from 'portal-vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import store from './store'
import './register-components.js'
//Vue.use(VueMeta)

InertiaProgress.init()

const el = document.getElementById('app')

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

window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = vm.constructor
Vue.config.devtools = process.env.NODE_ENV === 'development'
//var form = vm.$inertia.form
export const form = vm.$inertia.form

//console.log(vm.$inertia.form)
//window.form = vm.$inertia.form
//global.vm = vm
