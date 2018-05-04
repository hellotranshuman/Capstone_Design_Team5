<!-- 유저 쿠폰함 -->
<template>
    <v-app>
        <div style="margin-left:20px; margin-right:20px;">
            <br>
            <B>{{userName}}</B> 님 반갑습니다.
            <hr>
            <h4><B> 나의 할인쿠폰 </B></h4><br>
            <v-tabs color="dark"
                    dark
                    slider-color="red"
            >
                <v-tab>
                    사용 가능한 쿠폰       
                </v-tab>
                <v-tab-item
                >
                    <v-card flat>
                        <v-data-table
                            :headers="headers"
                            :items="items"
                            hide-actions
                            class="userCouponTable"
                        >
                            <template slot="items" slot-scope="props">
                                <td>{{ props.item.name }}</td>
                                <td class="text-xs-right">{{ props.item.category }}</td>
                                <td class="text-xs-right">{{ props.item.discount }}</td>
                                <td class="text-xs-right">{{ props.item.add_product }}</td>
                                <td class="text-xs-right">{{ props.item.price_condition }}</td>
                                <td class="text-xs-right">{{ props.item.start_date }}</td>
                                <td class="text-xs-right">{{ props.item.expiry_date }}</td>
                                <td class="justify-center layout px-0">
                                    <v-btn color="red" style="color:white" @click.native.stop="dialog = true"> 쿠폰 사용 </v-btn>
                                    <!-- 쿠폰 상세 목록 ( 번역 ) -->
                                     <v-dialog v-model="dialog" max-width="290">
                                        <v-card>
                                            <v-card-title>
                                                <h3>{{ props.item.name }}</h3>
                                            </v-card-title>
                                            <v-card-text>
                                                <B>쿠폰 종류 : </B>{{ props.item.category }} <br>
                                                <B>할인 가격 : </B>{{ props.item.discount }} <br>
                                                <B>상품 제공 : </B>{{ props.item.add_product }} <br>
                                                <B>쿠폰 조건 : </B>{{ props.item.price_condition }} <br>
                                                <B>사용 기간 : </B>{{ props.item.start_date }} ~ {{ props.item.expiry_date }}
                                            </v-card-text>
                                            <v-card-actions>
                                                <v-spacer></v-spacer>
                                                <v-btn color="error" flat="flat" @click.native="dialog = false"  @click="SpendData(props.item)">사용하기</v-btn>
                                                <v-btn color="error" flat="flat" @click.native="dialog = false" @click="clickCoupon = null"> 취소</v-btn>
                                            </v-card-actions>
                                        </v-card>
                                    </v-dialog>
                                </td>
                            </template>
                        </v-data-table>
                    </v-card>
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
                dialog : false,
                clickCoupon : null,

                headers: [
                    { text: '쿠폰 이름',    value: 'name' },
                    { text: '쿠폰 종류',    value: 'category' },
                    { text: '할인율',       value: 'discount' },
                    { text: '제공 상품',    value: 'add_product' },
                    { text: '쿠폰 조건',    value: 'price_condition' },
                    { text: '사용 시작일',  value: 'start_date' },
                    { text: '사용 종료일',  value: 'end_date' },
                    { text: 'Actions',     value: 'name', sortable: false }
                ],

                /* 저장 & 편집 & 삭제 */
                items: [],
                CouponItem: {
                    CouponName: '',
                    CouponType: '',
                    Discount: null,
                    addproduct: null,
                    Condition: '',
                    start_date: '',
                    end_date: ''
                }
            }
        },
        created: function () {
             axios.post('/owner/getCouponList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                alert(response.data.coupon);
                /* DB Coupon Data */
                var Index = response.data.couponNum;
                console.log(response.data.coupon);

                var Coupondata = response.data.coupon;

                this.items = Coupondata;
            })
        },
        methods : {
            /* 사용된 쿠폰을 DB에서 삭제 하기 */
            SpendData(item) {
                const index = this.items.indexOf(item)
                this.clickCoupon = this.items[index].id

                axios.post('/useCoupon', {
                    id          :   this.clickCoupon
                }).then(console.log('success')).catch(console.log('test '));
                

                confirm('쿠폰이 사용 되었습니다.');
            }
        }
    }
</script>

<style>

</style>
