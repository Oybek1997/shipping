import Vue from 'vue';
import App from './App.vue';
import router from './router';
import store from './store';
import VueI18n from 'vue-i18n';
import Cookies from 'js-cookie';
import axios from 'axios';
import vuetify from './plugins/vuetify';
import '@/assets/css/style.css';

Vue.config.productionTip = false;
Vue.use(VueI18n);

Vue.component('downloadExcel', JsonExcel)

import uz_latin from '../src/components/languages/uz_latin';
import uz_cyril from '../src/components/languages/uz_cyril';
import ru from '../src/components/languages/ru';
import eng from '../src/components/languages/eng';
import 'roboto-fontface/css/roboto/roboto-fontface.css';
import '@mdi/font/css/materialdesignicons.css';
import JsonExcel from "vue-json-excel";
let locale = 'uz_latin';
if (store.state.locale != '') {
  locale = store.state.locale;
} else {
  store.dispatch('setLocale', locale);
}
const i18n = new VueI18n({
  locale: locale,
  silentTranslationWarn: true,
  messages: {
    uz_latin: uz_latin,
    uz_cyril: uz_cyril,
    ru: ru,
    eng: eng,
  },
});
Vue.prototype.$axios = axios;
Vue.config.productionTip = false;
Vue.config.disableNoTranslationWarning = true;
Vue.config.silent = false;

//-------------------------------------------------------------------------------------
axios.defaults.headers.common = {
  Accept: 'application/json',
  'Content-Type': 'application/json',
  Authorization: Cookies.get('access_token'),
};
if (Cookies.get('access_token'))
  axios
    .get(store.state.backend_url + '/api/users/show')
    .then((data) => {
      // let user = data.data;
      // let permissions = data.data.roles
      //     .reduce(
      //         (accumulator, currentValue) =>
      //             accumulator.concat(currentValue.permissions), []
      //     )
      //     .map(v => v.name);
      // let roles = data.data.roles;
      // user.roles = null;
      store.dispatch('setUser', data.data);
      // store.dispatch("setPermissions", permissions);
      // store.dispatch("setRole", roles);
    })
    .catch((e) => {
      console.error(e);
    });
axios.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    if (error.response.status == 401) router.push('/login');
    // return Promise.reject(error.message);
  }
);

new Vue({
  Cookies,
  router,
  store,
  i18n,
  vuetify,
  render: (h) => h(App),
}).$mount('#app');
