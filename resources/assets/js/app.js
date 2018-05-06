import Vue from 'vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
import App from './App.vue';

Vue.use(VueRouter);
Vue.use(Vuetify);
Vue.use(VueAxios, axios);


// SNS 공유 API
var SocialSharing = require('vue-social-sharing');
Vue.use(SocialSharing);
// 이미지 확대 API
import VuePreview from 'vue-preview';
// google Maps API
import * as VueGoogleMaps from "vue2-google-maps";

// defalut install
Vue.use(VuePreview);
// google Maps install
Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyDTHKQzISVxAAfuBGp0HKj5GpMPNqR_Ovo",
        libraries: "places" // necessary for places input
    }
});
// chartjs
import VueCharts from 'vue-chartjs'
import { Bar, Line, Pie, Doughnut, Radar } from 'vue-chartjs'


// <-- User Main Page Component Import
import Home                 from './components/user/user_main/UserMain.vue';
import Home2                 from './components/user/user_main/UserMain2.vue';
// <-- User Register Page Component Import
import Register         from './components/Register.vue';
// <-- User Restaurant Page Component Import
import UserRestaurantMain   from './components/user/user_common/UserRestaurantMain.vue';

// <-- Owner Common Page Component Import
import OwnerPage                from './components/owner/owner_common/OwnerPage.vue';
import OwnerPageSideReservation from './components/owner/owner_common/OwnerPageSideReservation.vue';
import OwnerPageSideSetting     from './components/owner/owner_common/OwnerPageSideSetting.vue';
import OwnerPageSideStatistics from './components/owner/owner_common/OwnerPageSideStatistics.vue';

// <-- Owner Reservation Page
// Owner Reservation List Import
import OwnerReservationList     from './components/owner/owner_reservation/OwnerReservationlist.vue';
// Owner Reservation Accept Page Import
import OwnerReservationAccept   from './components/owner/owner_reservation/OwnerReservationAccept.vue';
// Owner Reservation Setting Page Import
import OwnerReservationSetting  from './components/owner/owner_reservation/ownerReservationSetting.vue';

// <-- Create Restaurant Page
// Create Restaurant Information Import
import OwnerRestaurant from './components/owner/owner_restaurant/OwnerRestaurant.vue';
// Create Coupon Page Import
import OwnerCreateCoupon from './components/owner/owner_coupon/createCoupon.vue';

// <-- 전자메뉴판 설정
// 전자 메뉴판 설정 Page Component Import
import OwnerMenu from './components/owner/owner_menu/OwnerMenu.vue';
// 전자메뉴판 메뉴 추가 Page Component Import
import OwnerMenuOperate from './components/owner/owner_menu/OwnerMenuOperate.vue';
// 전자메뉴판 메뉴 리스트 Page Component Import
import OwnerMenuList from './components/owner/owner_menu/OwnerMenuList.vue';
// 전자메뉴판 메뉴 레이아웃 선택 Page Component Import
import OwnerMenuSelectLayout from './components/owner/owner_menu/OwnerMenuSelectLayout.vue';

// <-- user Menu & Review
// 가게 정보 페이지 컴포넌트 import
import MenuMain from './components/user/user_menu/MenuMain.vue';
// 메뉴판 페이지 컴포넌트 import
import UserReview from './components/user/user_review/UserReview.vue';
// 리뷰 페이지 컴포넌트 import
import UserRestaurant from './components/user/user_restaurant/UserRestaurant.vue';
// 리뷰 작성 페이지 컴포넌트 import
import UserWriteReview from './components/user/user_review/UserWriteReview.vue';

// <-- user Reservation
import CustomerAddReservation from './components/user/user_reservation/CustomerAddReservation.vue';

// <-- owner statistics
import OwnerTotalStatistics from './components/owner/owner_statistics/OwnerTotalStatistics.vue';

