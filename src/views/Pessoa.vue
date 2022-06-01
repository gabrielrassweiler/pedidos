<template>
  <div class="col-md-12">
    <a
      type="button"
      class="btn btn-secondary mb-4"
      href="/cadastra-pessoa"
    >Cadastrar
    </a>
  </div>

  <div class="col-md-12">
    <div class="row header">
      <div class="col-1">ID</div>
      <div class="col-3">Nome</div>
      <div class="col-3">Email</div>
      <div class="col-1">Idade</div>
      <div class="col-2">CPF</div>
      <div class="col-1"></div>
      <div class="col-1"></div>
    </div>
    <div class="row" v-for="pessoa in pessoas" :key="pessoa.id">
      <div class="col-1 mt-2">{{ pessoa.id }}</div>
      <div class="col-3 mt-2">{{ pessoa.nome }}</div>
      <div class="col-3 mt-2">{{ pessoa.email }}</div>
      <div class="col-1 mt-2">{{ pessoa.idade }}</div>
      <div class="col-2 mt-2">{{ pessoa.cpf }}</div>
      <div class="col-1 mt-2 color-green">
        <a
          href="/altera-pessoa"
          @click="alteraPessoa(this.pessoas.filter(person => person.id === pessoa.id)[0])"
        >Alterar
        </a>
      </div>
      <div
        class="col-1 mt-2 color-red"
        @click="removePessoa(pessoa.id)"
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
    name: 'Pessoa',
    created() {
      this.$store.dispatch('loadPerson');
    },
    computed: mapState([
      'pessoas'
    ]),
    methods: {
      async removePessoa(pessoaID) {
        if (confirm('Deseja remover a pessoa de ID ' + pessoaID + ' ?')) {
          axios
            .get(process.env.VUE_APP_BASE_ROUTE + 'pessoa/remover/' + pessoaID)
            .then(response => {
              console.log(response)
            })
        }
      },
      async alteraPessoa(pessoa) {
        localStorage.setItem('alteraPessoa', JSON.stringify(pessoa));
      }
    }
  }
</script>

<style lang="scss" scoped>
.header {
  background-color: #f2f2f2;
  border: 2px solid lightgray;
}

.col-1, .col-2, .col-3, .col-4 {
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