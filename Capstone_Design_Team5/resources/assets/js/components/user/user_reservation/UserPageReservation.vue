<template>
    <v-app>
        <div style="margin-left:20px; margin-right:20px;">
            <hr>
            <h4><B> 예약 현황 </B></h4><br>
            <v-tabs color="dark"
                    dark
                    slider-color="red"
                    centered
            >
                <v-tab>
                    수락된 예약
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
                                                        <B>{{Acceptcards[index].shopName}}</B><br>
                                                        예약 날짜 : {{Acceptcards[index].date}}<br>
                                                        어른 인원 : {{Acceptcards[index].adult}}<br>
                                                        아이 인원 : {{Acceptcards[index].child}}<br>
                                                    </div>
                                                </v-card-text>
                                                <v-card-actions>

                                                </v-card-actions>
                                            </v-card>
                                        </v-flex>
                                    </v-layout>
                                </v-container>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-tab-item>
                <v-tab>
                    수락 대기중
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
                                                        <B>{{StandBycards[index].shopName}}</B><br>
                                                        예약 날짜 : {{StandBycards[index].date}}<br>
                                                        어른 인원 : {{StandBycards[index].adult}}<br>
                                                        아이 인원 : {{StandBycards[index].child}}<br>
                                                    </div>
                                                </v-card-title>
                                                <v-card-actions>
                                                    <v-spacer></v-spacer>

                                                    <v-btn small color="error" dark @click.stop="dialog = true">예약 취소
                                                        <v-icon small dark right>check_circle</v-icon>
                                                    </v-btn>

                                                    <!-- 예약 취소 Dialog -->
                                                    <v-dialog v-model="dialog" max-width="500px">
                                                        <v-card>
                                                            <v-card-text>
                                                                예약을 취소하는 사유를 적어주세요 <br>
                                                                <v-text-field
                                                                        v-model="WhyCancel"
                                                                        label="예약 취소 사유"
                                                                        class="input-group--focused"
                                                                        color="error"
                                                                ></v-text-field>
                                                            </v-card-text>
                                                            <v-card-actions>
                                                                <v-btn color="error" flat @click.stop="dialog=false, Cancel(card)">확인</v-btn>
                                                                <v-btn color="error" flat @click.stop="dialog=false">취소</v-btn>
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
                <v-tab>
                    취소 내역
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
                                                        <B>{{Cancelcards[index].shopName}}</B><br>
                                                        예약 날짜 : {{Cancelcards[index].date}}<br>
                                                        취소 사유 : {{Cancelcards[index].cancel}}
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

                // 이유
                WhyCancel : '',

                // 수락한 예약 배열
                Acceptcards: [],

                // 수락 대기중인 예약 배열
                StandBycards: [],

                // 취소 예약 배열
                Cancelcards: [],

            }
        },
        created: function () {
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
            AcceptSpendMenu(card) {
                const index = this.Acceptcards.indexOf(card);
                alert(this.Acceptcards[index].id);
                axios.post('/getUserReservationOrderInfo', {
                    id          : this.Acceptcards[index].id,
                }).then((response)=> {
                    var MenuorderData = response.data.currentOrder;
                    var MenuList = '';

                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData.length; i++)
                    {
                        MenuList = (i+1)+'번 :' + MenuorderData[i]['menu_name' + (i+1)]
                            + ' 가격:' + MenuorderData[i]['menu_price' + (i+1)];

                        // 옵션 개수…도..
                        var OptionCount = MenuorderData[i]['optionNum'+(i+1)];

                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuList  += ' ' + MenuorderData[i]['menu'+(i+1)+'-'+'option'+(j+1)]
                                + ':' + MenuorderData[i]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                        }
                    }

                    this.hello = MenuList;

                }).catch(console.log('test '));
            },

            StandBySpendMenu(card) {
                const index = this.StandBycards.indexOf(card);
                axios.post('/getUserReservationOrderInfo', {
                    id          : this.StandBycards[index].id,
                }).then((response)=> {
                    var MenuorderData = response.data.currentOrder;
                    var MenuList = '';

                    // 1. 주문 메뉴 옵션 합치기s
                    for(var i = 0 ; i < MenuorderData.length; i++)
                    {
                        MenuList = (i+1)+'번 :' + MenuorderData[i]['menu_name' + (i+1)]
                            + ' 가격:' + MenuorderData[i]['menu_price' + (i+1)];

                        // 옵션 개수…도..
                        var OptionCount = MenuorderData[i]['optionNum'+(i+1)];

                        // 메뉴
                        for(var j = 0; j < OptionCount; j++)
                        {
                            MenuList  += ' ' + MenuorderData[i]['menu'+(i+1)+'-'+'option'+(j+1)]
                                + ':' + MenuorderData[i]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                        }
                    }

                    this.StandBycards[index]['orderMenu'] = MenuList;
                    alert(this.StandBycards[index]['orderMenu']);

                }).catch(console.log('test '));
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
                    this.WhyCancel = null
                ).catch(console.log('test '));
            }
        }
    }
</script>
<style>
</style>