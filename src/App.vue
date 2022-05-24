<template>
  <div id="nav">
    <router-link to="/" style="margin-right: 20px">INÍCIO</router-link>
    <router-link to="/basket" style="margin-right: 18px">CARRINHO ({{this.productsInBag.length}})</router-link>
    <router-link to="/pessoa">PESSOA</router-link>
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
