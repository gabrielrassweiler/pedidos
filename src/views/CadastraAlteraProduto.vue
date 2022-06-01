<template>
  <div>
    <fieldset class="rounded-3 mb-3">
      <legend class="float-none fs-6 w-auto bg-white">{{rotinaAlterar ? 'Alterar Produto' : 'Cadastro de Produto'}}</legend>

      <form class="row g-2">

        <div class="col-md-6">
          <label class="form-label">Categoria</label>
          <input
            type="text"
            class="form-control"
            v-model="categoria"
          />
        </div>
        <div class="col-md-6">
          <label class="form-label">Título</label>
          <input
            type="text"
            class="form-control"
            v-model="titulo"
          />
        </div>

        <div class="col-md-8">
          <label class="form-label">Descrição</label>
          <input
            type="text"
            class="form-control"
            v-model="descricao"
          />
        </div>
        <div class="col-md-4">
          <label class="form-label">Valor</label>
          <input
            type="number"
            class="form-control"
            v-model="valor"
          />
        </div>

        <div class="col-md-10"></div>
        <div class="col-md-2 mt-3">
          <button
            type="button"
            class="btn btn-primary float-end"
            @click="rotinaAlterar ? alteraProduto() : cadastraProduto()"
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
    name: 'CadastraProduto',
    data() {
      return {
        id: '',
        categoria: '',
        titulo: '',
        descricao: '',
        valor: 0,
        rotinaAlterar: false
      }
    },
    created() {
      if (this.$route.name === 'AlteraProduto') {
        this.rotinaAlterar = true;
        const produto = JSON.parse(localStorage.getItem("alteraProduto"));

        this.id = produto.id
        this.categoria = produto.categoria
        this.titulo = produto.titulo
        this.descricao = produto.descricao
        this.valor = produto.valor
      }
    },
    methods: {
      async cadastraProduto() {
        const valido = await this.validaCamposObrigatorios()
        if (!valido[0]) {
          return alert(valido[1]);
        }
        const params = await this.montaParamsRequest();

        axios
          .get(process.env.VUE_APP_BASE_ROUTE + 'produto/cadastrar/' + params)
          .then(response => {
            location.href = '/produto'
            console.log(response)
          })
      },
      async alteraProduto() {
        const valido = await this.validaCamposObrigatorios()
        if (!valido[0]) {
          return alert(valido[1]);
        }
        const params = await this.montaParamsRequest(true);

        axios
          .get(process.env.VUE_APP_BASE_ROUTE + 'produto/atualizar/' + params)
          .then(response => {
            location.href = '/produto'
            console.log(response)
          })
      },
      async montaParamsRequest(alteraProduto = false) {
        const params = {
          categoria: this.categoria,
          titulo: this.titulo,
          descricao: this.descricao,
          valor: this.valor,
        }

        // Validação pois no cadastro nao manda com id
        if (alteraProduto) {
          params['id'] = this.id;
        }

        return Object.keys(params)
          .map((key) => {
            return key + '=' + params[key]
          })
          .join('&')
      },
      async validaCamposObrigatorios() {
        if (!this.categoria) {
          return [false, 'Campo de categoria da produto não preenchido'];
        }
        if (!this.titulo) {
          return [false, 'Campo de titulo da produto não preenchido'];
        }
        if (!this.descricao) {
          return [false, 'Campo de descricao da produto não preenchido'];
        }
        if (!this.valor) {
          return [false, 'Campo de valor do produto não preenchido'];
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