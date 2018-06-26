<template>
    <v-app>
        <div class="ownerReservationSetting">
            <br>
            <h2 class="Main_title"><B>예약 설정</B></h2>
            <span class="sub_title"><B> 예약 관련된 설정을 할 수 있습니다. </B></span>
            <hr>
            <v-tabs
                    left
                    slider-color="orange darken-1"
            >
                <v-tab>
                    <!-- 주문 설정 -->
                    <h5><B>&nbsp; 예약 주문 설정 &nbsp;</B></h5>
                </v-tab>
                <v-tab-item>
                    <v-radio-group v-model="reservation_selectMenu" >
                        <B> 현재 상태 </B>: {{this.menuSelectData}} <br><br>
                        <v-radio label="주문 가능" value="true"></v-radio>
                        <v-radio label="주문 불가능" value="false"></v-radio>
                    </v-radio-group>
                    <v-btn style="color:white; background-color:#ff9a55" @click.native="menuoption_save">저장하기</v-btn>
                </v-tab-item>
                <v-tab>
                    <h5><B>&nbsp; 예약 날짜/시간 설정 &nbsp;</B></h5>
                </v-tab>
                <v-tab-item>
                    <br>
                    <v-dialog v-model="dialog" persistent max-width="500px">
                        <v-btn style="color:white; background-color:#ff9a55" dark slot="activator" @click="settime()">예약 설정 추가</v-btn>
                        <v-card style="border: 10px solid #efe2bd; ">
                            <!-- v-card title -->
                            <v-card-title>
                                <span  class="Main_title" style="margin:auto"> &nbsp;  <h3><B> <v-icon large> restaurant_menu </v-icon> &nbsp; 예약 설정 추가 </B></h3> </span>
                            </v-card-title>
                            <!-- v-card 본문 -->
                            <v-card-text>
                                <v-container grid-list-md>
                                    <v-layout wrap>
                                        <!-- 예약 설정 날짜 -->
                                        <v-flex xs11 >
                                            <!-- datepicker -->
                                            <v-menu
                                                    ref="menu"
                                                    lazy
                                                    :close-on-content-click="false"
                                                    v-model="menu"
                                                    transition="scale-transition"
                                                    offset-y
                                                    full-width
                                                    :nudge-right="40"
                                                    min-width="290px"
                                                    :return-value.sync="ReservationSettingItem.pick_date"
                                            >
                                                <v-text-field
                                                        slot="activator"
                                                        label="pick Date"
                                                        v-model="ReservationSettingItem.pick_date"
                                                        prepend-icon="event"
                                                        readonly
                                                        hint="예약 설정할 날짜 선택"
                                                        color="orange darken-1"
                                                        persistent-hint
                                                ></v-text-field>

                                                <v-date-picker
                                                        v-model="ReservationSettingItem.pick_date"
                                                        no-title
                                                        scrollable
                                                        color="orange darken-1"
                                                >
                                                    <v-spacer></v-spacer>
                                                    <v-btn flat style="color:#ff9a55" @click="menu = false">Cancel</v-btn>
                                                    <v-btn flat style="color:#ff9a55" @click="$refs.menu.save(ReservationSettingItem.pick_date)">OK</v-btn>
                                                </v-date-picker>
                                            </v-menu>
                                        </v-flex>
                                        <br><br>
                                        <v-flex xs11 >
                                            <!-- 예약 가능 / 불가능 -->
                                            <v-radio-group
                                                    v-model="ReservationSettingItem.impossible"
                                                    :mandatory="false"
                                                    row
                                                    color="orange darken-1"
                                            >
                                                <v-radio color="orange darken-1" label="예약 가능" value="예약 가능"></v-radio>
                                                <v-radio color="orange darken-1" label="예약 불가능" value="예약 불가능"></v-radio>
                                            </v-radio-group>
                                        </v-flex>
                                        <!-- 예약 시간 설정 -->
                                        <v-flex v-if="this.ReservationSettingItem.impossible == '예약 가능'">
                                            예약 가능한 시간대를 설정해 주세요.
                                            <v-select
                                                    :items="time_item"
                                                    v-model="ReservationSettingItem.reservation_time"
                                                    multiple
                                                    label="Select"
                                                    class="input-group--focused"
                                                    color="orange darken-1"
                                                    item-value="text"
                                            ></v-select>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card-text>
                            <v-card-actions>
                                <v-spacer></v-spacer>
                                <v-btn style="color:white; background-color:#6d4d35" @click.native="dialog = false">Close</v-btn>
                                <v-btn style="color:white; background-color:#ff9a55" @click="check()">Save</v-btn>

                            </v-card-actions>
                        </v-card>
                    </v-dialog>
                    <div>
                        <br>
                        <div class="reservation_calender">
                            <v-layout justify-space-between wrap>
                                <v-flex class="my-3">
                                    <v-date-picker
                                            v-model="reservationCal"
                                            event-color="error"
                                            :events="arrayEvents"
                                            color="orange darken-1"
                                    >
                                    </v-date-picker>
                                </v-flex>
                                <v-btn style="color:white; background-color:#6d4d35" @click="date_click()"> 조회하기 </v-btn>
                            </v-layout>

                        </div>
                        <div class="reservation_set_table">
                            <br>
                            <v-data-table
                                    :headers="headers"
                                    :items="items"
                                    hide-actions
                                    class="elevation-1"
                            >
                                <template slot="items" slot-scope="props">
                                    <td class="text-xs-left">{{ props.item.setting_date }}</td>
                                    <td class="text-xs-left" v-if="props.item.remark == 1">예약 가능</td>
                                    <td class="text-xs-left" v-else>예약 불가능</td>
                                    <td class="text-xs-left">{{ props.item.start_time }}</td>
                                    <td class="text-xs-left">{{ props.item.end_time }}</td>
                                    <td class="justify-center layout px-0">
                                        <v-btn icon class="mx-0"    @click="deleteItem(props.item)"
                                        >
                                            <v-icon color="pink">delete</v-icon>
                                        </v-btn>
                                    </td>
                                </template>
                            </v-data-table>
                        </div>
                    </div>
                </v-tab-item>
            </v-tabs>
        </div>

        <!-- snackbar -->
        <v-snackbar
                :timeout="1500"
                v-model="menuoption_snackbar"
                :top="'top'"
                :vertical="'vertical'"
        >
            예약 주문 상태가 설정 되었습니다.
            <v-btn flat color="cyan darken-2" @click.native="menuoption_snackbar = false">Close</v-btn>
        </v-snackbar>

        <!-- snackbar -->
        <v-snackbar
                :timeout="1500"
                v-model="setdialog"
                :top="'top'"
                :vertical="'vertical'"
        >
            예약 설정이 삭제 되었습니다.
            <v-btn flat color="cyan darken-2" @click.native="setdialog = false">Close</v-btn>
        </v-snackbar>

        <!-- 예약 설정 추가 -->
        <v-snackbar
                :timeout="1500"
                v-model="reservation_set_snackbar"
                :top="'top'"
                :vertical="'vertical'"
        >
            {{reservation_text}}
            <v-btn flat color="cyan darken-2" @click.native="reservation_set_snackbar = false">Close</v-btn>
        </v-snackbar>

    </v-app>
