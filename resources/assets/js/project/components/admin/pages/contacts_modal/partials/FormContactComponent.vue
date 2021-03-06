<template>
    <div>
      <form @submit.prevent="onSubmit">
        <div :class="['form-group', {'has-error': errors.image}]">
            <div v-if="!imagePreview">
                <input
                    type="file"
                    ref="picture"
                    class="form-control"
                    @change="onFileChange"
                    accept="image/*">
            </div>
            <div v-else class="text-center">
                <img :src="imagePreview" class="img-responsive">
                <button @click.prevent="removeImage" class="btn btn-danger">Remover Imagem</button>
            </div>
            <div v-if="errors.image" class="help-block">
                <p>{{ errors.image[0] }}</p>
            </div>
        </div>

        <div :class="['form-group', {'has-error': errors.name}]">
            <input type="text" class="form-control" placeholder="Nome" v-model="contact.name">
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
    mounted () {
        this.reset()
    },
    props: {
        update: {
            require: false,
            type: Boolean,
            default: false
        },
        contact: {
            require: false,
            type: Object
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
        onFileChange (e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length)
                return

            this.upload = files[0]
            this.createImage(files[0])
        },
        createImage (file) {
            let reader = new FileReader()
            reader.onload = (e) => {
                this.imagePreview = e.target.result
            }
            reader.readAsDataURL(file)
        },
        removeImage () {
            this.imagePreview = null,
            this.upload = null
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
                            this.$swal('Sucesso', 'Operação realizada com sucesso!', 'success')

                            this.$emit('success')

                            this.errors = {}
                            this.upload = null
                            this.imagePreview = null
                        })
                        .catch(errors => {
                            this.$snotify.error('Algo errado...')

                            this.errors = errors.hasOwnProperty('errors') ? errors.errors : errors
                        })
        },
        reset () {
            console.log('Form reset')
            this.errors = {}
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
