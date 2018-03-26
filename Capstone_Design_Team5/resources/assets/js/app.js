import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import App from './App.vue';
// 유저 메인 페이지에 해당하는 컴포넌트를 import합니다.
import UserMain from './components/user/user_main/UserMain.vue';

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

const routes = [{
    name: 'UserMain',
    path: '/',
    component: UserMain
}];

const router = new VueRouter({ mode: 'history', routes: routes });
new Vue(Vue.util.extend({ router }, App)).$mount('#app');