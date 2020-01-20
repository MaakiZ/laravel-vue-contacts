<template>
    <div class="container">
        <h1>Contatos <span v-if="contacts.total > 0">({{ contacts.total }})</span></h1>

        <div class="row options">
            <div class="col">
                <router-link :to="{name: 'contact.add'}" class="btn btn-success">
                    Adicionar
                </router-link>
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
                <td>
                    <router-link :to="{name: 'contact.edit', params: {id: contact.id}}" class="btn btn-success">
                        Editar
                    </router-link>
                    <a href="#" @click.prevent="confirmDelete(contact)" class="btn btn-danger">Deletar</a>
                </td>
            </tr>
        </table>

        <paginate
            :pagination="contacts"
            :offset="3"
            @paginate="loadContacts"></paginate>


    </div>
</template>

<script>
import SearchContactComponent from './partials/SearchContactComponent'
import PaginationComponent from '../../../layouts/PaginationComponent'

export default {
    name: 'contact-component',
    created () {
      this.loadContacts()
    },
    data () {
        return {
            search: null,
            contactId: null,
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
        loadContacts (page) {
            this.$store.dispatch('loadContacts', {...this.params, page})
        },
        searchContacts (search) {
            this.search = search

            this.loadContacts(1)
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
                                this.loadContacts(1)
                            })
        }
    },
    components: {
        search: SearchContactComponent,
        paginate: PaginationComponent
    }
}
</script>


<style scoped>
.img-list{max-width: 50px;}
.options{margin: 20px 0;}
</style>
