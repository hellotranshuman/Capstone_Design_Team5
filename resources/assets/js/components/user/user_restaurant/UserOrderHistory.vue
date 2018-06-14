<template>
    <v-app>
        <div>
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
                                                        <B>{{orderMenu[index].restaurant_name}}</B><br>
                                                        <B>날짜 : </B>{{orderMenu[index].order_date}}<br>
                                                        <B>주문한 메뉴 : </B>{{orderMenu[index].menu_select}}
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

                // 주문 내역 배열
                orderMenu: [],
            }
        },

        created: function () {
            axios.post('/getUserOrderList', {
            }).then((response) => {
                var MenuorderData = response.data.order_data;

                // 임시 배열
                var MenuArray = [];

                // 1. 주문 메뉴 옵션 합치기s
                for(var i = 0 ; i < MenuorderData.length; i++)
                {
                    MenuArray[i] = [];

                    MenuArray[i]['order_num'] = MenuorderData[i].order_num;
                    MenuArray[i]['order_date'] = MenuorderData[i].order_date;
                    MenuArray[i]['restaurant_name'] = MenuorderData[i].restaurant_name;
                    MenuArray[i]['menu_select'] = (i+1)+'번 :' + MenuorderData[i]['menu_name' + (i+1)]
                        + ' 가격:' + MenuorderData[i]['menu_price' + (i+1)];

                    // 옵션 개수...도..
                    var OptionCount = MenuorderData[i]['optionNum'+(i+1)];

                    // 메뉴
                    for(var j = 0; j < OptionCount; j++)
                    {
                        MenuArray[i]['menu_select'] += ' ' + MenuorderData[i]['menu'+(i+1)+'-'+'option'+(j+1)]
                            + ':' + MenuorderData[i]['menu'+(i+1)+'-'+'subOption'+(j+1)];
                    }
                }

                this.orderMenu = MenuArray;
            })
        }
    }
</script>