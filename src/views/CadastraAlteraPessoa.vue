<template>
  <div>
    <fieldset class="rounded-3 mb-3">
      <legend class="float-none fs-6 w-auto bg-white">{{rotinaAlterar ? 'Alterar Pessoa' : 'Cadastro de Pessoa'}}</legend>

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
            @click="rotinaAlterar ? alteraPessoa() : cadastraPessoa()"
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
    name: 'CadastraPessoa',
    data() {
      return {
        id: '',
        nome: '',
        sexo: '',
        idade: 0,
        cpf: '',
        email: '',
        telefone: '',
        cep: '',
        rotinaAlterar: false
      }
    },
    created() {
      if (this.$route.name === 'AlteraPessoa') {
        this.rotinaAlterar = true;
        const pessoa = JSON.parse(localStorage.getItem("alteraPessoa"));

        this.id = pessoa.id
        this.nome = pessoa.nome
        this.sexo = pessoa.sexo
        this.idade = pessoa.idade
        this.cpf = pessoa.cpf
        this.email = pessoa.email
        this.telefone = pessoa.telefone
        this.cep = pessoa.cep
      }
    },
    methods: {
      async cadastraPessoa() {
        const valido = await this.validaCamposObrigatorios()
        if (!valido[0]) {
          return alert(valido[1]);
        }
        const params = this.montaParamsRequest();

        axios
          .get('http://localhost:8083/pessoa/cadastrar/' + params)
          .then(response => {
            console.log(response)
          })
      },
      async alteraPessoa() {
        const valido = await this.validaCamposObrigatorios()
        if (!valido[0]) {
          return alert(valido[1]);
        }
        const params = await this.montaParamsRequest();

        axios
          .get('http://localhost:8083/pessoa/atualizar/' + params)
          .then(response => {
            console.log(response)
          })
      },
      async montaParamsRequest() {
        const params = {
          id: this.id,
          nome: this.nome,
          sexo: this.sexo,
          idade: this.idade,
          cpf: this.cpf,
          // tudo que for . substitui para nao acontecer erro ao enviar
          email: this.email.replaceAll('.', '!'),
          telefone: this.telefone,
          cep: this.cep,
        }

        return Object.keys(params)
          .map((key) => {
            return key + '=' + params[key]
          })
          .join('&')
      },
      async validaCamposObrigatorios() {
        if (!this.nome) {
          return [false, 'Campo de nome da pessoa não preenchido'];
        }
        if (!this.sexo) {
          return [false, 'Campo de sexo da pessoa não preenchido'];
        }
        if (!this.idade) {
          return [false, 'Campo de idade da pessoa não preenchido'];
        }
        if (!this.cpf) {
          return [false, 'Campo de cpf da pessoa não preenchido'];
        }
        if (!this.email) {
          return [false, 'Campo de email da pessoa não preenchido'];
        }
        if (!this.telefone) {
          return [false, 'Campo de telefone da pessoa não preenchido'];
        }
        if (!this.cep) {
          return [false, 'Campo de cep da pessoa não preenchido'];
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