<!-- 유저 쿠폰함 -->
<template>
    <v-app  id="UserPage">
        <div >
            <br>
            <h4 class="Main_title"><B>[ {{trans_userpage_coupon_title}} ]</B></h4><br>
            <v-tabs
                    color="brown dark-1"
                    slider-color="orange darken-1"
            >
                <v-tab style="color:white; font-size:17px">
                    &nbsp; {{trans_coupon_usecheck}} &nbsp;
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
                                                {{item.price_condition}}{{trans_baai}}, &nbsp; {{ item.menu_name }} {{trans_product}}
                                            </v-list-tile-sub-title>
                                            <v-list-tile-sub-title v-else-if="item.category == '가격 할인'">
                                                {{item.price_condition}}{{trans_baai}}, &nbsp; {{ item.discount }} {{trans_discount}}
                                            </v-list-tile-sub-title>
                                            <v-list-tile-sub-title>
                                                [ {{ item.start_date }} ~ {{ item.expiry_date}} ]
                                            </v-list-tile-sub-title>
                                        </v-list-tile-content>
                                        <!-- 아이콘 -->
                                        <v-list-tile-action>
                                            <!-- 쿠폰 번역 -->
                                            <v-btn flat icon color="orange darken-1" @click="spendDialog = true, TransCoupon(item)">
                                                <v-icon>aspect_ratio</v-icon> {{trans_use}}
                                            </v-btn>
                                            <!-- 번역 dialog -->
                                            <v-dialog
                                                    v-model="spendDialog"
                                                    hide-overlay
                                                    max-width="500px"
                                            >
                                                <v-card style="border: 10px solid #E7D7B7; margin-right:10%; margin-left:10%" >
                                                    <v-card-title>
                                                        <div class="Trans_Title" style="color:#9d724b">
                                                            <b> {{ trans.name }} </b>
                                                        </div>
                                                    </v-card-title>
                                                    <v-card-text>
                                                        <div class="Trans_Main" style="color:#6d4d35">
                                                            <b style="color:#9d724b"> {{trans_coupon_name}} : </b> {{ trans.name }}       <br>
                                                            <b style="color:#9d724b"> {{trans_coupon_category}} : </b>  {{ trans.category }} <br>
                                                            <b style="color:#9d724b">  {{ trans.price_addpro }} </b> <br>
                                                            <b style="color:#9d724b"> {{trans_coupon_condition}} : </b>{{ trans.condition }}  <br>
                                                            <b style="color:#9d724b"> {{trans_coupon_date}} : </b>{{ trans.start_date }} ~ {{ trans.expiry_date }}  <br>

                                                        </div>
                                                    </v-card-text>
                                                    <v-card-actions>
                                                        <v-btn color="orange darken-1" flat @click.stop="spendDialog=false" @click="SpendData()">{{trans_use}}</v-btn>
                                                        <v-btn color="error" flat @click.stop="spendDialog=false">Cancel</v-btn>
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
            {{trans_snackbar_coupon_use}}
            <v-btn flat color="orange darken-1" @click.native="coupon_snackbar = false">Close</v-btn>
        </v-snackbar>

        <!-- snackbar -->
        <v-snackbar
                :timeout="1500"
                v-model="coupon_delete_snackbar"
                :top="'top'"
                :vertical="'vertical'"
        >
            {{trans_snackbar_coupon_delete}}
            <v-btn flat color="orange darken-1" @click.native="coupon_delete_snackbar = false">Close</v-btn>
        </v-snackbar>

        <v-snackbar
                :timeout="1500"
                v-model="coupon_usedateOver"
                :top="'top'"
                :vertical="'vertical'"
        >
            {{trans_snackbar_coupon_dateover}}
            <v-btn flat color="orange darken-1" @click.native="coupon_usedateOver = false">Close</v-btn>
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
                items: [
                ],

                /* 번역할 내용 */
                trans : {
                    name : '',
                    category : '',
                    price_addpro : '',
                    condition : '',
                    start_date : '',
                    expiry_date : ''
                },

                couponId : 0,

                /* 번역 */
                country : '',

                trans_userpage_coupon_title : 'マイクーポン',
                trans_coupon_usecheck : '使用可能クーポン',
                trans_baai : '場合',
                trans_product : '提供',
                trans_discount : '割引',
                trans_use : '  使用',
                trans_coupon_name : 'クーポン名前',
                trans_coupon_category : ' カテゴリー',
                trans_coupon_condition : '使用条件',
                trans_coupon_date : '使用期限',
                trans_snackbar_coupon_use : 'クーポンを使用しました。',
                trans_snackbar_coupon_delete : 'クーポンを削除しました。',
                trans_snackbar_coupon_dateover : 'クーポンの試用期間ではありません。'





            }
        },
        created: function () {
            axios.post('/getUserCouponList', {
            }).then((response) => {
                /* DB Coupon Data */

                var Coupondata = response.data.coupon_data;

                this.items = Coupondata;
            })

            // 유저 국적
            this.country = this.$session.get('user_country');

            if(this.$session.get('user_country') == 'Korea')
            {
                this.trans_userpage_coupon_title = '마이 쿠폰함';
                this.trans_coupon_usecheck = '사용 가능한 쿠폰';
                this.trans_baai = '경우';
                this.trans_product = '제공';
                this.trans_discount = '할인';
                this.trans_use = '사용';
                this.trans_coupon_name = '쿠폰 명';
                this.trans_coupon_category = '카테고리';
                this.trans_coupon_condition = '사용 조건';
                this.trans_coupon_date = '사용 기간';

                // snackbar
                this.trans_snackbar_coupon_use = '쿠폰을 사용하였습니다.';
                this.trans_snackbar_coupon_delete = '쿠폰을 삭제하였습니다.';
                this.trans_snackbar_coupon_dateover = '쿠폰 사용 기한이 아닙니다.'
            }
            else if(this.$session.get('user_country') == 'China')
            {
                this.trans_userpage_coupon_title = '我的票盒';
                this.trans_coupon_usecheck = '可用的优惠券';
                this.trans_baai = '情况';
                this.trans_product = '提供';
                this.trans_discount = '折扣';
                this.trans_use = '使用';
                this.trans_coupon_name = '附息票';
                this.trans_coupon_category = '类别';
                this.trans_coupon_condition = '使用条件';
                this.trans_coupon_date = '使用期间';

                 // snackbar
                this.trans_snackbar_coupon_use = '使用优惠券。';
                this.trans_snackbar_coupon_delete = '已删除优惠券。';
                his.trans_snackbar_coupon_dateover = '不是优惠券使用期限。'

            }
            else if(this.$session.get('user_country') == 'USA')
            {
                this.trans_userpage_coupon_title = 'My CouponList';
                this.trans_coupon_usecheck = 'Coupons available';
                this.trans_baai = 'Case';
                this.trans_product = 'Provision';
                this.trans_discount = 'Discount';
                this.trans_use = 'Use';
                this.trans_coupon_name = 'Coupon Name';
                this.trans_coupon_category = 'Category';
                this.trans_coupon_condition = 'Conditions of use';
                this.trans_coupon_date = 'Period of use';

                 // snackbar
                this.trans_snackbar_coupon_use = 'Use a coupon.';
                this.trans_snackbar_coupon_delete = 'Delete a coupon';
                this.trans_snackbar_coupon_dateover = 'The coupon cant not use at date'
            }
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
                    var transText = response.data.couponData;

                    this.trans.name            = transText.name;
                    this.trans.category        = transText.category;
                    
                    if(transText.discount != null)
                    {
                        this.trans.price_addpro    = transText.discount;
                    }
                    else if(transText.add_product != null)
                    {
                        this.trans.price_addpro    = transText.menu_name;
                    }
                    
                    this.trans.condition          = transText.price_condition;
                    this.trans.start_date         = transText.start_date;
                    this.trans.expiry_date         = transText.expiry_date;

                }).catch(console.log('test '));
            },

            /* data보내기 */
            SpendData() {
                axios.post('/setCouponUpdate', {
                    id          :  this.couponId
                }).then((response) => {
                    if(response.data.msg == false)
                    {
                        this.coupon_usedateOver = true;
                    }
                    else {
                        this.coupon_snackbar = true;
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

    .Main_title {
        color: #6d4d35;
        font-size: 26px;
    }

    #UserPage {
        background-color: #efe2bd;
        padding-left: 7%;
        padding-right: 7%;
    }
</style>