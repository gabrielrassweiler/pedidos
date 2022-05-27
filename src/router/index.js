import { createRouter, createWebHistory } from 'vue-router'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: () => import('@/views/Home.vue')
  },
  {
    path: '/basket',
    name: 'Basket',
    component: () => import('@/views/Basket.vue')
  },
  {
    path: '/pessoa',
    name: 'Pessoa',
    component: () => import('@/views/Pessoa.vue')
  },
  {
    path: '/cadastra-pessoa',
    name: 'CadastraPessoa',
    component: () => import('@/views/CadastraAlteraPessoa.vue')
  },
  {
    path: '/altera-pessoa',
    name: 'AlteraPessoa',
    component: () => import('@/views/CadastraAlteraPessoa.vue')
  },
  {
    path: '/categoria',
    name: 'Categoria',
    component: () => import('@/views/Categoria.vue')
  },
  {
    path: '/cadastra-categoria',
    name: 'CadastraCategoria',
    component: () => import('@/views/CadastraAlteraCategoria.vue')
  },
  {
    path: '/altera-categoria',
    name: 'AlteraCategoria',
    component: () => import('@/views/CadastraAlteraCategoria.vue')
  },
  {
    path: '/produto',
    name: 'Produto',
    component: () => import('@/views/Produto.vue')
  },
  {
    path: '/cadastra-produto',
    name: 'CadastraProduto',
    component: () => import('@/views/CadastraAlteraProduto.vue')
  },
  {
    path: '/altera-produto',
    name: 'AlteraProduto',
    component: () => import('@/views/CadastraAlteraProduto.vue')
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
