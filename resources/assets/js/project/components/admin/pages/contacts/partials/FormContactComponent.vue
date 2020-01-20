<template>
    <div>
      <form @submit.prevent="onSubmit">
        <div :class="['form-group', {'has-error': errors.image}]">
            <picture-input
                ref="pictureInput"
                @change="onChanged"
                @remove="onRemoved"
                :width="200"
                :removable="true"
                removeButtonClass="btn btn-danger"
                :height="200"
                accept="image/jpeg, image/png, image/gif"
                buttonClass="btn btn-primary"
                :customStrings="{
                upload: '<h1>Upload</h1>',
                drag: 'Clique ou arraste aqui'}">
            </picture-input>
            <div v-if="errors.image" class="help-block">
                <p>{{ errors.image[0] }}</p>
            </div>
        </div>

        <div :class="['form-group', {'has-error': errors.name}]">
            <input type="text" class="form-control" placeholder="Nome do contato" v-model="contact.name">
            <div v-if="errors.name" class="help-block">
                <p>{{ errors.name[0] }}</p>
            </div>
        </div>

        <div :class="['form-group', {'has-error': errors.email}]">
            <input type="text" class="form-control" placeholder="Email" v-model="contact.email">
            <div v-if="errors.email" class="help-block">
                <p>{{ errors.email[0] }}</p>
            </div>
        </div>

         <div :class="['form-group', {'has-error': errors.telefone}]">
            <input type="text" class="form-control" placeholder="Telefone" v-model="contact.telefone">
            <div v-if="errors.telefone" class="help-block">
                <p>{{ errors.telefone[0] }}</p>
            </div>
        </div>

        <div :class="['form-group', {'has-error': errors.site}]">
            <input type="text" class="form-control" placeholder="Site" v-model="contact.site">
            <div v-if="errors.site" class="help-block">
                <p>{{ errors.site[0] }}</p>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
  </div>
</template>

<script>
import PictureInput from 'vue-picture-input'

export default {
    props: {
        update: {
            require: false,
            type: Boolean,
            default: false
        },
        contact: {
            require: false,
            type: Array|Object,
            default: () => {
                return {
                    id: '',
                    name: '',
                    email: '',
                    telefone: '',
                    site: '',
                    image: '',
                }
            }
        }
    },
    data () {
        return {
            errors: {},
            imagePreview: null,
            upload: null,
        }
    },
    methods: {
        onChanged() {
            console.log("New picture loaded");
            if (this.$refs.pictureInput.file) {
                this.upload = this.$refs.pictureInput.file;
            } else {
                console.log("Old browser. No support for Filereader API");
            }
        },
        onRemoved() {
            this.upload = null;
        },
        onSubmit () {
            const action = this.update ? 'editContact' : 'addContact'

            const formData = new FormData()
            if (this.upload != null)
                formData.append('image', this.upload)
            
            formData.append('id', this.contact.id)
            formData.append('name', this.contact.name)
            formData.append('email', this.contact.email)
            formData.append('telefone', this.contact.telefone)
            formData.append('site', this.contact.site)

            return this.$store.dispatch(action, formData)
                        .then(() => {
                            this.$snotify.success('Sucesso ao salvar o registro')

                            this.$router.push({name: 'contacts'})
                        })
                        .catch(errors => {
                            this.$snotify.error('Algo errado...', 'Erro')

                            this.errors = errors.hasOwnProperty('errors') ? errors.errors : errors
                        })
        }
    },
    components: {
        PictureInput
    }
}
</script>

<style>
form{
    margin: 10px 0;
}
.img-responsive{max-width: 60px;}
</style>
