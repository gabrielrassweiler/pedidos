import {createStore} from 'vuex'
import axios from 'axios'

export default createStore({
  state: {
    products: [],
    productsInBag: [],
    pessoas: [],
    categorias: [],
    produtos: [],
  },
  mutations: {
    loadProducts (state, products) {
      state.products = products;
    },
    loadBag (state, products) {
      state.productsInBag = products;
    },
    addToBag(state, product) {
      state.productsInBag.push(product);
      localStorage.setItem("productsInBag", JSON.stringify(state.productsInBag))
    },
    removeFromBag(state, productId) {
      state.productsInBag = state.productsInBag.filter(item => productId !== item.id);
      localStorage.setItem("productsInBag", JSON.stringify(state.productsInBag))
    },
    loadPerson (state, pessoas) {
      state.pessoas = pessoas;
    },
    loadCategory (state, categorias) {
      state.categorias = categorias;
    },
    loadProduct (state, produtos) {
      state.produtos = produtos;
    }
  },
  actions: {
    loadProducts({ commit }) {
      axios
        .get('https://fakestoreapi.com/products')
        .then(response => {
          commit('loadProducts', response.data);
        })
    },
    loadBag({ commit }) {
      if (localStorage.getItem("productsInBag")) {
        commit('loadBag', JSON.parse(localStorage.getItem("productsInBag")));
      }
    },
    addToBag({ commit }, product) {
      commit('addToBag', product);
    },
    removeFromBag({ commit }, productId) {
      if (confirm('Tem certeza que deseja remover o produto do carrinho?')) {
        commit('removeFromBag', productId);
      }
    },
    loadPerson({ commit }) {
      axios
        .get(process.env.VUE_APP_BASE_ROUTE + 'pessoa')
        .then(response => {
          commit('loadPerson', response.data);
        })
    },
    loadCategory({ commit }) {
      axios
        .get(process.env.VUE_APP_BASE_ROUTE + 'categoria')
        .then(response => {
          commit('loadCategory', response.data);
        })
    },
    loadProduct({ commit }) {
      axios
        .get(process.env.VUE_APP_BASE_ROUTE + 'produto')
        .then(response => {
          commit('loadProduct', response.data);
        })
    }
  }
})
