import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';
Vue.use(VueAxios, axios);

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'


// SNS 공유 API
var SocialSharing = require('vue-social-sharing');
Vue.use(SocialSharing);




import App from './App.vue';
// 유저 메인 페이지 컴포넌트 import
import UserMain from './components/user/user_main/UserMain.vue';
// 유저 리뷰 페이지 컴포넌트 import
import UserCommon from './components/user/user_common/UserCommon.vue';

import createCupon from './components/owner/owner_coupon/createCupon.vue';

// 가게 정보 페이지 컴포넌트 import
import UserMenu from './components/user/user_menu/UserMenu.vue';
// 메뉴판 페이지 컴포넌트 import
import UserReview from './components/user/user_review/UserReview.vue';
// 리뷰 페이지 컴포넌트 import
import UserRestaurant from './components/user/user_restaurant/UserRestaurant.vue';
// 리뷰 작성 페이지 컴포넌트 import
import UserWriteReview from './components/user/user_review/UserWriteReview.vue';

const routes = [
    {
        name: 'UserCommon',
        path: '/',
        component: UserCommon,
        // 네스티드 라우터
        children:[
            {
                name: 'UserMenu',
                path: '/menu',
                component: UserMenu
            },
            {
                name: 'UserReview',
                path: '/review',
                component: UserReview
            },
            {
                name: 'UserRestaurant',
                path: '/restaurant',
                component: UserRestaurant
            }
        ]
    },
    {
        name: ' ',
        path: '/createCoupon',
        component: createCupon
    },
    
    {
        name: 'UserWriteReview',
        path: '/review/writeReview',
        component: UserWriteReview,
    }
];

const router = new VueRouter({ 
    mode: 'history', 
    routes: routes 
});

new Vue(Vue.util.extend({ router }, App)).$mount('#app');