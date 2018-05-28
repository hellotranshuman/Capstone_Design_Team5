<template>
    <v-app>
        <div class="Reservation_list">
            <br>
            <h3><B>예약 현황</B></h3>
            현재 예약 현황을 알 수 있습니다.
            <hr><br>
            <v-dialog v-model="dialog" persistent max-width="500px">
                <v-btn color="#424242" dark slot="activator">예약 추가</v-btn>
                <v-card>
                    <!-- v-card title -->
                    <v-card-title>
                        <span class="headline">예약 추가</span>
                    </v-card-title>
                    <!-- v-card 본문 -->
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <!-- 예약자 이름 -->
                                <v-flex xs12>
                                    <v-text-field label="예약자 명" required v-model="ReservationItem.usernum"></v-text-field>
                                </v-flex>
                                <!-- 예약 날짜 -->
                                <v-flex xs11 sm5 >
                                    <!-- datepicker -->
                                    <v-menu
                                            ref="reservation_menu"
                                            lazy
                                            :close-on-content-click="false"
                                            v-model="reservation_menu"
                                            transition="scale-transition"
                                            offset-y
                                            full-width
                                            :nudge-right="40"
                                            min-width="290px"
                                            :return-value.sync="ReservationItem.start_date"
                                    >
                                        <v-text-field
                                                slot="activator"
                                                label="pick Date"
                                                v-model="ReservationItem.start_date"
                                                prepend-icon="event"
                                                readonly
                                        ></v-text-field>

                                        <v-date-picker v-model="ReservationItem.start_date" no-title scrollable>
                                            <v-spacer></v-spacer>
                                            <v-btn flat color="primary" @click="reservation_menu = false">Cancel</v-btn>
                                            <v-btn flat color="primary" @click="$refs.reservation_menu.save(ReservationItem.start_date)">OK</v-btn>
                                        </v-date-picker>
                                    </v-menu>
                                </v-flex>
                                <!-- 예약 시간 -->
                                <v-flex xs11 sm5>
                                    <v-menu
                                            ref="menu"
                                            lazy
                                            :close-on-content-click="false"
                                            v-model="menu2"
                                            transition="scale-transition"
                                            offset-y
                                            full-width
                                            :nudge-right="40"
                                            max-width="290px"
                                            min-width="290px"
                                            :return-value.sync="ReservationItem.time"
                                    >
                                        <v-text-field
                                                slot="activator"
                                                label="pick Time"
                                                v-model="ReservationItem.time"
                                                prepend-icon="access_time"
                                                readonly
                                        ></v-text-field>
                                        <v-time-picker v-model="ReservationItem.time" @change="$refs.menu.save(ReservationItem.time)"></v-time-picker>
                                    </v-menu>
                                </v-flex>
                                <!-- 인원수 -->
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="어른 인원" required v-model="ReservationItem.adult_person"></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="아이 인원" required v-model="ReservationItem.child_person"></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn color="blue darken-1" flat @click.native="dialog = false">Close</v-btn>
                        <v-btn color="blue darken-1" flat @click.native="save">Save</v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
            <div class="coupon_table">
                <v-data-table
                        :headers="headers"
                        :items="items"
                        hide-actions
                        class="elevation-1"
                >
                    <template slot="items" slot-scope="props">
                        <td class="text-xs-left">{{ props.item.name }}</td>
                        <td class="text-xs-left">{{ props.item.reservation_date }}</td>
                        <td class="text-xs-left">{{ props.item.person }}</td>
                        <td class="text-xs-left">{{ props.item.child }}</td>
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
                /* dialog */
                Dialog : false,

                /* date picker */
                start_date: null,
                reservation_menu: false,
                modal: false,

                /* time picker */
                time: null,
                menu2: false,
                modal2: false,

                /* clickItem */
                clickId : 0,

                /* table */
                dialog: false,
                headers: [
                    { text: '예약자 명', value: 'name' },
                    { text: '예약 날짜/시간', value: 'reservation_date' },
                    { text: '어른', value: 'person' },
                    { text: '아이', value: 'child' },
                ],

                /* 저장 & 편집 & 삭제 */
                items: [
                    {
                        id : 1,
                        name: '윤진주',
                        reservation_date: '2018-01-02',
                        time: '11:00',
                        person: 1,
                        child: 1,
                        menuList : '갈비찜 1개'
                    }
                ],
                ReservationItem: {
                    name            : '',
                    reservation_date: '',
                    person          : 0,
                    child           : 0,
                    menuList        : ''
                }
            }
        },
        // DB에서 값 받기
        created: function () {
            axios.post('/getReservationList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                /* DB Coupon Data */
                console.log(response.data.resData);

                var ReservationListData = response.data.resData;

                this.items = ReservationListData;
            })
        },
        methods: {
            close () {
                this.dialog = false
            },

            save () {
                /* Data 송신 */
                axios.post('/', {
                    username        : this.ReservationItem.username,
                    start_date      : this.ReservationItem.start_date,
                    time            : this.ReservationItem.time,
                    adult_person    : this.ReservationItem.adult_person,
                    child_person    : this.ReservationItem.child_person
                }).then((response) => {
                    location.reload();
                })
                    .catch(console.log('test'));

                this.close()
            }
        }
    }
</script>
<style>
    .Reservation_list {
        padding-left: 5%;
        padding-right: 5%;
    }
</style>