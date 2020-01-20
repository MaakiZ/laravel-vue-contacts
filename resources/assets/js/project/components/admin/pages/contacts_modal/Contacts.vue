<template>
    <div class="container">
        <h1>Contatos <span v-if="contacts.total > 0">({{ contacts.total }})</span></h1>

        <div class="row options">
            <div class="col">
                <a ref="modal" @click.prevent="create" class="btn btn-success">
                    Adicionar
                </a>
            </div>

            <div class="col">
                <search @search="searchContact"></search>

                <div v-if="search">
                    Resultados da pesquisa: {{ search }}
                </div>
            </div>
        </div>

        <table class="table table-white">
            <tr>
                <th width="100">Imagem</th>
                <th>Nome</th>
                <th>Email</th>
                <th>Telefone</th>
                <th>Site</th>
                <th width="200">Ações</th>
            </tr>
            <tr v-for="(contact, key) in contacts.data" :key="key">
                <td>
                  <div v-if="contact.image">
                    <img :src="[`/storage/contacts/${contact.image}`]" :alt="contact.name" class="img-list">
                  </div>
                </td>
                <td v-text="contact.name"></td>
                 <td v-text="contact.email"></td>
                  <td v-text="contact.telefone"></td>
                   <td v-text="contact.site"></td>
                <td>
                    <a href="#" @click.prevent="edit(contact.id)" class="btn btn-info">
                        Editar
                    </a>
                    <a href="#" @click.prevent="confirmDelete(contact)" class="btn btn-danger">Deletar</a>
                </td>
            </tr>
        </table>

        <vodal :show="showModal" animation="zoom" @hide="hide" :width="600" :height="500">
            <form-contact
                :contact="contact"
                :update="update"
                @success="success">
            </form-contact>
        </vodal>

        <paginate
            :pagination="contacts"
            :offset="3"
            @paginate="loadContacts"></paginate>

    </div>
</template>

<script>
import Vodal from 'vodal'

import SearchContactComponent from './partials/SearchContactComponent'
import PaginationComponent from '../../../layouts/PaginationComponent'
import FormContactComponent from './partials/FormContactComponent'

export default {
    name: 'contact-component',
    created () {
      this.loadContacts()
    },
    data () {
        return {
            search: null,
            contactId: null,
            showModal: false,
            contact: {
                id: '',
                name: '',
                email: '',
                telefone: '',
                site: '',
                image: '',
            },
            update: false,
        }
    },
    computed: {
      contacts () {
          return this.$store.state.contacts.items
      },
      params () {
          return {
              page: this.contacts.current_page,
              filter: this.search,
          }
      }
    },
    methods: {
        loadContacts (page = 1) {
            this.$store.dispatch('loadContacts', {...this.params, page})
        },
        edit (id) {
            this.reset()

            this.$store.dispatch('loadContact', id)
                        .then(response => {
                            this.contact = response
                            this.showModal = true
                            this.update = true
                        })
                        .catch(error => this.$snotify.error('Erro ao carregar contato'))
        },
        searchContact (search) {
            this.search = search
            this.loadContacts()
        },
        confirmDelete (contact) {
            this.contactId = contact.id

            this.$snotify.error(`Deseja realmente deletar o contato: ${contact.name}`, contact.name, {
                timeout: 10000,
                showProgressBar: true,
                closeOnClick: true,
                pauseOnHover: true,
                buttons: [
                    {text: 'Não', action: () => console.log('Clicked: No')},
                    {text: 'Sim', action: () => this.destroy(), bold: false},
                ]
            })
        },
        destroy () {
            this.$store.dispatch('destroyContact', this.contactId)
                            .then(() => {
                                this.contactId = null
                                this.loadContacts()
                            })
        },
        create () {
            this.reset()
            this.update = false
            this.showModal = true
        },
        hide () {
            this.showModal = false
        },
        success () {
            this.reset()
            this.loadContacts()
            this.hide()
        },
        reset () {
            this.contact = {
                id: '',
                name: '',
                email: '',
                telefone: '',
                site: '',
                image: '',
            }
        }
    },
    components: {
        search: SearchContactComponent,
        paginate: PaginationComponent,
        formContact: FormContactComponent,
        Vodal,
    }
}
</script>


<style scoped>
.img-list{max-width: 50px;}
.options{margin: 20px 0;}
.vodal-dialog{height: auto; max-width: 90%;}
</style>
