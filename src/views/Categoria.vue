<template>
  <div class="col-md-12">
    <a
      type="button"
      class="btn btn-secondary mb-4"
      href="/cadastra-categoria"
    >Cadastrar
    </a>
  </div>

  <div class="col-md-12">
    <div class="row header">
      <div class="col-1">ID</div>
      <div class="col-5">Descricao</div>
      <div class="col-4">Modalidade</div>
      <div class="col-1"></div>
      <div class="col-1"></div>
    </div>
    <div class="row" v-for="categoria in categorias" :key="categoria.id">
      <div class="col-1 mt-2">{{ categoria.id }}</div>
      <div class="col-5 mt-2">{{ categoria.descricao }}</div>
      <div class="col-4 mt-2">{{ categoria.modalidade }}</div>
      <div class="col-1 mt-2 color-green">
        <a
          href="/altera-categoria"
          @click="alteraCategoria(this.categorias.filter(category => category.id === categoria.id)[0])"
        >Alterar
        </a>
      </div>
      <div
        class="col-1 mt-2 color-red"
        @click="removeCategoria(categoria.id)"
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
  name: 'Categoria',
  created() {
    this.$store.dispatch('loadCategory');
  },
  computed: mapState([
    'categorias'
  ]),
  methods: {
    async removeCategoria(categoriaID) {
      if (confirm('Deseja remover a categoria de ID ' + categoriaID + ' ?')) {
        axios
          .get('http://localhost:8083/categoria/remover/' + categoriaID)
          .then(response => {
            console.log(response)
          })
      }
    },
    async alteraCategoria(categoria) {
      console.log(categoria)
      localStorage.setItem('alteraCategoria', JSON.stringify(categoria));
    }
  }
}
</script>

<style lang="scss" scoped>
.header {
  background-color: #f2f2f2;
  border: 2px solid lightgray;
}

.col-1, .col-4, .col-5 {
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