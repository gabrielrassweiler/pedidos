<template>
  <div>
    <fieldset class="rounded-3 mb-3">
      <legend class="float-none fs-6 w-auto bg-white">Cadastro de Pessoa</legend>

      <form class="row g-2">

        <div class="col-md-6">
          <label class="form-label">Nome</label>
          <input
            type="text"
            class="form-control"
            v-model="nome"
          />
        </div>
        <div class="col-md-6">
          <label class="form-label">Email</label>
          <input
            type="email"
            class="form-control"
            v-model="email"
          />
        </div>

        <div class="col-md-4">
          <label class="form-label">Idade</label>
          <input
            type="number"
            class="form-control"
            v-model="idade"
          />
        </div>
        <div class="col-md-4">
          <label class="form-label">Sexo</label>
          <select
            class="form-select"
            v-model="sexo"
          >
            <option>Masculino</option>
            <option>Feminino</option>
          </select>
        </div>
        <div class="col-md-4">
          <label class="form-label">CPF</label>
          <input
            type="text"
            class="form-control"
            v-model="cpf"
          />
        </div>

        <div class="col-md-6">
          <label class="form-label">Telefone</label>
          <input
            type="text"
            class="form-control"
            v-model="telefone"
          />
        </div>
        <div class="col-md-6">
          <label class="form-label">CEP</label>
          <input
            type="text"
            class="form-control"
            v-model="cep"
          />
        </div>

        <div class="col-md-10"></div>
        <div class="col-md-2 mt-3">
          <button
            type="button"
            class="btn btn-primary float-end"
            @click="cadastraPessoa()"
          >CADASTRAR
          </button>
        </div>
      </form>
    </fieldset>
  </div>
</template>

<script>
  import axios from "axios";

  export default {
    // eslint-disable-next-line vue/multi-word-component-names
    name: 'CadastraPessoa',
    data() {
      return {
        nome: '',
        sexo: '',
        idade: 0,
        cpf: '',
        email: '',
        telefone: '',
        cep: '',
      }
    },
    methods: {
      async cadastraPessoa() {
        axios
          .get('http://localhost:8083/pessoa/cadastrar')
          .then(response => {
            console.log(response)
          })
      }
    }
  }
</script>

<style lang="scss" scoped>
fieldset {
  padding: 0 13px 13px 13px;
  box-shadow: rgba(70, 80, 90, 0.3) 0 0 0.25em, rgba(120, 150, 200, 0.09) 0 0.25em 1em;
}
</style>