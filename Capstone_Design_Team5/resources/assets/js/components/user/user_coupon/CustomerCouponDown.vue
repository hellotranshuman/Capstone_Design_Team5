<template>
    <v-app>
        <div>
            <div class="CouponDownBtn">
                <v-btn 
                    small 
                    color="cyan darken-1" 
                    @click="dialog2 = true"
                    style="color:white"
                ><B>쿠폰 다운</B></v-btn>
            </div>
            <v-dialog 
                v-model="dialog2" 
                fullscreen
                hide-overlay
            >
                <v-card>
                     <v-toolbar card dark color="cyan darken-1">
                        <v-btn icon dark @click.native="dialog2 = false">
                            <v-icon>close</v-icon>
                        </v-btn>
                    <v-toolbar-title></v-toolbar-title>
                        <v-spacer></v-spacer>
                    </v-toolbar>
                    
                    <v-card-text>
                        <div class="CouponDownTitle"><B>쿠폰 다운 받기</B></div>
                        <hr>
                        <div class="CouponDownMain">
                            <template v-for="(item, index) in items">
                                    <!-- 쿠폰 리스트 -->
                                    <v-list-tile :key="item.name" avatar ripple >
                                        <v-list-tile-content>
                                            <v-list-tile-title>
                                                <B> {{ item.name }} </B>
                                            </v-list-tile-title>
                                            <!-- 카테고리 -->
                                            <v-list-tile-sub-title class="text--primary">
                                                {{ item.category }}
                                            </v-list-tile-sub-title>
                                            <v-list-tile-sub-title v-if="item.category == '상품 제공'">
                                                {{item.price_condition}}이상일 경우, &nbsp; {{ item.add_product }} 제공
                                            </v-list-tile-sub-title>
                                            <v-list-tile-sub-title v-if="item.category == '가격 할인'">
                                                {{item.price_condition}}이상일 경우, &nbsp; {{ item.discount }} 할인
                                            </v-list-tile-sub-title>
                                            <v-list-tile-sub-title>
                                                [ {{ item.start_date }} ~ {{ item.expiry_date}} ]
                                            </v-list-tile-sub-title>
                                        </v-list-tile-content>
                                        <!-- 아이콘 -->
                                        <v-list-tile-action>
                                            <!-- 쿠폰 다운 -->
                                            <v-btn flat icon color="error" @click="Download(item)">
                                                <v-icon>get_app</v-icon>
                                            </v-btn>
                                        </v-list-tile-action>
                                    </v-list-tile>
                                <v-divider v-if="index + 1 < items.length" :key="index"></v-divider>
                            </template>
                        </div>
                    </v-card-text>
                </v-card>
            </v-dialog>
        </div>
    </v-app>
</template>
<script>
import VueAxios         from 'vue-axios';
import axios            from 'axios';

export default {
    data() {
        return {
            DownDialog : false,
            dialog2: false,
            clickCouponid : null,
            clickCouponname : null,

            items: [
                {
                    id : '1',
                    name : '안녕fsdfsd',
                    category : '상품 제공',
                    price_condition : '1000',
                    add_product : '제공',
                    start_date : '2018-03-02',
                    expiry_date : '2019-04-03'
                },
                {
                    id : '2',
                    name : 'd',
                    category : '가격 할인',
                    price_condition : '1000',
                    discount : '200',
                     start_date : '2018-03-02',
                    expiry_date : '2019-04-03'
                    
                }    
            ]
        }
    },  
    created: function () {
        axios.post('/userCoupon').then((response) => {
            /* DB Coupon Data */
           var Coupondata = response.data.coupon;
                    
           this.items = Coupondata;
        })
    },
    methods : {
        Download(item) {
            const index = this.items.indexOf(item)
            this.clickCouponid = this.items[index].id

            /* Data 송신 -> 자신의 쿠폰함으로 담긴다*/
            axios.post('/CouponDown', {
                // 쿠폰ID
                id  :  this.clickCouponid
            }).then(console.log('success')).catch(console.log('test '));     
        },
        Okey() {
          alert('쿠폰함에 쿠폰이 다운되었습니다.');
        }
    }
}
</script>
<style>
    /* 반응형 웹 */
    /* 모바일 */
    @media (max-width: 639px){ 
        .CouponDownTitle {
            font-size: 14px;
            text-align: center;
        }
        .CouponDownMain {
            font-size: 20px;
            text-align: center;
        }
    }
    /* 테블릿 */
    @media (min-width: 640px) and (max-width: 1023px){ 
       .CouponDownTitle {
            font-size: 20px;
            text-align: center;
        }  
    }
    /* 데스트 탑 */
    @media (min-width: 1024px){ 
        .CouponDownTitle {
            font-size: 20px;
            text-align: center;
        }  
    }
</style>