const router = new VueRouter({
        routes: [
            // <-- main Page
            {
                path: '/',
                name: 'home',
                component: Home
            },
            {
                path: '/search',
                name: 'home2',
                component: Home2
            },
            // <-- 회원 가입
            {
                path: '/register',
                name: 'register',
                component: Register
            },
            // <-- 가게 페이지 공통
            {
                path: '/restaurant',
                name: 'UserRestaurantMain',
                component: UserRestaurantMain,
                // 네스티드 라우터
                children: [
                    {
                        name: 'UserRestaurant',                     // 가게 페이지 안의 정보
                        path: '/restaurant/:shop_id/info',
                        component: UserRestaurant
                    },
                    {
                        name: 'UserMenu',                           // 가게 페이지 안의 메뉴
                        path: '/restaurant/:shop_id/menu',
                        component: MenuMain
                    },
                    {
                        name: 'UserReview',                         // 가게 페이지 안의 리뷰
                        path: '/restaurant/:shop_id/review',
                        component: UserReview
                    }
                ]
            },
            {
                name: 'UserWriteReview',                            // 리뷰 작성
                path: '/restaurant/:shop_id/writeReview',
                component: UserWriteReview,
            },
            {
                name: OwnerPage,                                  // 사장님 페이지
                path: '/owner',
                component: OwnerPage,
                // side bar
                children: [
                    {
                        name: 'OwnerPageSideReservation',          // 사장님 페이지 예약 관련 좌측 바
                        path: '/owner/ownerSideReservation',
                        component: OwnerPageSideReservation,

                        children: [
                            {
                                // 사장 예약 리스트 Page
                                name: 'OwnerReservationList',
                                path: '/owner/:shop_id/ownerReservationList',
                                component: OwnerReservationList,
                            },
                            {
                                // 사장 예약 수락 Page
                                name: 'OwnerReservationAccept',
                                path: '/owner/:shop_id/ownerReservationAccept',
                                component: OwnerReservationAccept,
                            },
                            {
                                // 사장 예약 설정 Page
                                name: 'OwnerReservationSetting',
                                path: '/owner/:shop_id/ownerReservationSetting',
                                component: OwnerReservationSetting,
                            }]
                    },
                    {
                        // Owner Page 가게 설정 관련 좌측 바
                        name: 'OwnerPageSideSetting',
                        path: '/owner/:shop_id/ownerPageSideSetting',
                        component: OwnerPageSideSetting,

                        children: [
                            {
                                // Restaurant 수정
                                name: 'OwnerRestaurant',
                                path: '/owner/createRestaurant',
                                // '/owner/createRestaurant',
                                // '/owner/:shop_id/editRestaurant',
                                component: OwnerRestaurant
                            },
                            {
                                // Owner Coupon 생성
                                name: 'OwnerCreateCoupon',
                                path: '/owner/:shop_id/createCoupon',
                                component: OwnerCreateCoupon
                            },
                            {
                                // 전자 메뉴판 설정
                                name: 'OwnerMenu',
                                path: '/owner/:shop_id/menu',
                                component: OwnerMenu,
                                children: [
                                    {
                                        // 전자메뉴판 메뉴 추가
                                        name: 'OwnerMenuOperate',
                                        path: '/owner/:shop_id/menuOperate',
                                        component: OwnerMenuOperate
                                    },
                                    {
                                        // 전자메뉴판 메뉴 리스트
                                        name: 'OwnerMenuList',
                                        path: '/owner/:shop_id/menuList',
                                        component: OwnerMenuList
                                    },
                                    {
                                        // 전자메뉴판 레이아웃 설정
                                        name: 'OwnerMenuSelectLayout',
                                        path: '/owner/:shop_id/menuLayout',
                                        component: OwnerMenuSelectLayout
                                    },
                                ]
                            }
                        ]
                    },
                    {
                        // 사장님 페이지 통계 좌측 바
                        name: 'OwnerPageSideStatistics',
                        path: '/owner/:shop_id/OwnerPageSideStatistics',
                        component: OwnerPageSideStatistics,
                        children:
                            [
                                {
                                    // 사장님페이지 통계
                                    name: 'OwnerTotalStatistics',
                                    path: '/owner/:shop_id/totalStatistics',
                                    component: OwnerTotalStatistics
                                }
                            ]

                    }

                ],
            },
            {
                name: 'CustomerAddReservation',
                path: '/restaurant/:shop_id/addReservation',
                component: CustomerAddReservation,
            }

        ],
        mode: 'history'
    }
);

new Vue({
    el: '#app',
    router: router,
    render: app => app(App)
});
