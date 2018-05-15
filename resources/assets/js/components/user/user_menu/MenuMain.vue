<template>
    <v-app>
        <v-stepper v-model="Menu_Order" dark>
            <!-- Header -->
            <v-stepper-header>
                <!-- 1. 메뉴선택 -->
                <v-stepper-step step="1" :complete="Menu_Order > 1">메뉴 선택</v-stepper-step>
                <v-divider></v-divider>

                <!-- 2. 메뉴 확인 -->
                <v-stepper-step step="2" :complete="Menu_Order > 2">메뉴 확인</v-stepper-step>
                <v-divider></v-divider>

                <!-- 3. 번역 -->
                <v-stepper-step step="3">메뉴 번역</v-stepper-step>
            </v-stepper-header>

            <!-- Main -->
            <v-stepper-items>
                <!-- 1. 메뉴선택 -->
                <v-stepper-content step="1" color="error">

                    <v-card color="white lighten-1" class="mb-5" style="overflow:hidden">
                        <Layout></Layout>
                    </v-card>

                    <!-- btn -->
                    <v-btn color="error" @click.native="Menu_Order = 2"
                           @click="order_menu">
                        주문하기
                    </v-btn>
                </v-stepper-content>

                <!-- 2. 메뉴 확인  height="200px" -->
                <v-stepper-content step="2">
                    <v-card color="white lighten-1" class="mb-5" >
                        <v-container :id="'menu_check_container'">
                            <v-layout v-for="i in range(0, click_menu.length-1)" :key="i"
                                      :id="'menu_layout'+i"  mb-3>
                                <v-flex sm12>
                                    <v-card elevation-20>
                                        <v-card-text style="font-size:1.2rem">
                                            <div>
                                                <b> 메뉴명 : {{click_menu[i].menu.name}} </b>
                                                <v-btn icon
                                                       style="float : right"
                                                       @click="click_cancel"
                                                       :id="i"
                                                >
                                                    <v-icon dark> close </v-icon>
                                                </v-btn><br>
                                                <b> 가격 : {{click_menu[i].menu.price}} </b> <br>
                                                <!-- 옵션 선택 -->
                                                <v-flex xs6 v-if="click_menu[i].menu.opNum != 0">
                                                    <b> [ 옵션 ] </b> <br>
                                                    <!-- 옵션 배열 길이 만큼 돌기 -->
                                                    <span v-for="(option, index) in optionArray[i]" :key="index">
                                                        <!-- 옵션 이름 -->
                                                        <b v-text="option['Name']"></b>
                                                        <!-- 옵션 세부 사항 -->
                                                        <v-select
                                                                :items="optionArray[i][index]"
                                                                v-model="optionselect[i][index]"
                                                                single-line
                                                        ></v-select>
                                                    </span>
                                                </v-flex>
                                            </div>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>
                            </v-layout>
                        </v-container>
                    </v-card>
                    <v-flex>
                        <v-card>
                            <b style="padding-left:5%; font-size: 2rem"> 총 : {{click_menu.length}} 개 </b>
                            <b style="padding-left:5%; font-size: 2rem"> 합계 : {{sum_price}} 円 </b>
                        </v-card>
                    </v-flex>
                    <!-- btn -->
                    <v-btn color="error" @click.native="Menu_Order = 3" @click="MenuOrderList()"
                    >
                        확인
                    </v-btn>
                    <v-btn flat @click.native="Menu_Order = 1">돌아가기</v-btn>
                </v-stepper-content>

                <!-- 3. 번역  height="200px"-->
                <v-stepper-content step="3">
                    <v-card color="white" class="mb-5">
                        <v-card-text style="color:black">
                            번역 부분 입니다
                        </v-card-text>
                    </v-card>

                    <!-- btn -->
                    <v-btn color="error"  @click.stop="Ordercheck = true">확인</v-btn>
                    <v-btn flat @click.native="Menu_Order = 2">돌아가기</v-btn>

                    <!-- 주문 확인 창 -->
                    <v-dialog v-model="Ordercheck" max-width="500px">
                        <v-card>
                            <v-card-title>
                                <span><h2><B>주문이 완료 되었습니다.</B></h2></span>
                                <v-spacer></v-spacer>
                            </v-card-title>

                            <v-card-actions>
                                <v-btn color="error" @click.stop="OrderMenu(), Ordercheck=false">
                                    확인
                                </v-btn>
                            </v-card-actions>
                        </v-card>
                    </v-dialog>

                </v-stepper-content>
            </v-stepper-items>
        </v-stepper>
    </v-app>
</template>

