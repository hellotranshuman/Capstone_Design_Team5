<template>
    <v-app  id="UserPage">
         <div >
            <br>
            <h4 class="Main_title"><B>[ {{trans_order_list}} ]</B></h4><br>
            <v-tabs
                    color="brown dark-1"
                    
                    slider-color="orange darken-1"
            >
                <v-tab style="color:white; font-size:17px">
                    &nbsp; &nbsp; {{trans_order_list}} &nbsp; &nbsp;
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
                                                        <h3><B>{{orderMenu[index].restaurant_name}}</B></h3>
                                                        <B>{{trans_date}} : </B>{{orderMenu[index].order_date}}<br>
                                                        <B>{{trans_menu}} : </B>{{orderMenu[index].menu_select}}
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

                 /* --- 번역 ---*/
                 country : '',
                 trans_order_list : '注文内訳',
                 trans_date : '日付',
                 trans_menu : 'メーニュー',
                 trans_ban  : '番',
                 trans_price : '値段'
            }
        },
        created: function () {
            // 유저 국적
            this.country = this.$session.get('user_country');

            if(this.$session.get('user_country') == 'Korea')
            {
                this.trans_order_list   = '주문 내역';
                this.trans_date         = '날짜';
                this.trans_menu         = '메뉴';
                this.trans_ban          = '번';
                this.trans_price        = '가격';
            }
            else if(this.$session.get('user_country') == 'China')
            {
                this.trans_order_list   = '订单明细';
                this.trans_date         = '预约日';
                this.trans_menu         = '菜单';
                this.trans_ban          = '号';
                this.trans_price        = '价格';
            }
            else if(this.$session.get('user_country') == 'USA')
            {
                this.trans_order_list   = 'Order History';
                this.trans_date         = 'Reservation Date';
                this.trans_menu         = 'Menu';
                this.trans_ban          = 'Number';
                this.trans_price        = 'Price';
            }

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
                            {
                                MenuArray[i]['menu_select'] = (j)+ this.ban + ':' + MenuorderData[i]['menu_name' + (j)]
                                    + this.trans_price + ':' + MenuorderData[i]['menu_price' + (j)] + ' ';
                            }
                            else
                            {
                                MenuArray[i]['menu_select'] += ' ' + (j) + this.ban + ':' + MenuorderData[i]['menu_name' + (j)]
                                    + this.trans_price + ':' + MenuorderData[i]['menu_price' + (j)] + ' ';
                            }

                            var OptionCount = MenuorderData[i]['menu' + (j) + '-option'+(j)];
                            
                            if(OptionCount != null) {
                                for(var z = 1; z <= OptionCount; z++)
                                {
                                    MenuArray[i]['menu_select'] += ' ' + MenuorderData[i]['menu'+(j)+'-'+'option'+(z)] + ' ';
                                    if(MenuorderData[i]['menu'+(j)+'-'+'subOption'+(z)] != null)
                                    {
                                        MenuArray[i]['menu_select'] += ':' + MenuorderData[i]['menu'+(j)+'-'+'subOption'+(z)] + ' ';
                                    }
                                }
                            }
                        }
                    }
                }
                this.orderMenu = MenuArray;
            })
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