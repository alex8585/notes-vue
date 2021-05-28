import Vue from 'vue'
import PortalVue from 'portal-vue'
import { App, plugin } from '@inertiajs/inertia-vue'
import { InertiaProgress } from '@inertiajs/progress/src'
import store from './store'
import './register-components.js'
import VuejsClipper from 'vuejs-clipper/dist/vuejs-clipper.umd'
import 'vuejs-clipper/dist/vuejs-clipper.css'
import VueRx from 'vue-rx'
import vuetify from '@/vuetify'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'
declare const route:any;
InertiaProgress.init()

const el = document.getElementById('app')
//el.setAttribute('data-app', true)
const vm = new Vue({
  vuetify,
  
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

Vue.mixin({ methods: { route: route } })
Vue.use(plugin)
Vue.use(PortalVue)
//Vue.use(store)
Vue.use(require('vue-moment'))
Vue.use(VueRx)
Vue.use(Vuetify)

//window.__VUE_DEVTOOLS_GLOBAL_HOOK__.Vue = vm.constructor
Vue.config.devtools = process.env.NODE_ENV === 'development'
Vue.use(VuejsClipper, {
  components: {
    clipperBasic: true,
    clipperPreview: true,
  },
})
