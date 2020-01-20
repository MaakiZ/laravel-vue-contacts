import AdminComponent from '../components/admin/AdminComponent'
import LoginComponent from '../components/admin/pages/auth/LoginComponent'
import Contacts from '../components/admin/pages/contacts_modal/Contacts'
import Page404 from '../components/frontend/pages/404/Page404'
import SiteComponent from '../components/frontend/SiteComponent'
import HomePageComponent from '../components/frontend/pages/home/HomePageComponent'

export default [
    /**
     * Rotas Site
     */
    {
        path: '/',
        component: SiteComponent,
        meta: {auth: false},
        children: [
            {path: '', component: HomePageComponent, name: 'home'},
        ]
    },


    /**
     * Rotas Admin
     */
    {path: '/entrar', component: LoginComponent, name: 'auth'},
    {
        path: '/admin',
        component: AdminComponent,
        meta: {auth: true},
        children: [
            {path: '', component: Contacts, name: 'contacts'},
        ]
    },

    // Rota 404
    {path: '*', component: Page404},
]