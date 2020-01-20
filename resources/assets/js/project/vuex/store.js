import Vue from 'vue'
import Vuex from 'vuex'

import Contact from './modules/contacts/contacts'
import preloader from './modules/preloader/preloader'
import auth from './modules/auth/auth'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        contacts: Contact,
        preloader,
        auth,
    }
})