import Vue from 'vue'
import Vuetify from 'vuetify/lib'

//import colors from 'vuetify/lib/util/colors'
import '@mdi/font/css/materialdesignicons.css'
Vue.use(Vuetify)

export default new Vuetify({
  iconfont: 'mdi', // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4' || 'faSvg'
})
