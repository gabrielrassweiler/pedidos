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
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
