
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import Vue from 'vue'
import VueRouter from 'vue-router'
import Vuetify from 'vuetify';

// import auth from './service/Auth'
import store from './store'
import axios from 'axios';
import Vuelidate from 'vuelidate';
import { routes } from './routes'
import 'vuetify/dist/vuetify.min.css';
// import 'font-awesome/css/font-awesome.min.css';
// import 'font-awesome/css/font-awesome.css';
import App from './components/App'
//setupComponents(Vue);
import http from './http'
http.init();

Vue.use(VueRouter); 
Vue.use(Vuetify);
Vue.use(Vuelidate);
// Vue.component('apexchart', VueApexCharts)

const router = new VueRouter({
    //base:'/budgeting',
    base:'/',
    mode: 'history',
    routes,
});

Vue.router = router

new Vue({
    el: '#app',
    router,
    vuetify : new Vuetify(),
    store,
    render: h => h(App),
    created() {
        try {
            auth.refresh()
        } catch (err) {
            // Do nothing :))
        }
    }
}).$mount('#app');
