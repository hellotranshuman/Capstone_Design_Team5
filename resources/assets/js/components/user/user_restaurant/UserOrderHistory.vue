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
                                                <a :href="orderMenu[index].href">
                                                    <!-- 사진 -->
                                                    <v-card-media
                                                            :src="card.src"
                                                            height="150px"
                                                    >
                                                    </v-card-media>
                                                </a>
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
                orderMenu: [ ],
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

                    MenuArray[i]['order_num']       = MenuorderData[i].order_num;
                    MenuArray[i]['order_date']      = MenuorderData[i].order_date;
                    MenuArray[i]['restaurant_name'] = MenuorderData[i].restaurant_name;
                    MenuArray[i]['src']             = '/images/'+ MenuorderData[i].id + '/'
                        + MenuorderData[i].id + '_titleImg.jpg';
                    MenuArray[i]['href']            = '/restaurant/' + MenuorderData[i].id + '/info';

                    if(MenuorderData[i].menuNum != null)
                    {
                        for(var j = 1; j <= MenuorderData[i].menuNum; j++)
                        {
                            if(j == 1)
                                MenuArray[i]['menu_select'] = (j)+'번 :' + MenuorderData[i]['menu_name' + (j)]
                                    + ' 가격:' + MenuorderData[i]['menu_price' + (j)];
                            else
                                MenuArray[i]['menu_select'] += ' ' + (j) +'번 :' + MenuorderData[i]['menu_name' + (j)]
                                    + ' 가격:' + MenuorderData[i]['menu_price' + (j)];

                            var OptionCount = MenuorderData[i]['menu' + (j) + '-option'+(j)];

                            if(OptionCount != null) {
                                for(var z = 1; z <= OptionCount; z++)
                                {
                                    MenuArray[i]['menu_select'] += ' ' + MenuorderData[i]['menu'+(j)+'-'+'option'+(z)];

                                    if(MenuorderData[i]['menu'+(j)+'-'+'subOption'+(z)] != null)
                                    {
                                        MenuArray[i]['menu_select'] += ':' + MenuorderData[i]['menu'+(j)+'-'+'subOption'+(z)];
                                    }
                                }
                            }
                        }
                    }
                }
                console.log(MenuArray);

                this.orderMenu = MenuArray;
            })
        }
    }
</script>