<script>
    import { EventBus } from './eventBus.js';
    import VueAxios from 'vue-axios';
    import axios    from 'axios';

    // 사용자 설정에 따라 레이아웃을 선택함.
    import DefaultLayout1 from './MenuDefaultLayout1.vue';
    // import DefaultLayout2 from './MenuDefaultLayout2.vue';
    // import DefaultLayout3 from './MenuDefaultLayout3.vue';
    // import DefaultLayout4 from './MenuDefaultLayout4.vue';
    // import CustomLayout from './MenuDefaultLayout1.vue';      // 아직

    var layout = DefaultLayout1;     // 사장이 선택한 메뉴판 탬플릿
    var obj    = [];                 // 클릭한 배열 담기
    var check  = 0;                  // 클릭한 배열 index용 변수

    export default {

        created : function () {
            EventBus.$on('select_menus', function(menu) {
                obj.push( menu[check] ); check++;
            });
        },

        data () {
            return {
                Menu_Order: 0,
                click_menu:[],          // 클릭한 메뉴들이 담김
                Ordercheck: false,      // 주문 확인 창
                sum_price : 0,          // 선택한 메뉴 총 가격
                translateText : [],     // 번역한 텍스트 값이 들어갈 배열

                // 옵션 선택
                optionselect : [],
                optionArray: [],        // 클릭한 메뉴의 옵션 값을 관리할 배열
                optionId : [],

                // 메뉴 아이디 배열
                menuid : [],
                Order : [],
            }
        },
        methods : {
            // 주문하기 버튼 클릭 시 호출되는 함수
            order_menu : function() {
                this.click_menu = obj;
                this.sum_price = 0;

                for(let i=0; i< this.click_menu.length; i++){
                    this.sum_price += this.click_menu[i].menu.price
                }

                this.select();
            },

            // v-for 용 함수, start에서 시작해서 end까지 1식 반환
            range : function (start, end) {
                return Array(end - start + 1).fill().map((_, idx) => start + idx)
            },

            // 메뉴 취소하기
            click_cancel : function() {
                var id          = event.target.parentNode.id;                        // 클릭한 메뉴 click_menu의 배열 키 값
                var container   = document.getElementById('menu_check_container');   // 메뉴 확인 창

                this.sum_price  = this.sum_price - this.click_menu[id].menu.price;   // 총 가격 빼기
                this.click_menu.splice(id, 1);                                       // 선택한 메뉴 배열에서 취소한 메뉴 삭제

                alert('선택한 메뉴를 취소하였습니다.');
            },

            // 옵션 선택
            select() {
                var argId = argId;
                var MenuMax = this.click_menu.length;

                // 메뉴 길이 만큼 돌기
                for(var i = 0; i < MenuMax; i++)
                {
                    // 해당 메뉴 옵션 개수
                    var opNumMax = this.click_menu[i].menu.opNum;

                    this.optionArray[i] = [];
                    this.optionselect[i] = [];
                    this.optionId[i] = [];
                    for(var j = 0; j < opNumMax; j++)
                    {
                        // 서브 옵션 개수
                        var supOption = this.click_menu[i].menu['subOpNum' + (j+1)];

                        // 옵션 이름 넣기
                        this.optionArray[i][j] = [];
                        this.optionId[i][j] = this.click_menu[i].menu['optionId' + (j+1)]
                        this.optionArray[i][j][ 'Name' ] = this.click_menu[i].menu['optionName' + (j+1)];

                        for(var z = 0; z < supOption; z++)
                        {
                            // 옵션 상세 정보
                            this.optionArray[i][j][z] = this.click_menu[i].menu[ (j+1)+ 'optionValue' + (z+1) ];
                        }
                    }
                }
            },

            // 번역 메뉴 목록
            MenuOrderList() {
                console.log(this.click_menu);
                console.log(this.optionselect);
                console.log(this.optionArray);

                for(var i = 0; i < this.click_menu.length; i++)
                {
                    this.Order[i] = [];
                    // 메뉴 이름
                    this.Order[i]['name'] = this.click_menu[i].menu.name;
                    for(var j = 0; j < this.optionArray[i].length; j++)
                    {
                        // 옵션 이름
                        this.Order[i]['option'+ (j+1)] = this.optionArray[i][j].Name;
                        // 서브옵션값
                        this.Order[i]['option'+ (j+1) + 'select'] = this.optionselect[i][j];
                    }
                }

                axios.post('/translateOrder', {
                    Order : this.Order,    // 메뉴 개수
                }).then((response) => {
                    document.write(response.data.msg);
                    // location.reload();
                })
            },

            // 메뉴 주문 데이터 송신
            OrderMenu() {
                // 주문한 메뉴
                for(var i = 0; i < this.click_menu.length; i++)
                {
                    this.menuid[i] = this.click_menu[i].menu.id;
                }

                console.log(this.optionArray)
                /* Data 송신 */
                axios.post('/makeOrder', {
                    menulength : this.menuid.length,    // 메뉴 개수
                    menu_id : this.menuid,              // 선택한 메뉴가 있는 배열
                    option  : this.optionId,            // 옵션 Id
                    suboption  : this.optionselect,      // 서브 옵션
                    shop_id     : this.$route.params.shop_id,
                    sum_price   : this.sum_price,
                }).then((response) => {
                    document.write(response.data.msg);
                    // location.reload();
                })
                    .catch(console.log('test'));
            }
        },
        components : {
            'Layout' : layout
        }
    }
</script>

<style>

</style>