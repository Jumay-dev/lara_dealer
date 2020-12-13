import Vue from 'vue'
import VueRouter from 'vue-router'

Vue.use(VueRouter)

import App from './components/App'
import Hello from './components/Hello'
import Home from './components/Home'

const router = new VueRouter({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'home',
      component: Home
    },
    {
      path: '/hello',
      name: 'hello',
      component: Hello,
    },
  ],
});

const app = new Vue({
  el: '#app',
  components: { App },
  router,
});