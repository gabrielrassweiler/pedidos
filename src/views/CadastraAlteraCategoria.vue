<template>
  <div>
    <fieldset class="rounded-3 mb-3">
      <legend class="float-none fs-6 w-auto bg-white">{{rotinaAlterar ? 'Alterar Categoria' : 'Cadastro de Categoria'}}</legend>

      <form class="row g-2">

        <div class="col-md-6">
          <label class="form-label">Descrição</label>
          <input
            type="text"
            class="form-control"
            v-model="descricao"
          />
        </div>
        <div class="col-md-6">
          <label class="form-label">Modalidade</label>
          <input
            type="email"
            class="form-control"
            v-model="modalidade"
          />
        </div>

        <div class="col-md-10"></div>
        <div class="col-md-2 mt-3">
          <button
            type="button"
            class="btn btn-primary float-end"
            @click="rotinaAlterar ? alteraCategoria() : cadastraCategoria()"
          >{{rotinaAlterar ? 'ALTERAR' : 'CADASTRAR'}}
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
    name: 'CadastraCategoria',
    data() {
      return {
        id: '',
        descricao: '',
        modalidade: '',
        rotinaAlterar: false
      }
    },
    created() {
      if (this.$route.name === 'AlteraCategoria') {
        this.rotinaAlterar = true;
        const categoria = JSON.parse(localStorage.getItem("alteraCategoria"));

        this.id = categoria.id
        this.descricao = categoria.descricao
        this.modalidade = categoria.modalidade
      }
    },
    methods: {
      async cadastraCategoria() {
        const valido = await this.validaCamposObrigatorios()
        if (!valido[0]) {
          return alert(valido[1]);
        }
        const params = await this.montaParamsRequest();

        axios
          .get(process.env.VUE_APP_BASE_ROUTE + 'categoria/cadastrar/' + params)
          .then(response => {
            location.href = '/categoria'
            console.log(response)
          })
      },
      async alteraCategoria() {
        const valido = await this.validaCamposObrigatorios()
        if (!valido[0]) {
          return alert(valido[1]);
        }
        const params = await this.montaParamsRequest(true);

        axios
          .get(process.env.VUE_APP_BASE_ROUTE + 'categoria/atualizar/' + params)
          .then(response => {
            location.href = '/categoria'
            console.log(response)
          })
      },
      async montaParamsRequest(alteraCategoria = false) {
        const params = {
          descricao: this.descricao,
          modalidade: this.modalidade
        }

        // Validação pois no cadastro nao manda com id
        if (alteraCategoria) {
          params['id'] = this.id;
        }

        return Object.keys(params)
          .map((key) => {
            return key + '=' + params[key]
          })
          .join('&')
      },
      async validaCamposObrigatorios() {
        if (!this.descricao) {
          return [false, 'Campo de descrição da categoria não preenchido'];
        }
        if (!this.modalidade) {
          return [false, 'Campo de modalidade da categoria não preenchido'];
        }

        return [true, ''];
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