import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './App.vue';
import OwnerRestaurant from './components/owner/owner_restaurant/OwnerRestaurant.vue';

const routes = [
    {name :'OwnerRestaurant', path : '/createRestaurant', component : OwnerRestaurant }
];

const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');

