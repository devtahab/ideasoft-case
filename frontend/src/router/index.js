import Home from '@/views/Home.vue'
import Checkout from '@/views/Checkout.vue'
import { createRouter, createWebHistory } from 'vue-router'
import Orders from '@/views/Orders.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {path: '/', name: 'home', component: Home},
    {path: '/checkout', name: 'checkout', component: Checkout},
    {path: '/orders', name: 'orders', component: Orders}
  ],
})

export default router
