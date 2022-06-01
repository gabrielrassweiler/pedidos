<template>
  <div class="basket">
    <div class="items">

      <template v-if="productsInBag.length">

        <div v-for="(product, index) in productsInBag" :key="index" class="item">
          <div class="remove" @click="this.$store.dispatch('removeFromBag', product.id)">Remover Produto</div>
          <div class="photo">
            <img :src="product.imagem" alt="">
          </div>
          <div class="description">
            {{product.titulo}}
          </div>
          <div class="price">
            <span class="quantity-area">
              <button :disabled="product.quantity<=1" @click="product.quantity--">-</button>
              <span class="quantity">{{product.quantity}}</span>
              <button @click="product.quantity++">+</button>
            </span>
            <span class="amount">R$ {{ (product.valor * product.quantity).toFixed(2) }}</span>
          </div>
        </div>

        <div class="grand-total"> Total do pedido: R$ {{orderTotal()}}</div>
        <button
          class="btn btn-success"
          @click="confirmarPedido()"
        >CONFIRMAR
        </button>

      </template>

      <template v-else>
        <h4>Não há items no carrinho ainda</h4>
      </template>

    </div>
  </div>
</template>

<script>

import { mapState } from 'vuex'
import axios from "axios";

export default {
  // eslint-disable-next-line vue/multi-word-component-names
  name: 'Basket',
  methods: {
    orderTotal() {
      let total = 0;
      this.productsInBag.forEach(item => {
        total += item.valor * item.quantity;
      });
      return total.toFixed(2);
    },
    async confirmarPedido() {
      const id = Math.floor((1 + Math.random()) * 0x10000).toString(16).substring(1);

      for (const produto of this.productsInBag) {
        const params = await this.montaParamsRequest(produto, id)

        await axios
          .get(process.env.VUE_APP_BASE_ROUTE + '/venda/cadastrar/' + params)
          .then(response => {
            console.log(response)
          })
      }

      alert('Pedido confirmado com sucesso!');
      this.$store.dispatch('removeAllFromBag');
      location.href = '/'
    },
    async montaParamsRequest(produto, id) {
      const params = {
        id,
        pessoa: 3,
        produto: produto.id,
        quantidade: produto.quantity,
        valor: produto.valor,
        situacao: 1
      }

      return Object.keys(params)
        .map((key) => {
          return key + '=' + params[key]
        })
        .join('&')
    },
  },
  computed: mapState([
    'productsInBag'
  ]),
}
</script>

<style lang="scss">

.basket {
  text-align: center;
  padding: 60px 0;

  .items {
    max-width: 800px;
    margin: auto;
    .item {
      display: flex;
      justify-content: space-between;
      padding: 40px 0;
      border-bottom: 1px solid lightgrey;
      position: relative;

      .remove {
        position: absolute;
        top: 8px;
        right: 0;
        font-size: 11px;
        text-decoration: underline;
        cursor: pointer;
      }

      .quantity-area {
        margin: 8px auto;
        height: 14px;

        button {
          width: 16px;
          height: 16px;
          display: inline-flex;
          justify-content: center;
          align-items: center;
          cursor: pointer;
        }

        .quantity {

          margin: 0 4px;
        }
      }

      .photo {
        img {
          max-width: 80px;
        }
      }

      .description {
        padding-left: 30px;
        box-sizing: border-box;
        max-width: 50%;

      }

      .price {
        .amount {
          font-size: 16px;
          margin-left: 8px;
          vertical-align: middle;

        }
      }
    }
    .grand-total {
      font-size: 23px;
      font-weight: bold;
      text-align: center;
      margin: 10px 0;
    }
  }
}
</style>
