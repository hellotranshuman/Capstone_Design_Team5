<template>
    <v-app>
        <div style="margin-left:20px; margin-right:20px;">
            <br>
            <B>{{userName}}</B> 님 반갑습니다.
            <hr>
            <h4><B> 예약 현황 </B></h4><br>
            <v-tabs color="dark"
                    dark
                    slider-color="red"
            >
                <v-tab>
                    수락한 예약  
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
                                                <B>{{StandBycards[index].shopName}}</B><br>
                                                예약 날짜 : {{StandBycards[index].date}}<br>
                                                예약 시간 : {{StandBycards[index].time}}<br>
                                                어른 인원 : {{StandBycards[index].adult}}<br>
                                                아이 인원 : {{StandBycards[index].child}}<br>
                                                <span v-if="StandBycards[index].reservation_selectMenu != null"> 주문 메뉴 : {{StandBycards[index].menu_select}} </span>
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-card>
                        </v-flex>
                    </v-layout>
                </v-tab-item>
                <v-tab>
                    수락 대기중인 예약
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
                                            
                                            height="150px"
                                        >
                                        </v-card-media>
                                        <!-- 내용 -->
                                        <v-card-title>
                                            <div>
                                                <B>{{StandBycards[index].shopName}}</B><br>
                                                예약 날짜 : {{StandBycards[index].date}}<br>
                                                예약 시간 : {{StandBycards[index].time}}<br>
                                                어른 인원 : {{StandBycards[index].adult}}<br>
                                                아이 인원 : {{StandBycards[index].child}}<br>
                                                <span v-if="StandBycards[index].reservation_selectMenu != null"> 주문 메뉴 : {{StandBycards[index].menu_select}} </span>
                                            </div>
                                        </v-card-title>
                                        <v-card-actions>
                                            <v-spacer></v-spacer>
                                            <v-btn color="error" dark @click.stop="dialog = true" @click="clickshopid = StandBycards[index].id, TypeChange(StandBycards[index].id)">예약 취소
                                                <v-icon dark right>check_circle</v-icon>
                                            </v-btn>
                                            <!-- 예약 취소 Dialog -->
                                            <v-dialog v-model="dialog" max-width="500px">
                                                <v-card>
                                                <v-card-title>
                                                    <span><B>가게이름 : {{clickshopid}}</B></span>
                                                </v-card-title>
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
                                                    <v-btn color="error" flat @click.stop="dialog=false, Cancel()">확인</v-btn>
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
                userName : '윤진주',

                // 이유
                WhyCancel : '',

                // 수락한 예약 배열
                Acceptcards: [
                    {
                        id : 1,
                        shopName: 'rksek',
                        src: '1',
                        date : '',
                        time : '',
                        adult: 0,
                        child: 0,
                        menu_select : ''
                    },
                    {
                        id : 2,
                        shopName: '1',
                        src: '1',
                        date : '',
                        time : '',
                        adult: 0,
                        child: 0,
                        menu_select : ''
                    }
                ],
                
                // 수락 대기중인 예약 배열
                StandBycards: [
                    {
                        id : '1',
                        shopName: 'rksek',
                        src: '1',
                        date : '',
                        time : '',
                        adult: 0,
                        child: 0,
                        menu_select : ''
                    },
                    {
                        id : '2',
                        shopName: '1',
                        src: '1',
                        date : '',
                        time : '',
                        adult: 0,
                        child: 0,
                        menu_select : ''
                    }
                ],

                clickshopid : 0,
            }
        },
       created: function () {
        // 유저 이름이랑 식당 메인 이미지 받고싶어요
        axios.post('/reservation', {
        }).then((response) => {
                var acceptreservationData = response.data.reservation;
                var standByreservationData = response.data.reservation;
                
                this.userName       = username;
                // 수락한 예약
                this.Acceptcards    =   acceptreservationData;

                // 수락 대기중인 예약
                this.StandBycards   =   standByreservationData;

                
            }) 
        },
        
        methods : {
            TypeChange(id) {
                this.clickshopid = parseInt(id);
            },
            // 예약을 취소 할 경우
            Cancel() {
                axios.post('/cancelReservation', {
                    id          : this.clickshopid,
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
