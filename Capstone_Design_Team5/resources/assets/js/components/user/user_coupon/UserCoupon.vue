<!-- 유저 쿠폰함 -->
<template>
    <v-app>
        <div id="UserPageCoupon">
            <br>
            <B>{{ userName }}</B> 님 반갑습니다.
            <hr>
            <h4><B> 나의 할인쿠폰 </B></h4><br>
            <v-tabs color="dark"
                    dark
                    slider-color="red"
            >
                <v-tab>
                    사용 가능한 쿠폰
                </v-tab>
                <v-tab-item>
                    <div id="Coupon_table">
                        <v-card flat>
                            <v-list two-line>
                                <template v-for="(item, index) in items">
                                    <!-- 쿠폰 리스트 -->
                                    <v-list-tile :key="item.name" avatar ripple>
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
                                            <v-list-tile-sub-title v-else-if="item.category == '가격 할인'">
                                                {{item.price_condition}}이상일 경우, &nbsp; {{ item.discount }} 할인
                                            </v-list-tile-sub-title>
                                            <v-list-tile-sub-title>
                                                [ {{ item.start_date }} ~ {{ item.expiry_date}} ]
                                            </v-list-tile-sub-title>
                                        </v-list-tile-content>
                                        <!-- 아이콘 -->
                                        <v-list-tile-action>
                                            <!-- 쿠폰 번역 -->
                                            <v-btn flat icon color="primary" @click="spendDialog = true, TransCoupon(item)">
                                                <v-icon>aspect_ratio</v-icon> 사용
                                            </v-btn>
                                            <!-- 번역 dialog -->
                                            <v-dialog
                                                    v-model="spendDialog"
                                                    hide-overlay
                                                    max-width="500px"
                                            >
                                                <v-card>
                                                    <v-card-title>
                                                        <div class="Trans_Title">
                                                            <b> {{ trans.name }} </b>
                                                        </div>
                                                    </v-card-title>
                                                    <v-card-text>
                                                        <div class="Trans_Main">
                                                            <B>카테고리 : </B>{{ trans.category }} <br>
                                                            <span v-if="trans.category == '상품 제공'">
                                                            <B>제공되는 상품 : </B>{{ trans.add_product }}
                                                        </span>
                                                            <span v-else-if="trans.category == '가격 할인'">
                                                            <B>할인 가격 : </B>{{ trans.discount }}
                                                        </span><br>
                                                            <B>쿠폰 조건 : </B>{{ trans.price_condition }} <br>
                                                            <B>사용 기간 : </B>{{ trans.start_date }} ~ {{ trans.expiry_date }}
                                                        </div>
                                                    </v-card-text>
                                                    <v-card-actions>
                                                        <v-btn color="primary" flat @click.stop="spendDialog=false" @click="SpendData()">사용하기</v-btn>
                                                        <v-btn color="primary" flat @click.stop="spendDialog=false">취소</v-btn>
                                                    </v-card-actions>
                                                </v-card>
                                            </v-dialog>
                                            <!-- 쿠폰 삭제 -->
                                            <v-btn flat icon color="error" @click="Cancel(item)">
                                                <v-icon>delete</v-icon>
                                            </v-btn>
                                        </v-list-tile-action>
                                    </v-list-tile>
                                    <v-divider v-if="index + 1 < items.length" :key="index"></v-divider>
                                </template>
                            </v-list>
                        </v-card>
                    </div>
                </v-tab-item>
            </v-tabs>
        </div>
    </v-app>
</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';

    export default {
        data() {
            return {
                userName : '윤진주',
                spendDialog : false,
                clickCoupon : null,

                /* 저장 & 편집 & 삭제 */
                items: [
                    {
                        id : 1,
                        name : '선주',
                        category : '상품 제공',
                        discount : '',
                        add_product : 'ㅇㅇ',
                        price_condition : '10000',
                        start_date : '2018-02-03',
                        expiry_date : '2018=34=34'
                    },
                    {
                        id : 2,
                        name : '상원이',
                        category : '가격 할인',
                        discount : '1000',
                        add_product : '',
                        price_condition : '10000',
                        start_date : '2018-02-03',
                        expiry_date : '2018=34=34'
                    }
                ],

                /* 번역할 내용 */
                trans : {
                    id : 0,
                    name : '',
                    category : '',
                    discount : 0,
                    add_product : '',
                    price_condition : 0,
                    start_date : '',
                    expiry_date : ''
                }
            }
        },
        created: function () {
            axios.post('/owner/getCouponList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                /* DB Coupon Data */
                var Index = response.data.couponNum;

                var Coupondata = response.data.coupon;

                this.items = Coupondata;
            })
        },
        methods : {
            /* 번역 */
            TransCoupon(item) {
                const index = this.items.indexOf(item);

                this.trans.id       = this.items[index].id;
                this.trans.name         = this.items[index].name;
                this.trans.category     = this.items[index].category;

                if(this.items[index].category == '상품 제공')
                {
                    this.trans.add_product = this.items[index].add_product;
                }
                else if(this.items[index].category == '가격 할인'){
                    this.trans.discount = this.items[index].discount;
                }

                this.trans.price_condition  = this.items[index].price_condition;
                this.trans.start_date       = this.items[index].start_date;
                this.trans.expiry_date      = this.items[index].expiry_date;


            },
            /* data보내기 */
            SpendData() {
                alert('쿠폰이 사용 되었습니다.');
                axios.post('/useCoupon', {
                    id          :  this.trans.id
                }).then(console.log('success')).catch(console.log('test '));
            },



            /* 사용된 쿠폰을 DB에서 삭제 하기 */
            Cancel(item) {
                const index     = this.items.indexOf(item)
                this.clickCoupon = this.items[index].id

                axios.post('/useCoupon', {
                    id          :   this.clickCoupon
                }).then(console.log('success')).catch(console.log('test '));


                alert('쿠폰이 삭제되었습니다.');
            }
        }
    }
</script>
<style>
    /* 반응형 웹 */
    /* 모바일 */
    @media (max-width: 639px){
        .Trans_Title {
            font-size:18px;
        }
        .Trans_Main {
            font-size: 14px;
        }
    }
    /* 테블릿 */
    @media (min-width: 640px) and (max-width: 1023px){
        .Trans_Title {
            font-size:20px;
        }
        .Trans_Main {
            font-size: 15px;
        }
    }
    /* 데스트 탑 */
    @media (min-width: 1024px){
        .Trans_Title {
            font-size:20px;
        }
        .Trans_Main {
            font-size: 15px;
        }
    }
</style>