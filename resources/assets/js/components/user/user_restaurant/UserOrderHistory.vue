<template>
    <v-app>
        <div>
            <br>
            <B>{{userName}}</B> 님 반갑습니다.
            <hr>
            <h4><B> 주문 내역</B></h4><br>
            <v-tabs color="dark"
                    dark
                    slider-color="red"
            >
                <v-tab>
                    주문 내역 
                </v-tab>
                <v-tab-item>
                    <v-layout>
                        <v-flex>
                        <v-card>
                            <v-container fluid grid-list-md>
                                <v-layout row wrap>
                                    <v-flex
                                        xs12 sm6
                                         v-for="(card, index) in orderMenu"
                                        :key="index"
                                    >
                                    <v-card>
                                        <!-- 내용 -->
                                        <v-card-text>
                                           <div>
                                                <B>{{orderMenu[index].shopName}}</B><br>
                                                날짜 : {{orderMenu[index].date}}<br>
                                                주문한 메뉴 : {{orderMenu[index].menu_select}}
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

                // 주문 내역 배열
                orderMenu: [
                    {
                        id : 1,
                        shopName: 'rksek',
                        date: '1',
                        menu_select : '',
                    },
                    {
                        id : 2,
                        shopName: 'rksek',
                        date: '1',
                        menu_select : '',
                    }
                ],
            }
        },
       created: function () {
        axios.post('/userPageOrder', {
        }).then((response) => {
                var MenuorderData = response.data.Menuorder;

                this.userName       = username;
                // 사용자 주문 내역
                this.orderMenu    =   MenuorderData;

            }) 
        }
    }
</script>
