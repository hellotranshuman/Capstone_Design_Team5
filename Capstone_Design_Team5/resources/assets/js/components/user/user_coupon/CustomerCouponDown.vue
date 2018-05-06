<template>
    <v-app>
        <div>
        <v-btn color="error" dark @click.stop="dialog2 = true">쿠폰 다운 받기</v-btn>
        <v-dialog v-model="dialog2" max-width="700px">
            <v-card>
                <v-card-title>
                    <h3><B>쿠폰 다운 받기</B></h3>
                    <br>
                </v-card-title>
                <v-card-text>
                    <v-data-table
                        :headers="headers"
                        :items="items"
                        hide-actions
                        class="elevation-1"
                    >
                        <template slot="items" slot-scope="props">
                            <td>{{ props.item.name }}</td>
                            <td class="text-xs-left">{{ props.item.category }}</td>
                            <td class="text-xs-left">{{ props.item.discount }}</td>
                            <td class="text-xs-left">{{ props.item.add_product }}</td>
                            <td class="text-xs-left">{{ props.item.price_condition }}</td>
                            <td class="justify-center layout px-0">
                            <v-btn flat icon color="red lighten-2"   @click.stop="DownDialog = true" @click="clickCouponname = props.item.name">
                                <v-icon dark right>file_download</v-icon>
                            </v-btn>
                            </td>
                            <!-- Download 아이콘을 눌렀으때 -->
                            <v-dialog v-model="DownDialog" max-width="500px">
                                <v-card>
                                <v-card-title>
                                    {{ clickCouponname }} 을 다운 받으시겠습니까?
                                </v-card-title>
                                <v-card-actions>
                                    <v-btn color="primary" flat @click.stop="DownDialog=false, Download(props.item),Okey()">확인</v-btn>
                                    <v-btn color="primary" flat @click.stop="DownDialog=false" @click=" clickCouponname = null">취소</v-btn>
                                </v-card-actions>
                                </v-card>
                            </v-dialog>
                        </template>
                    </v-data-table>
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

            /* table */
            headers: [
                { text: '쿠폰 이름',    value: 'name' },
                { text: '쿠폰 종류',    value: 'category' },
                { text: '할인율',    value: 'discount' },
                { text: '제공 상품',    value: 'add_product' },
                { text: '쿠폰 조건',    value: 'price_condition' },
                { text: 'Actions', value: 'name', sortable: false }
            ],

            items: [
                
            ]
        }
    },
    created : {
        /* CounponData 받기 */
        userCouponList() {
            axios.post('/userCoupon');
            this.axios.then((response) => {
                /* DB Coupon Data */
                console.log(response.Coupondata);

                var Coupondata = response.data.coupon;
                
                this.items = Coupondata;
            }      
        )}
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
          confirm('쿠폰함에 쿠폰이 다운되었습니다.')
        }
    }
}
</script>
<style>

</style>
