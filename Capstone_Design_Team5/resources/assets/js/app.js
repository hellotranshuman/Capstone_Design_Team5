import Vue from 'vue';
import Vuetify from 'vuetify';
import VueRouter from 'vue-router';

import VueAxios from 'vue-axios';
import axios from 'axios';
import BootstrapVue from 'bootstrap-vue';
import 'vuetify/dist/vuetify.min.css';
// import 'bootstrap/dist/css/bootstrap.css'
// import 'bootstrap-vue/dist/bootstrap-vue.css'

Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);

import App from './App.vue';
import OwnerRestaurant from './components/owner/owner_restaurant/OwnerRestaurant.vue';
// 유저 메인 페이지 컴포넌트 import
import UserMain from './components/user/user_main/UserMain.vue';
// 유저 리뷰 페이지 컴포넌트 import
import UserCommon from './components/user/user_common/UserCommon.vue';
// 가게 정보 페이지 컴포넌트 import
import UserMenu from './components/user/user_menu/UserMenu.vue';
// 메뉴판 페이지 컴포넌트 import
import UserReview from './components/user/user_review/UserReview.vue';
// 리뷰 페이지 컴포넌트 import
import UserRestaurant from './components/user/user_restaurant/UserRestaurant.vue';
// 리뷰 작성 페이지 컴포넌트 import
import UserWriteReview from './components/user/user_review/UserWriteReview.vue';
// 쿠폰 생성 페이지 컴포넌트 import
import createCoupon from './components/owner/owner_coupon/createCoupon.vue';

import UserNavBar from './components/user/user_main/navbar.vue';

const routes = [
    {
        name :'OwnerRestaurant',
        path : '/createRestaurant',
        component : OwnerRestaurant
    },
    {
        name: 'createCoupon',
        path: '/restaurant/:shop_id/createCoupon',
        component: createCoupon
    },
    {
        name: 'UserRestaurant',
        path: '/restaurant/:shop_id/info',
        component: UserRestaurant
    },
    {
        name: 'UserNavBar',
        path: '/main',
        component: UserNavBar
    }
    ,
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
        ]
    },
    {
        name: 'UserWriteReview',
        path: '/review/writeReview',
        component: UserWriteReview,
    }
];

const router = new VueRouter({ mode: 'history', routes: routes});
new Vue(Vue.util.extend({ router }, App)).$mount('#app');
