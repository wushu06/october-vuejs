import Vue from 'vue'
import './plugins/vuetify'
import App from './App.vue'
import router from './router'
import store from './store'
import Vuetify from 'vuetify'
import 'vue-datetime/dist/vue-datetime.css';

Vue.use(Vuetify)
import 'vuetify/dist/vuetify.min.css'
import './assets/app.scss'


Vue.config.productionTip = false

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
