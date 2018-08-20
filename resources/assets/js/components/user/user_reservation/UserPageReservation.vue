<template>
    <v-app  id="UserPage">
        <div style="margin-left:20px; margin-right:20px;" >
            <br>
            <h4 class="Main_title"><B>[ {{trans_reservation_list}} ]</B></h4><br>
            <v-tabs color="brown dark-1"
                    slider-color="orange darken-1"
                    centered
            >
                <v-tab style="color:white; font-size:17px">
                    {{trans_reservation_accept_text}}
                </v-tab>
                <v-tab-item>
                    <v-layout>
                        <v-flex>
                            <v-card>
                                <v-container fluid grid-list-md>
                                    <v-layout row wrap>
                                        <v-flex
                                                xs12 sm6
                                                v-for="(card, index) in Acceptcards"
                                                :key="index"
                                        >
                                            <v-card>
                                                <!-- 사진 -->
                                                <v-card-media
                                                        :src="card.src"
                                                        height="150px"
                                                >
                                                </v-card-media>
                                                <!-- 내용 -->
                                                <v-card-text>
                                                    <div>
                                                        <h5><B>{{Acceptcards[index].shopName}}</B></h5>
                                                        <B>{{trans_date}} : </B> {{Acceptcards[index].date}}<br>
                                                        <B>{{trans_reservation_person}} : </B>{{Acceptcards[index].adult}}<br>
                                                        <B>{{trans_reservation_child}} : </B>{{Acceptcards[index].child}}<br>
                                                        <B>{{trans_reservation_message}} : </B>{{Acceptcards[index].message}}
                                                    </div>
                                                </v-card-text>
                                                <v-card-actions>
                                                    <!-- 메뉴 보기 -->
                                                    <div v-if="Acceptcards[index].orderCheck != null">
                                                        <v-btn
                                                                flat small color="orange darken-1"
                                                                @click="clickshopid = Acceptcards[index].id , MenuList(), menuLoad = true">{{trans_menu}} </v-btn>
                                                    </div>
                                                    <v-dialog v-model="menuLoad" max-width="500px">
                                                        <v-toolbar color="orange darken-1">
                                                            <h3 style="color:white; margin:auto" > {{trans_menu}} </h3>
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
                                                            <v-card-actions>
                                                                <v-btn color="orange darken-1" style="color:white" @click.stop="menuLoad = false">
                                                                    OK
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-card-actions>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-tab-item>
                <v-tab style="color:white">
                    {{trans_reservation_ing}}
                </v-tab>
                <v-tab-item>
                    <v-layout>
                        <v-flex>
                            <v-card>
                                <v-container fluid grid-list-md>
                                    <v-layout row wrap>
                                        <v-flex
                                                xs12 sm6
                                                v-for="(card, index) in StandBycards"
                                                :key="index"
                                        >
                                            <v-card>
                                                <!-- 사진 -->
                                                <v-card-media
                                                        :src="card.src"
                                                        height="150px"
                                                >
                                                </v-card-media>
                                                <!-- 내용 -->
                                                <v-card-title>
                                                    <div>
                                                        <h5><B>{{StandBycards[index].shopName}}</B></h5>
                                                        <B>{{trans_date}} : </B> {{StandBycards[index].date}}<br>
                                                        <B>{{trans_reservation_person}} : </B>{{StandBycards[index].adult}}<br>
                                                        <B>{{trans_reservation_child}} : </B>{{StandBycards[index].child}}<br>
                                                        <B>{{trans_reservation_message}} : </B>{{StandBycards[index].message}}
                                                    </div>
                                                </v-card-title>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>
                                                    <!-- 메뉴 보기 -->
                                                    <div v-if="StandBycards[index].orderCheck != null">
                                                        <v-btn
                                                                flat small color="orange darken-1"
                                                                @click="clickshopid = StandBycards[index].id , MenuList(), menuLoad = true">{{trans_menu}} </v-btn>
                                                    </div>
                                                    <v-dialog v-model="menuLoad" max-width="500px">
                                                        <v-toolbar color="orange darken-1">
                                                            <h3 style="color:white; margin:auto" > {{trans_menu}} </h3>
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
                                                            <v-card-actions>
                                                                <v-btn color="orange darken-1" style="color:white" @click.stop="menuLoad = false">
                                                                    OK
                                                                </v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                    <v-btn small color="error" dark @click.stop="dialog = true">
                                                        {{trans_reservation_cancel}}
                                                        <v-icon small dark right>check_circle</v-icon>
                                                    </v-btn>

                                                    <!-- 예약 취소 Dialog -->
                                                    <v-dialog v-model="dialog" max-width="500px">
                                                        <v-card>
                                                            <v-card-text>
                                                                {{trans_reservation_cancel_why}} <br>
                                                                <v-text-field
                                                                        v-model="WhyCancel"
                                                                        :label="trans_why_cancel"
                                                                        class="input-group--focused"
                                                                        color="error"
                                                                ></v-text-field>
                                                            </v-card-text>
                                                            <v-card-actions>
                                                                <v-btn color="error" flat @click.stop="dialog=false, Cancel(card)">OK</v-btn>
                                                                <v-btn color="error" flat @click.stop="dialog=false">Cancel</v-btn>
                                                            </v-card-actions>
                                                        </v-card>
                                                    </v-dialog>
                                                </v-card-actions>

                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-tab-item>
                <v-tab style="color:white">
                    {{trans_cancelreservation}}
                </v-tab>
                <v-tab-item>
                    <v-layout>
                        <v-flex>
                            <v-card>
                                <v-container fluid grid-list-md>
                                    <v-layout row wrap>
                                        <v-flex
                                                xs12 sm6
                                                v-for="(card, index) in Cancelcards"
                                                :key="index"
                                        >
                                            <v-card>
                                                <!-- 사진 -->
                                                <v-card-media
                                                        :src="card.src"
                                                        height="150px"
                                                >
                                                </v-card-media>
                                                <!-- 내용 -->
                                                <v-card-title>
                                                    <div>
                                                         <h5><B>{{Cancelcards[index].shopName}}</B></h5>
                                                        <B> {{trans_date}} : </B> {{Cancelcards[index].date}}<br>
                                                        <B> {{trans_why_cancel}} : </B>{{Cancelcards[index].message}}<br>
                                                    </div>
                                                </v-card-title>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                    </v-layout>
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
                dialog : false,
                menuLoad : false,

                // 이유
                WhyCancel : '',

                // 수락한 예약 배열
                Acceptcards: [
                    
                ],

                // 수락 대기중인 예약 배열
                StandBycards: [],

                // 취소 예약 배열
                Cancelcards: [],

                clickshopid : 0,
                orderMenu : [],

                /* ---  번역 --- */
                country : '',
                
                trans_reservation_list : '予約リスト',
                trans_reservation_accept_text : '受諾された予約',
                trans_date : '日付',
                trans_reservation_person : '大人数',
                trans_reservation_child : '子供数',
                trans_reservation_message : '要求事項',
                trans_menu : 'メーニュー',
                trans_reservation_cancel : '予約キャンセル',
                trans_reservation_ing : '受諾の大気中の予約',
                trans_reservation_cancel_why : ' 予約をキャンセルする理由をかいてください。',
                trans_cancelreservation : 'キャンセル予約',
                trans_why_cancel : '予約をキャンセル理由',
                trans_ban  : '番',
                 trans_price : '値段'

            }
        },
        created: function () {
             // 유저 국적
            this.country = this.$session.get('user_country');

            if(this.$session.get('user_country') == 'Korea')
            {
                this.trans_reservation_list         = '예약 현황';
                this.trans_reservation_accept_text  = '수락된 예약';
                this.trans_date                     = '예약 일';
                this.trans_reservation_person       = '어른 수';
                this.trans_reservation_child        = '아이 수';
                this.trans_reservation_message      = '요구 사항';
                this.trans_menu                     = '메뉴';
                this.trans_reservation_cancel       = '예약 취소';
                this.trans_reservation_ing          = '수락 대기중인 예약';
                this.trans_reservation_cancel_why   = '예약을 취소하는 이유를 적어주세요';
                this.trans_cancelreservation        = '취소된 예약';
                this.trans_why_cancel               = '예약을 취소하는 이유';
                this.trans_ban          = '번';
                this.trans_price        = '가격';
            }
            else if(this.$session.get('user_country') == 'China')
            {
                this.trans_reservation_list         = '预约现状';
                this.trans_reservation_accept_text  = '接受预约的预约';
                this.trans_date                     = '预约日';
                this.trans_reservation_person       = '大人人数';
                this.trans_reservation_child        = '子数';
                this.trans_reservation_message      = '要求事项';
                this.trans_menu                     = '菜单';
                this.trans_reservation_cancel       = '取消预约';
                this.trans_reservation_ing          = '接受预约时预约';
                this.trans_reservation_cancel_why   = '请填写取消预约的理由';
                this.trans_cancelreservation        = '取消预约的预约';
                this.trans_why_cancel               = '取消预约的理由';
                this.trans_ban          = '号';
                this.trans_price        = '价格';
            }
            else if(this.$session.get('user_country') == 'USA')
            {
                this.trans_reservation_list         = 'Reservation List';
                this.trans_reservation_accept_text  = 'Accept Reservation';
                this.trans_date                     = 'Reservation Date';
                this.trans_reservation_person       = 'Person';
                this.trans_reservation_child        = 'Child';
                this.trans_reservation_message      = 'Requirements';
                this.trans_menu                     = 'Menu';
                this.trans_reservation_cancel       = 'Reservation Cancel';
                this.trans_reservation_ing          = 'Waiting for acceptance';
                this.trans_reservation_cancel_why   = 'Please provide the reason for canceling your reservation.';
                this.trans_cancelreservation        = 'Cancelled Reservation';
                this.trans_why_cancel               = 'Reason for canceling a reservation';
                this.trans_ban          = 'Number';
                this.trans_price        = 'Price';
            }

            // 유저 이름이랑 식당 메인 이미지 받고싶어요
            axios.post('/getUserReservationList', {
            }).then((response) => {
                var acceptreservationData = response.data.resAcceptData;
                var standByreservationData = response.data.resWaitData;
                var cancelreservationData = response.data.resCancelData;

                var acceptarray = [];
                var standByarray = [];
                var cancelarray = [];

                // 수락한 예약
                if(acceptreservationData != null)
                {
                    for(var i = 0; i < acceptreservationData.length; i++)
                    {
                        acceptarray[i] = [];
                        acceptarray[i]['id']       = acceptreservationData[i].id;
                        acceptarray[i]['shopName'] = acceptreservationData[i].name;
                        acceptarray[i]['src']      = '/images/'+ acceptreservationData[i].restaurant_id + '/'
                            + acceptreservationData[i].restaurant_id + '_titleImg.jpg';
                        acceptarray[i]['date']     = acceptreservationData[i].reservation_date;
                        acceptarray[i]['adult']    = acceptreservationData[i].person;
                        acceptarray[i]['child']    = acceptreservationData[i].child;
                        acceptarray[i]['orderCheck']   = acceptreservationData[i].order_num;
                        acceptarray[i]['message']   = acceptreservationData[i].message;
                    }

                    this.Acceptcards = acceptarray;
                }

                // 수락 대기중인 예약
                if(standByreservationData != null)
                {
                    for(var i = 0; i < standByreservationData.length; i++)
                    {
                        standByarray[i] = [];
                        standByarray[i]['id']       = standByreservationData[i].id;
                        standByarray[i]['shopName'] = standByreservationData[i].name;
                        standByarray[i]['src']      = '/images/'+ standByreservationData[i].restaurant_id + '/'
                            + standByreservationData[i].restaurant_id + '_titleImg.jpg';
                        standByarray[i]['date']     = standByreservationData[i].reservation_date;
                        standByarray[i]['adult']    = standByreservationData[i].person;
                        standByarray[i]['child']    = standByreservationData[i].child;
                        standByarray[i]['orderCheck']   = standByreservationData[i].order_num;
                        standByarray[i]['message']   = standByreservationData[i].message;
                    }

                    this.StandBycards = standByarray;
                }

                // 취소 예약
                if(cancelreservationData != null)
                {
                    for(var i = 0; i < cancelreservationData.length; i++)
                    {
                        cancelarray[i] = [];
                        cancelarray[i]['id']       = cancelreservationData[i].id;
                        cancelarray[i]['shopName'] = cancelreservationData[i].name;
                        cancelarray[i]['src']      = '/images/'+ cancelreservationData[i].restaurant_id + '/'
                            + cancelreservationData[i].restaurant_id + '_titleImg.jpg';
                        cancelarray[i]['date']     = cancelreservationData[i].reservation_date;
                        cancelarray[i]['message']    = cancelreservationData[i].refused_message;
                    }

                    this.Cancelcards = cancelarray;
                }
            })
        },

        methods : {
            MenuList() {
                var shopid = this.clickshopid;

                axios.post('/getReservationMenuList', {
                    id          : shopid
                }).then((response)=> {
                    var MenuorderData = response.data.currentOrder;

                    // 임시
                    var MenuArray = '';

                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData[0].menuNum; i++)
                    {
                        MenuArray = (i+1)+ this.ban + ':' + MenuorderData[0]['menu_name' + (i+1)]
                            + this.trans_price + ':' + MenuorderData[0]['menu_price' + (i+1)];

                        // 옵션 개수...도..
                        var OptionCount = MenuorderData[0]['optionNum'+(i+1)];

                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuArray += ' ' + MenuorderData[0]['menu'+(i+1)+'-'+'option'+(j+1)]
                                + ':' + MenuorderData[0]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                        }

                        this.orderMenu[i] = MenuArray;
                    }


                }).catch(console.log('test '));
            },
            AcceptSpendMenu(card) {
                const index = this.Acceptcards.indexOf(card);

                axios.post('/getUserReservationOrderInfo', {
                    id          : this.Acceptcards[index].id,
                }).then((response)=> {
                    var MenuorderData = response.data.currentOrder;
                    var MenuList = '';

                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData.length; i++)
                    {
                        MenuList = (i+1)+ this.ban + ':' + MenuorderData[i]['menu_name' + (i+1)]
                            + this.trans_price + ':' + MenuorderData[i]['menu_price' + (i+1)];

                        // 옵션 개수…도..
                        var OptionCount = MenuorderData[i]['optionNum'+ (i+1)];

                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuList  += ' ' + MenuorderData[i]['menu'+ (i+1) +'-'+'option'+(j+1)]
                                + ':' + MenuorderData[i]['menu'+ (i+1) +'-'+'subOption'+(j+1)];
                        }
                    }

                    this.MenuList.list = MenuList;

                }).catch(console.log('test '));
            },

            StandBySpendMenu(card) {
                const index = this.StandBycards.indexOf(card);
                axios.post('/getUserReservationOrderInfo', {
                    id          : this.StandBycards[index].id,
                }).then((response)=> {
                    var MenuorderData = response.data.currentOrder;

                    // 임시
                    var MenuArray = '';

                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData[0].menuNum; i++)
                    {
                        MenuArray = (i+1)+'番 :' + MenuorderData[0]['menu_name' + (i+1)]
                            + ' 値段:' + MenuorderData[0]['menu_price' + (i+1)];

                        // 옵션 개수...도..
                        var OptionCount = MenuorderData[0]['optionNum'+(i+1)];

                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuArray += ' ' + MenuorderData[0]['menu'+(i+1)+'-'+'option'+(j+1)]
                                + ':' + MenuorderData[0]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                        }

                        this.orderMenu[i] = MenuArray;
                    }
                })
            },

            // 예약을 취소 할 경우
            Cancel(card) {
                const index = this.StandBycards.indexOf(card);
                var id = this.StandBycards[index].id;
                axios.post('/userReservationWaitCancel', {
                    id          : id,
                    whycancel   : this.WhyCancel
                }).then(
                    this.clickshopid = null,
                    this.WhyCancel = null,
                    location.reload()
                ).catch(console.log('test '));
            }
        }
    }
</script>
<style>
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