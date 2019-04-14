import Vue from 'vue';
import Cookies from 'js-cookie';
import ElementUI from 'element-ui';
import App from './views/App';
import store from './store';
import router from '@/router';
import i18n from './lang'; // Internationalization
import '@/icons'; // icon
import '@/permission'; // permission control
const axios = require('axios');

window.axios = axios;

import * as filters from './filters'; // global filters

Vue.use(ElementUI, {
  size: Cookies.get('size') || 'medium', // set element-ui default size
  i18n: (key, value) => i18n.t(key, value),
});

// register global utility filters.
Object.keys(filters).forEach(key => {
  Vue.filter(key, filters[key]);
});

Vue.config.productionTip = false;

const moment = require('moment');
require('moment/locale/en-ie');
require('moment/locale/es');

Vue.use(require('vue-moment'), {
  moment,
});

new Vue({
  el: '#app',
  router,
  store,
  i18n,
  render: h => h(App),
});
