<template>
  <div class="col-md-12">
    <a
      type="button"
      class="btn btn-secondary mb-4"
      href="/cadastra-produto"
    >Cadastrar
    </a>
  </div>

  <div class="col-md-12">
    <div class="row header">
      <div class="col-1">ID</div>
      <div class="col-3">Categoria</div>
      <div class="col-3">Título</div>
      <div class="col-2">Descrição</div>
      <div class="col-1">Valor</div>
      <div class="col-1"></div>
      <div class="col-1"></div>
    </div>
    <div class="row" v-for="produto in produtos" :key="produto.id">
      <div class="col-1 mt-2">{{ produto.id }}</div>
      <div class="col-3 mt-2">{{ produto.categoria }}</div>
      <div class="col-3 mt-2">{{ produto.titulo }}</div>
      <div class="col-2 mt-2">{{ produto.descricao }}</div>
      <div class="col-1 mt-2">{{ produto.valor }}</div>
      <div class="col-1 mt-2 color-green">
        <a
          href="/altera-produto"
          @click="alteraProduto(this.produtos.filter(product => product.id === produto.id)[0])"
        >Alterar
        </a>
      </div>
      <div
        class="col-1 mt-2 color-red"
        @click="removeProduto(produto.id)"
      >Remover
      </div>
    </div>
  </div>
</template>

<script>
  import { mapState } from 'vuex'
  import axios from "axios";

  export default {
    // eslint-disable-next-line vue/multi-word-component-names
    name: 'Produto',
    created() {
      this.$store.dispatch('loadProduct');
    },
    computed: mapState([
      'produtos'
    ]),
    methods: {
      async removeProduto(produtoID) {
        if (confirm('Deseja remover a produto de ID ' + produtoID + ' ?')) {
          axios
            .get(process.env.VUE_APP_BASE_ROUTE + 'produto/remover/' + produtoID)
            .then(response => {
              console.log(response)
            })
        }
      },
      async alteraProduto(produto) {
        localStorage.setItem('alteraProduto', JSON.stringify(produto));
      }
    }
  }
</script>

<style lang="scss" scoped>
.header {
  background-color: #f2f2f2;
  border: 2px solid lightgray;
}

.col-1, .col-2, .col-3 {
  text-align: center;
  border-bottom: 1px solid lightgray;
}

.color-green {
  a {
    color: green;
    text-decoration: none;
  }
}
.color-green:hover {
  a {
    cursor: pointer;
    color: #659252;
  }
}

.color-red {
  color: red;
}
.color-red:hover {
  cursor: pointer;
  color: #e06666;
}

</style>