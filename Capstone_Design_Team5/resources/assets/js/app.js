import Vue from 'vue';

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import VueAxios from 'vue-axios';

import axios    from 'axios';
Vue.use(VueAxios, axios);
Vue.use(BootstrapVue);

import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

// vuetify import
import Vuetify from 'vuetify'
Vue.use(Vuetify)

import 'vuetify/dist/vuetify.min.css'



import App from './App.vue';

// icon API
import VueIco, {icoMenu} from 'vue-ico';
Vue.use(VueIco, {
    "menu": icoMenu
});

// SNS 공유 API
var SocialSharing = require('vue-social-sharing');
Vue.use(SocialSharing);

// 유저 메인 페이지 컴포넌트 import
import UserMain     from './components/user/user_main/UserMain.vue';
// 유저 리뷰 페이지 컴포넌트 import
import UserRestaurantMain   from './components/user/user_common/UserRestaurantMain.vue';

// 가게 정보 페이지 컴포넌트 import
import UserMenu         from './components/user/user_menu/UserMenu.vue';
// 메뉴판 페이지 컴포넌트 import
import UserReview       from './components/user/user_review/UserReview.vue';
// 리뷰 페이지 컴포넌트 import
import UserRestaurant   from './components/user/user_restaurant/UserRestaurant.vue';
// 리뷰 작성 페이지 컴포넌트 import
import UserWriteReview  from './components/user/user_review/UserWriteReview.vue';

// Common Page, 사장님 페이지 공통 컴포넌트 import
import OwnerPage                    from './components/owner/owner_common/OwnerPage.vue';
import OwnerPageSideReservation     from './components/owner/owner_common/OwnerPageSideReservation.vue';
import OwnerPageSideSetting         from './components/owner/owner_common/OwnerPageSideSetting.vue';

// Reservation Page, 예약 관련
// Reservation Accept Page
import OwnerReservationAccept   from './components/owner/owner_reservation/OwnerReservationAccept.vue';
// Reservation List
import OwnerReservationlist     from './components/owner/owner_reservation/OwnerReservationlist.vue';
// Reservation Setting
import OwnerReservationSetting  from './components/owner/owner_reservation/OwnerReservationSetting.vue';

// Coupon Page, 쿠폰 제작 페이지 컴포넌트 import
import OwnerCreateCoupon from './components/owner/owner_coupon/OwnerCreateCoupon.vue'


const routes = [
    {
        name: 'UserMain',                                   // root 페이지
        path: '/',
        component: UserMain
    },
    {
        name: 'UserRestaurantMain',                         // 가게 페이지
        path: '/userRestaurantMain',
        component: UserRestaurantMain,
        // 네스티드 라우터
        children:[
            {
                name: 'UserRestaurant',                     // 가게 페이지 안의 정보
                path: '/userRestaurantMain/restaurant',
                component: UserRestaurant
            },
            {
                name: 'UserMenu',                           // 가게 페이지 안의 메뉴
                path: '/userRestaurantMain/menu',
                component: UserMenu
            },
            {
                name: 'UserReview',                         // 가게 페이지 안의 리뷰
                path: '/userRestaurantMain/review',
                component: UserReview
            }
        ]
    },
    {
        name: 'UserWriteReview',                            // 리뷰 작성
        path: '/userRestaurantMain/review/writeReview',
        component: UserWriteReview,
    },
    {
        name: 'OwnerPage',                                  // 사장님 페이지
        path: '/ownerPage',
        component: OwnerPage,
        // side_var
        children: [{
            name: 'OwnerPageSideReservation',               // 사장님 페이지 예약 관련 좌측 바
            path: '/ownerPage/ownerPageSideReservation',
            component: OwnerPageSideReservation,
            // Main
            children: [{
                name: 'OwnerReservationlist',               // 사장님 페이지 예약 현황
                path: '/ownerPage/ownerReservationlist',
                component: OwnerReservationlist
                },
                {
                    name: 'OwnerReservationAccept',         // 사장님 페이지 예약 수락
                    path: '/ownerPage/ownerReservationAccept',
                    component: OwnerReservationAccept
                },
                {
                    name: 'OwnerReservationSetting',        // 사장님 페이지 예약 설정
                    path: '/ownerPage/ownerReservationSetting',
                    component: OwnerReservationSetting
                }]
        },
        {
            name: 'OwnerPageSideSetting',                   // 사장님 페이지 가게 설정 관련 좌측 바
            path: '/ownerPage/ownerPageSideSetting',
            component: OwnerPageSideSetting,

            children: [{
                name: 'OwnerCreateCoupon',                  // 사장님 페이지 쿠폰 제작     
                path: '/ownerPage/ownerCreateCoupon',
                component: OwnerCreateCoupon
            }]
        }],
    }
];

const router = new VueRouter({ 
    mode: 'history', 
    routes: routes 
});

new Vue(Vue.util.extend({ router }, App)).$mount('#app');