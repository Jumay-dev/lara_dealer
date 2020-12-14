import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify.js'
import VueProgressBar from 'vue-progressbar';

const options = {
  color: 'blue', // '#bffaf3',
  failedColor: '#874b4b',
  thickness: '3px',
  transition: {
    speed: '0.1s',
    opacity: '0.3s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
};

Vue.config.productionTip = false;

Vue.use(VueProgressBar, options);

new Vue({
  router,
  render: h => h(App),
  vuetify
}).$mount('#app')