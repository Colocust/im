import Vue from 'vue'
import Router from 'vue-router'
import Index from '@/pages/Home'
import Login from '@/pages/Login'
import Register from '@/pages/Register'
import Room from '@/pages/Room'

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Index',
      component: Index
    },
    {
      path: '/login',
      name: 'Login',
      component: Login
    },
    {
      path: '/register',
      name: 'Register',
      component: Register
    },
    {
      path: '/room',
      name: 'Room',
      component: Room
    },
  ]
})
