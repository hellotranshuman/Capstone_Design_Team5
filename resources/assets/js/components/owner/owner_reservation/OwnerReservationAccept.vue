<template>
    <v-app>
        <div class="reservation_accept">
            <br>
            <h3><B>예약 수락</B></h3>
            신청한 예약을 수락 할 수 있습니다.
            <hr><br>
            <div class="coupon_table">
                <v-data-table
                        :headers="headers"
                        :items="items"
                        hide-actions
                        class="elevation-1"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left">{{ props.item.id }}</td>
                        <td>{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.reservation_date }}</td>
                        <td class="text-xs-left">{{ props.item.person }}</td>
                        <td class="text-xs-left">{{ props.item.child }}</td>
                        <td class="justify-center layout px-0">
                            <!-- 수락 버튼 -->
                            <v-btn color="primary" dark @click.stop="Acceptdialog = true"
                                   @click="AcceptCustomer = props.item.name, AcceptItem(props.item)"
                            >
                                Accept <v-icon dark right>check_circle</v-icon>
                            </v-btn>
                            <!-- 수락 Dislog -->
                            <v-dialog v-model="Acceptdialog" max-width="400px">
                                <v-card>
                                    <v-card-text>
                                        {{AcceptCustomer}}님의 예약이 수락 되었습니다.
                                    </v-card-text>
                                    <v-btn color="primary" @click.stop="Acceptdialog = false">
                                        확인
                                    </v-btn>
                                </v-card>
                            </v-dialog>
                            <!-- 거절 버튼 -->
                            <v-btn color="error" @click.stop="Canceldialog = true"
                                   @click="CancelItem(props.item), CancelCustomer = props.item.username"
                            >
                                <v-icon dark left>remove_circle</v-icon>Cancel
                            </v-btn>
                            <v-dialog v-model="Canceldialog" max-width="400px">
                                <v-card>
                                    <v-card-text>
                                        {{CancelCustomer}}님의 예약이 취소 되었습니다.
                                    </v-card-text>
                                    <v-btn color="error" @click.stop="Canceldialog = false">
                                    </v-btn>
                                </v-card>
                            </v-dialog>
                        </td>
                    </template>
                </v-data-table>
            </div>
        </div>
    </v-app>
</template>

<script>
    import VueAxios         from 'vue-axios';
    import axios            from 'axios';

    export default {
        data() {
            return {
                dialog: false,
                Acceptdialog : false,
                Canceldialog : false,

                /* 수락한손님 */
                AcceptCustomer : null,

                /* 취소한 손님 */
                CancelCustomer : null,

                headers: [
                    { text: '예약 번호',    value: 'id'},
                    { text: '예약자 명',    value: 'name' },
                    { text: '예약 날짜',    value: 'reservation_date' },
                    { text: '어른 인원',    value: 'person' },
                    { text: '아이 인원',    value: 'child' },
                    { text: '수락 & 거절',  value: 'Accept', sortable: false },
                ],

                /* 저장 & 편집 & 삭제 */
                items: [
                    {
                        username : 'ww'
                    }
                ]
            }
        },
        /* DB에서 데이터 값 받기 */
        created: function () {
            axios.post('/getReservationRequestList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                // <-- get ReservationRequest List
                // alert(response.data.resData);

                var reservationAccept = response.data.resData;

                this.items = reservationAccept;
            })
        },
        // 예약 수락, 거절 할 시 둘다 table delete!!!!!!!!!! 시켜주기
        methods: {
            AcceptItem (item) {
                const index = this.items.indexOf(item);
                this.CancelCustomer = this.items[index].username;

                axios.post('/acceptReservation', {
                    // 수락한 유저 이름
                    'name'     : this.AcceptCustomer,
                    'id'       : item.id,
                    'accept'   : true
                }).then((response) => {
                    location.reload();
                }).catch(console.log('test '));
            },

            CancelItem (item) {
                const index = this.items.indexOf(item);
                this.clickCouponid = this.items[index].username;

                axios.post('/acceptReservation', {
                    // 거절한 유저 이름
                    'name' : this.CancelCustomer,
                    'id'   : item.id,
                    'accept'   : false
                }).then((response) => {
                    location.reload();
                }).catch(console.log('test '));
            }
        }
    }
</script>
<style>
    .reservation_accept {
        padding-left: 5%;
        padding-right: 5%;
    }
</style>