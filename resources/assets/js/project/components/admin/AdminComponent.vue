<template>
  <div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <ul class="nav navbar-nav navbar-right">
          <router-link class="nav-link" :to="{name: 'contacts'}">Contatos</router-link>
        </ul>

        <div v-if="me.name">
          <div class="dropdown">
            <a class="dropdown-toggle color-white" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ me.name }}
            </a>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
              <a class="dropdown-item" href="#" @click.prevent="logout">Sair</a>
            </div>
          </div><!--dropdown-->
        </div>
      </div>
    </nav>

    <div class="spacing-custon">
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
export default {
  computed: {
    me () {
      return this.$store.state.auth.me
    }
  },
  methods: {
    logout () {
      this.$store.dispatch('logout')

      this.$snotify.success('Saindo da sessão', 'logout...')

      this.$router.push({name: 'auth'})
    }
  }
}
</script>

<style>
.router-link-exact-active {color: #4bd02a !important;}
.spacing-custon{padding: 40px 0;}
.color-white{color: #FFF !important;}
</style>
