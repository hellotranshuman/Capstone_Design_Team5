<!-- 유저 쿠폰함 -->
<template>
    <v-app>
        <div id="UserPageCoupon">
            <br>
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
                                                            <b> {{ trans.name }} </b>
                                                            <b> {{ trans.category }} </b>
                                                            <b> {{ trans.price_addpro }} </b>
                                                            <b> {{ trans.condition }} </b>
                                                            <b> {{ trans.usedate }} </b>

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

        <!-- snackbar -->
        <v-snackbar
                :timeout="1500"
                v-model="coupon_snackbar"
                :top="'top'"
                :vertical="'vertical'"
        >
            쿠폰이 사용 되었습니다.
            <v-btn flat color="cyan darken-2" @click.native="coupon_snackbar = false">Close</v-btn>
        </v-snackbar>

        <!-- snackbar -->
        <v-snackbar
                :timeout="1500"
                v-model="coupon_delete_snackbar"
                :top="'top'"
                :vertical="'vertical'"
        >
            쿠폰이 삭제 되었습니다.
            <v-btn flat color="cyan darken-2" @click.native="coupon_delete_snackbar = false">Close</v-btn>
        </v-snackbar>

        <v-snackbar
                :timeout="1500"
                v-model="coupon_usedateOver"
                :top="'top'"
                :vertical="'vertical'"
        >
            쿠폰 사용기한이 지났습니다.
            <v-btn flat color="cyan darken-2" @click.native="coupon_usedateOver = false">Close</v-btn>
        </v-snackbar>
    </v-app>
</template>

<script>
    import VueAxios from 'vue-axios';
    import axios from 'axios';

    export default {
        data() {
            return {
                spendDialog : false,
                clickCoupon : null,
                coupon_snackbar : false,
                coupon_delete_snackbar : false,
                coupon_usedateOver : false,

                /* 저장 & 편집 & 삭제 */
                items: [],

                /* 번역할 내용 */
                trans : {
                    name : '',
                    category : '',
                    price_addpro : '',
                    condition : '',
                    usedate : ''
                },

                couponId : 0,
            }
        },
        created: function () {
            axios.post('/getUserCouponList', {

            }).then((response) => {
                /* DB Coupon Data */

                var Coupondata = response.data.coupon_data;

                this.items = Coupondata;
            })
        },
        methods : {
            /* 번역 */
            TransCoupon(item) {
                const index = this.items.indexOf(item);
                this.couponId = this.items[index].id

                axios.post('/getCouponTransData', {
                    id          :  this.couponId
                }).then((response) => {
                    /* 번역 data 보내주기 */
                    let responseText = JSON.parse(response.data.content);

                    var translatedText = responseText.message.result.translatedText;

                    var transText = translatedText.split("#");

                    console.log(transText);

                    this.trans.name            = transText[0];
                    this.trans.category        = transText[1];
                    this.trans.price_addpro    = transText[2];
                    this.trans.condition       = transText[3];
                    this.trans.usedate         = transText[4];

                }).catch(console.log('test '));
            },
            /* data보내기 */
            SpendData() {
                this.coupon_snackbar = true;

                axios.post('/setCouponUpdate', {
                    id          :  this.couponId
                }).then((response) => {
                    if(response.data.msg == false)
                    {
                        this.coupon_usedateOver = true;
                    }
                }).catch(console.log('test '));
            },



            /* 사용된 쿠폰을 DB에서 삭제 하기 */
            Cancel(item) {
                const index     = this.items.indexOf(item)
                this.clickCoupon = this.items[index].id

                axios.post('/deleteUserCoupon', {
                    id          :   this.clickCoupon
                }).then((response) => {
                    if(response.data.msg == true)
                    {
                        location.reload();
                    }
                }).catch(console.log('test '));

                this.coupon_delete_snackbar = true;
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