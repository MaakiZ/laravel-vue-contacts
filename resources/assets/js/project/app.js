// Recupera o arquivo com as configurações iniciais do projeto
require('./bootstrap')
window.Vue = require('vue')
import Snotify from 'vue-snotify'
import VueSwal from 'vue-swal'

import router from './routes/routers'
import store from './vuex/store'


Vue.use(Snotify, {toast: {showProgressBar: false}})
Vue.use(VueSwal)

/**
 * Cria os componentes globais
 */
Vue.component('preloader-component', require('./components/layouts/PreloaderComponent.vue').default);


// Instância do Vue JS, e seletor
const app = new Vue({
    router,
    store,
    el: '#app',
})


store.dispatch('checkLogin')
        .then(() => router.push({name: 'contacts'}))
        .catch((error) => router.push({name: 'auth'}))