</template>

<script>
    import VueAxios         from 'vue-axios';
    import axios            from 'axios';

    export default {
        data() {
            return {
                /* snackbar */
                menuoption_snackbar : false,
                reservation_set_snackbar : false,
                reservation_text : '',

                /* dialog */
                setdialog : false,

                /* click */
                clickItem : null,

                /* Add ReservationSetting */
                dialog: false,

                /* 예약 가능인가 불가능인가 */
                impossible : '',

                /* 메뉴 선택 가능여부 */
                reservation_selectMenu : false,
                menuSelectData : '',

                /* date picker */
                pick_date: null,
                menu: false,
                modal: false,

                /* time picker */
                // select 목록
                time_item : [],
                lunch_open   : '11:30',
                lunch_close  : '14:30',
                dinner_open  : '16:00',
                dinner_close : '22:30',

                /* reservation_Date */
                reservationCal: null,
                arrayEvents: [],
                date: null,

                /* table */
                dialog: false,

                headers: [
                    { text: '예약 날짜', value: 'setting_date' },
                    { text: '예약 가능 여부', value: 'remark' },
                    { text: '예약 가능 시작 시간', value: 'start_time' },
                    { text: '예약 가능 끝나는 시간', value: 'end_time'},
                    { text: 'Actions', value: 'name', sortable: false }
                ],

                /* 저장 & 편집 & 삭제 */
                items: [],
                ReservationSettingItem: {
                    pick_date: null,
                    impossible : null,
                    reservation_time : [],
                }
            }
        },
        /* Data값 받기 */
        created: function () {
            axios.post('/getReservationSettingList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                var reservationSettingData = response.data.settingData;
                this.items   = reservationSettingData;
                this.resData = response.data.restaurantData;

                /* 가게 lunch.dinner open/close */
                this.lunch_open = this.resData[0].lunch_open;
                this.lunch_close = this.resData[0].lunch_close;
                this.dinner_open = this.resData[0].dinner_open;
                this.dinner_close = this.resData[0].dinner_close;

                this.menuSelectData = response.data.menuSelectData[0].reservation_selectMenu;

                if(this.menuSelectData == true)
                {
                    this.menuSelectData = '주문 가능';
                }
                else if(this.menuSelectData == false){
                    this.menuSelectData = '주문 불가능';
                }

                this.checkDate();
            })


        },

        mounted () {
            this.arrayEvents
            const d = new Date()
            d.toISOString().substr(0, 10);
            return d.toISOString().substr(0, 10);
        },

        methods: {
            /* 그 날짜에 가능.불가능이 존재하는지 파악 */
            check() {
                var date        = this.ReservationSettingItem.pick_date;
                var index       = this.items.length;
                var res_check   = 0;
                var impossible  = false;

                // impossible -> true / false
                if(this.ReservationSettingItem.impossible == "예약 가능")
                {
                    impossible = 1;
                }
                else {
                    impossible = 0;
                }




                if(index != 0)
                {
                    for(var i = 0; i < index; i++)
                    {
                        // 그 날짜가 items안에 있을 경우
                        if(date == this.items[i].setting_date)
                        {
                            // 그날짜의
                            if(this.items[i].remark != impossible)
                            {
                                this.reservation_text = '같은 날짜에 다른 설정(예약 가능/불가능)이 존재할 수 없습니다.';
                                this.reservation_set_snackbar = true;
                                res_check = false;
                                break;
                            }
                            else {
                                res_check = true;
                                break;
                            }
                        }
                        else {
                            res_check = true;
                            break;
                        }
                    }
                }
                else {
                    res_check = true;
                }

                if(res_check == true)
                {
                    this.save();
                }

            },

            date_click(){
                axios.post('/getReservationSettingByDate', {
                    'click_date'        : this.reservationCal,
                    'shop_id'           : this.$route.params.shop_id
                }).then((response) => {
                    var settingData = response.data.settingData;
                    console.log(settingData);
                    if(this.items != null)
                    {
                        this.items = null,
                            this.items = settingData;
                    }
                    else {
                        this.items = settingData;
                    }

                })
                    .catch(console.log('test'));
            },

            // 예약 불가능 날짜 설정 메서드
            checkDate() {
                var itemIndex   = this.items.length;
                for(var i = 0; i < itemIndex; i++)
                {
                    if(this.items[i].remark === 0)
                    {
                        this.arrayEvents.push(this.items[i].setting_date)
                    }
                    else {
                        this.arrayEvents.push(1)
                    }
                }
            },
            // 가게 시간 업로드 매서드
            settime() {
                // 점심 "11:00 -> 11"
                var lunch_open_hour     = parseInt(this.lunch_open.substr(0, 2))
                var lunch_close_hour    = parseInt(this.lunch_close.substr(0,2))
                var lunch_open_minute   = this.lunch_open.substr(3,2)
                var lunch_close_minute  = this.lunch_close.substr(3,2)
                // 저녁
                var dinner_open_hour    = parseInt(this.dinner_open.substr(0, 2))
                var dinner_close_hour   = parseInt(this.dinner_close.substr(0,2))
                var dinner_open_minute  = this.dinner_open.substr(3,2)
                var dinner_close_minute = this.dinner_close.substr(3,2)

                // 시
                var hour;
                var lunch_minute = lunch_open_minute;
                var dinner_minute = dinner_open_minute;

                // 점심 시작 - 점심 끝
                for(var i = lunch_open_hour; i <= lunch_close_hour; i++)
                {
                    hour = i;
                    // 시작) 분 : 00
                    if(lunch_minute == '00')
                    {
                        this.time_item.push(hour + ":" + lunch_minute);
                        if(hour == lunch_close_hour && lunch_close_minute != '30')
                        {
                            break;
                        }
                        else {
                            lunch_minute = '30';
                            this.time_item.push(hour + ":" + lunch_minute);
                        }
                        lunch_minute = '00';
                    }
                    else if(lunch_minute == '30')
                    {
                        this.time_item.push(hour + ":" + lunch_minute);
                        lunch_minute = '00';
                    }

                }

                for(var i = dinner_open_hour; i <= dinner_close_hour; i++)
                {
                    hour = i;
                    // 시작) 분 : 00
                    if(dinner_minute == '00')
                    {
                        this.time_item.push(hour + ":" + dinner_minute);
                        if(hour == dinner_close_hour && dinner_close_minute != '30')
                        {
                            break;
                        }
                        else {
                            dinner_minute = '30';
                            this.time_item.push(hour + ":" + dinner_minute);
                        }
                        dinner_minute = '00';
                    }
                    else if(dinner_minute == '30')
                    {
                        this.time_item.push(hour + ":" + dinner_minute);
                        dinner_minute = '00';
                    }

                }
            },

            deleteItem (item) {
                this.setdialog = true;
                const index = this.items.indexOf(item);
                this.clickItem = this.items[index].resset_num;

                axios.post('/deleteReservationSetting', {
                    'id'                : this.clickItem,
                }).then((response) => {

                    if(response.data.flag === 'true')
                        location.reload();
                })
                    .catch(console.log('test'));
            },
            menuoption_save() {
                /* Data 송신 */
                axios.post('/updateReservationSelectMenu', {
                    shop_id         : this.$route.params.shop_id,
                    reservation_selectMenu     : this.reservation_selectMenu
                }).then((response) => {
                    this.menuoption_snackbar = true;
                    location.reload();
                })
                    .catch(console.log('test'));
            },
            save() {
                var check = true;

                if(this.ReservationSettingItem.pick_date == null)
                {
                    this.reservation_text = " 예약 설정 날짜를 선택 해주세요."
                    this.reservation_set_snackbar = true;
                    var check = false;
                }
                else if(this.ReservationSettingItem.reservation_time == null)
                {
                    this.reservation_text = " 예약 가능 시간대를 선택 해주세요."
                    this.reservation_set_snackbar = true;
                    var check = false;
                }


                if(check == true) {
                    /* Data 송신 */
                    axios.post('/setReservationSetting', {
                        shop_id           : this.$route.params.shop_id,
                        setting_date      : this.ReservationSettingItem.pick_date,
                        impossible        : this.ReservationSettingItem.impossible,
                        set_time          : this.ReservationSettingItem.reservation_time,
                        /* 배열 개수 */
                        set_time_length   : this.ReservationSettingItem.reservation_time.length,

                        /* 달력 날짜 클릭 시 넘어오는 날짜 값 */
                        click_date        : this.reservationCal
                    }).then((response) => {
                        location.reload();
                    })
                        .catch(console.log('test'));

                    this.dialog = false
                }
            }
        }
    }
</script>
<style>
    .Main_title {
        color: #6d4d35;
    }

    .sub_title {
        color : #9d724b;
    }

    .reservation_calender {
        float: left;
        width: 20%;
        padding-left: 1%;
    }

    .reservation_set_table {
        float: left;
        padding-left : 10%;
    }
    .ownerReservationSetting {
        padding-left : 2%;
        padding-right : 2%;
    }
</style>