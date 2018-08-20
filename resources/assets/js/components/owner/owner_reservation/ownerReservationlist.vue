<template>
    <v-app>
        <div class="Reservation_list">
            <br>
            <h2 class="Main_title"><B>予約リスト</B></h2>
            <span class="sub_title"> 現在の予約リストを見せてくれます。 </span>
            <hr><br>
            <v-dialog v-model="dialog" persistent max-width="500px">
                <v-btn  style="color:white; background-color:#ff9a55" 
                        slot="activator" 
                >
               予約追加
                </v-btn>
                <v-card style="border: 10px solid #efe2bd; ">
                    <!-- v-card title -->
                    <v-card-title>
                        <span class="Main_title" style="margin:auto"><h3><B>予約追加</B></h3></span>
                    </v-card-title>
                    <!-- v-card 본문 -->
                    <v-card-text>
                        <v-container grid-list-md>
                            <v-layout wrap>
                                <!-- 예약자 이름 -->
                                <v-flex xs12>
                                    <v-text-field  
                                        prepend-icon="face" 
                                        label="予約者名" 
                                        required 
                                        v-model="ReservationItem.name"
                                        color="orange darken-1"
                                ></v-text-field>
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
                                                label="予約日"
                                                v-model="ReservationItem.start_date"
                                                prepend-icon="event"
                                                readonly
                                                color="orange darken-1"
                                        ></v-text-field>

                                        <v-date-picker v-model="ReservationItem.start_date" 
                                                no-title scrollable
                                                color="orange darken-1"
                                        >
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
                                                label="予約時間"
                                                v-model="ReservationItem.time"
                                                prepend-icon="access_time"
                                                readonly
                                                color="orange darken-1"
                                        ></v-text-field>
                                        <v-time-picker v-model="ReservationItem.time" 
                                                    @change="$refs.menu.save(ReservationItem.time)"
                                                    color="orange darken-1"
                                                    ></v-time-picker>
                                    </v-menu>
                                </v-flex>
                                <!-- 인원수 -->
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="大人数" 
                                            required 
                                            v-model="ReservationItem.adult_person"
                                            color="orange darken-1"
                                    ></v-text-field>
                                </v-flex>
                                <v-flex xs12 sm6 md4>
                                    <v-text-field label="子供数" 
                                            required 
                                            v-model="ReservationItem.child_person"
                                            color="orange darken-1"
                                    ></v-text-field>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card-text>
                    <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-btn style="color:white; background-color:#6d4d35" @click.native="dialog = false">Close</v-btn>
                        <v-btn style="color:white; background-color:#ff9a55" @click.native="save">Save</v-btn>
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
                        <td class="text-xs-left">{{ props.item.reservation_name }}</td>
                        <td class="text-xs-left">{{ props.item.reservation_date }}</td>
                        <td class="text-xs-left">{{ props.item.person }}</td>
                        <td class="text-xs-left">{{ props.item.child }}</td>

                        <td class="justify-left" v-if="props.item.menu_select == true">
                            <!-- 메뉴 보기 버튼 -->
                            <v-btn flat small color="teal lighten-1" @click="menu(props.item), menuLoad = true">メーニュー選択</v-btn>
                            <v-dialog v-model="menuLoad" max-width="500px">
                                <v-toolbar color="teal lighten-1">
                                    <h3 style="color:white; margin:auto" > メーニュー </h3>
                                </v-toolbar>
                                <v-card>
                                    <v-card-text style="color : black">
                                        <div
                                                v-for="(card, index) in orderMenu"
                                                :key="index"
                                        >
                                            <B> {{orderMenu[index]}} </B>
                                        </div>
                                    </v-card-text>
                                    <v-btn color="teal lighten-1"
                                           style="color:white"
                                           @click.stop="menuLoad = false"
                                    >
                                        確認
                                    </v-btn>
                                </v-card>
                            </v-dialog>
                        </td>

                    </template>
                </v-data-table>
            </div>
        </div>

        <!-- error snackbar -->
        <v-snackbar
                :timeout="1000"
                v-model="addreservation_snackbar"
                :top="'top'"
        >
            <v-icon dark>announcement</v-icon> {{ addreservation_text }}
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
                addreservation_snackbar : false,
                addreservation_text     : '予約者名を入力してください。',
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
                    { text: '予約者名',         value: 'reservation_name' },
                    { text: '予約日・時間',     value: 'reservation_date' },
                    { text: '大人数',           value: 'person' },
                    { text: '子供数',           value: 'child' },
                    { text: 'メーニュー',       value: 'menu_select' },
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
                orderMenu : [],
            }
        },
        // DB에서 값 받기
        created: function () {
            axios.post('/getReservationList', {
                'shop_id' : this.$route.params.shop_id
            }).then((response) => {
                var ReservationListData = response.data.resData;
                var ReservationArray = [];
                for(var i = 0; i < ReservationListData.length; i++)
                {
                    ReservationArray[i] = [];
                    if(ReservationListData[i].reservation_name == null)
                    {
                        ReservationArray[i]['reservation_name'] = ReservationListData[i].user_name;
                    }
                    else
                    {
                        ReservationArray[i]['reservation_name'] =ReservationListData[i].reservation_name;
                    }
                    ReservationArray[i]['reservation_date']   = ReservationListData[i].reservation_date;
                    ReservationArray[i]['person']             = ReservationListData[i].person;
                    ReservationArray[i]['child']              = ReservationListData[i].child;
                    ReservationArray[i]['menu_select']        = ReservationListData[i].menu_select;
                }
                this.items = ReservationArray;
            })
        },
        methods: {
            // 메뉴 보기
            menu(item) {
                const index = this.items.indexOf(item)
                var reservation_id = this.items[index].id;
                axios.post('/getReservationMenuList', {
                    id : reservation_id
                }).then((response) => {
                    var MenuorderData = response.data.currentOrder;
                    // 임시
                    var MenuArray = '';
                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData[0].menuNum; i++)
                    {
                        MenuArray = (i+1)+'番 :' + MenuorderData[0]['menu_name' + (i+1)]
                            + ' 値段　:' + MenuorderData[0]['menu_price' + (i+1)];
                        // 옵션 개수…도..
                        var OptionCount = MenuorderData[0]['optionNum'+(i+1)];
                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuArray += ' ' + MenuorderData[0]['menu'+(i+1)+'-'+'option'+(j+1)]
                                + ':' + MenuorderData[0]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                        }
                        this.orderMenu[i] = MenuArray;
                    }
                });
            },
            // db로 값 보내기
            save () {
                var check = true;
                /* 유효성 검사 */
                if(this.ReservationItem.name == null)
                {
                    this.addreservation_snackbar = true;
                    var check = false;
                }
                else if(this.ReservationItem.start_date == null)
                {
                    this.addreservation_text = " 予約日を選択してください。"
                    this.addreservation_snackbar = true;
                    var check = false;
                }
                else if(this.ReservationItem.time == null)
                {
                    this.addreservation_text = " 予約時間を選択してください。"
                    this.addreservation_snackbar = true;
                    var check = false;
                }
                else if(this.ReservationItem.adult_person != null || this.ReservationItem.child_person != null)
                {
                    // 숫자만 가능
                    var regNumber = /^[0-9]*$/;
                    if(!regNumber.test(this.ReservationItem.adult_person)) {
                         this.addreservation_text = "大人数の項目は数字だけ記入してください。";
                         this.addreservation_snackbar = true;
                         var check = false;
                    }
                    if(!regNumber.test(this.ReservationItem.child_person)) {
                         this.addreservation_text = "子供数の項目は数字だけ記入してください。";
                         this.addreservation_snackbar = true;
                         var check = false;
                    }
                }
                if(check == true) {
                    /* Data 송신 */
                    axios.post('/setOwnerReservation', {
                        shop_id         : this.$route.params.shop_id,
                        username        : this.ReservationItem.name,
                        start_date      : this.ReservationItem.start_date,
                        time            : this.ReservationItem.time,
                        adult_person    : this.ReservationItem.adult_person,
                        child_person    : this.ReservationItem.child_person
                    }).then((response) => {
                        location.reload();
                    })
                    .catch(console.log('test'));
                    this.dialog = false;
                }
            }
        }
    }
</script>
<style>
    .Reservation_list {
        padding-left: 5%;
        padding-right: 5%;
    }

    .Main_title {
        color: #6d4d35;
    }

    .sub_title {
        color : #9d724b;
    }

</style>