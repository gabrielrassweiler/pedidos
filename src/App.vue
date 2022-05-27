<template>
  <div id="nav">
    <router-link to="/" class="margin-18">INÍCIO</router-link>
    <router-link to="/basket" class="margin-18">CARRINHO ({{this.productsInBag.length}})</router-link>
    <router-link to="/pessoa" class="margin-18">PESSOA</router-link>
    <router-link to="/categoria" class="margin-18">CATEGORIA</router-link>
    <router-link to="/produto">PRODUTO</router-link>
  </div>
  <router-view/>
</template>

<script>

import { mapState } from 'vuex'
export default {
  created() {
    this.$store.dispatch('loadProducts');
    this.$store.dispatch('loadBag');
  },
  computed: mapState([
    'productsInBag'
  ]),
}
</script>


<style lang="scss">
#app {
  font-family: 'Montserrat', sans-serif;
  color: #2c3e50;
  max-width: 1280px;
  margin: 80px auto;
}

.margin-18 {
  margin-right: 18px
}

#nav {
  padding: 16px 0;
  position: fixed;
  z-index: 1;
  top: 0;
  left: 0;
  width: 100%;
  text-align: center;
  background-color: rgb(37, 37, 37);
  color: white;
  font-size: .88em;

  a {
    color: white;
    text-decoration: none;
    transition: color .15s;

    &.router-link-exact-active {
      color: #007bff;
    }
  }
  a:hover {
    color: #3395ff;
  }
}
</style>
