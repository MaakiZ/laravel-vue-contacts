<template>
    <div class="container">
        <h1>Editar Contato <b>{{contact.name}}</b></h1>

        <form-contact-component
            :contact="contact"
            :update="true">
        </form-contact-component>
    </div>
</template>

<script>
import FormContactComponent from './partials/FormContactComponent'

export default {
    props: {
        id: {
            require: true
        }
    },
    created () {
        this.$store.dispatch('loadContact', this.id)
                        .then(response => this.contact = response)
                        .catch(error => {
                            this.$snotify.error('Erro ao carregar contato', 'Erro')
                        })
    },
    data () {
        return {
            contact: {}
        }
    },
    components: {
        FormContactComponent
    }
}
</script>
