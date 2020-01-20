<template>
  <div>
      <form class="form form-inline" @submit.prevent="searchContacts">
          <input type="text" v-model="search" placeholder="Pesquisar" class="form-control mr-sm-2">

          <button type="submit" class="btn btn-outline-success">Pesquisar</button>
      </form>
  </div>
</template>


<script>
export default {
  data () {
      return {
          search: ''
      }
  },
  methods: {
      searchContacts () {
          this.$emit('search', this.search)
      }
  }
}
</script>
