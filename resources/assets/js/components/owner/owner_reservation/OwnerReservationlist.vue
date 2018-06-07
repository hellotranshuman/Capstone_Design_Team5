<template>
    <v-app>
        <div class="Reservation_list">
            <br>
            <h3><B>예약 현황</B></h3>
            현재 예약 현황을 알 수 있습니다.
            <hr><br>
            <v-dialog v-model="dialog" persistent max-width="500px">
                <v-btn color="teal lighten-1" slot="activator" style="color:white">예약 추가</v-btn>
                <v-card>
                    <v-toolbar color="teal lighten-1" style="height:20px">
                    </v-toolbar>
                    <!-- v-card title -->
                    <v-card-title>
                        <span class="headline" style="margin:auto"><B>예약 추가</B></span>
                    </v-card-title>
                    <!-- v-card 본문 -->
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <!-- 예약자 이름 -->
                                <v-flex xs12>
                                    <v-text-field  prepend-icon="face" label="예약자 명" required v-model="ReservationItem.usernum"></v-text-field>
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
                        <v-btn color="teal lighten-1" flat @click.native="dialog = false">Close</v-btn>
                        <v-btn color="teal lighten-1" flat @click.native="save">Save</v-btn>
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
                        <td class="text-xs-left">{{ props.item.time }}</td>
                        <td class="text-xs-left">{{ props.item.person }}</td>
                        <td class="text-xs-left">{{ props.item.child }}</td>

                        <td class="justify-left" v-if="props.item.menu_select == true">
                            <!-- 메뉴 보기 버튼 -->
                            <v-btn flat small color="teal lighten-1" @click="menu(props.item), menuLoad = true">메뉴보기</v-btn>
                            <v-dialog v-model="menuLoad" max-width="500px">
                                <v-toolbar color="teal lighten-1">
                                    <h3 style="color:white; margin:auto" > MENU </h3>
                                </v-toolbar>
                                <v-card>
                                    <v-card-text style="color : black">
                                        <B> {{orderMenu}} </B>
                                    </v-card-text>
                                    <v-btn color="teal lighten-1"
                                           style="color:white"
                                           @click.stop="menuLoad = false"
                                    >
                                        확인
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
                /* dialog */
                Dialog : false,
                menuLoad : false,

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
                    { text: '예약 날짜', value: 'reservation_date' },
                    { text: '예약 시간', value: 'time' },
                    { text: '어른', value: 'person' },
                    { text: '아이', value: 'child' },
                    { text: '메뉴',    value: 'menu_select' },
                ],

                /* 저장 & 편집 & 삭제 */
                items: [
                ],
                ReservationItem: {
                    name            : '',
                    reservation_date: '',
                    person          : 0,
                    child           : 0,
                    menuList        : ''
                },

                orderMenu : null,
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
            menu(item) {
                const index = this.items.indexOf(item)
                var reservation_id = this.items[index].id;

                this.orderMenu = reservation_id;

                axios.post('/getReservationMenuList', {
                    id : reservation_id
                }).then((response) => {
                    var MenuorderData = response.data.currentOrder;

                    console.log(response.data.currentOrder);

                    // 임시
                    var MenuArray = '';

                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData.length; i++)
                    {
                        MenuArray = (i+1)+'번 :' + MenuorderData[i]['menu_name' + (i+1)]
                            + ' 가격:' + MenuorderData[i]['menu_price' + (i+1)];

                        // 옵션 개수...도..
                        var OptionCount = MenuorderData[i]['optionNum'+(i+1)];

                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuArray += ' ' + MenuorderData[i]['menu'+(i+1)+'-'+'option'+(j+1)]
                                + ':' + MenuorderData[i]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                        }

                        console.log(MenuArray);
                        this.orderMenu = MenuArray;
                    }
                });
            },

            save () {
                /* Data 송신 */
                axios.post('/setOwnerReservation', {
                    shop_id         : this.$route.params.shop_id,
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