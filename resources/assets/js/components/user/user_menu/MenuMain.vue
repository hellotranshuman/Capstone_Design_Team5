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
                        <CustomLayout   v-if="layout == 0"></CustomLayout>
                        <DefaultLayout1 v-if="layout == 1"></DefaultLayout1>
                        <DefaultLayout2 v-if="layout == 2"></DefaultLayout2>
                        <DefaultLayout3 v-if="layout == 3"></DefaultLayout3>
                        <DefaultLayout4 v-if="layout == 4"></DefaultLayout4>
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
                            <b class="total"> 총 : {{click_menu.length}} 개 </b> <br>
                            <b class="total"> 합계 : {{sum_price}} 円 </b>
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
                        <v-card-text>
                            <v-card v-for="i in range(0, MenuList.length-1)" :key="i" hover color="white" style="color:black; padding:7px;">
                                <div class="Trans_Title"><b> {{MenuList[i].name}} </b> </div>
                                <div class="Trans_Main">{{MenuList[i].option}}</div>
                            </v-card>
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
    import VueAxios     from 'vue-axios';
    import axios        from 'axios';

    // 사용자 설정에 따라 레이아웃을 선택함.
    import CustomLayout   from './CustomLayout.vue';
    import DefaultLayout1 from './MenuDefaultLayout1.vue';
    import DefaultLayout2 from './MenuDefaultLayout2.vue';
    import DefaultLayout3 from './MenuDefaultLayout3.vue';
    import DefaultLayout4 from './MenuDefaultLayout4.vue';

    var obj    = [];                 // 클릭한 배열 담기
    var check  = 0;                  // 클릭한 배열 index용 변수

    export default {
        created : function () {

            // 사장이 선택한 메뉴 템플릿 불러오기.
            axios.post('/menu/getLayoutNumber', {
                'shop_id' : this.$route.params.shop_id
            } )
                .then( (response) => {
                    // 백엔드에서 보내주는 숫자 값을 this.layout에 넣어주면 그에 맞는 메뉴판이 출력됨.
                    this.layout = response.data.layoutNum;
                    console.log(this.layout);
                })
                .catch((ex)=>{
                    alert('메뉴 템플릿 로드 실패!');
                });

            EventBus.$on('select_menus', function(menu) {
                obj.push( menu[check] ); check++;
            });
        },

        data () {
            return {
                layout : null,          // 사장이 선택한 레이아웃을 담을거임.

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
                MenuOrder : [],
                OpOrder : [],
                OpCount : [],
                SubOpOrder : [],
                subOpCount : [],

                // 번역
                TransMenu : [],
                MenuList : [],
                translatedText : '',
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
                for(var i = 0; i < this.click_menu.length; i++)
                {
                    var OpNum = 0;
                    var subNum = 0;
                    this.OpOrder[i] = [];
                    this.SubOpOrder[i] = [];
                    // 메뉴 이름
                    this.MenuOrder[i] = this.click_menu[i].menu.name;
                    for(var j = 0; j < this.optionArray[i].length; j++)
                    {
                        // 옵션 이름
                        this.OpOrder[i][j] = this.optionArray[i][j].Name;
                        OpNum++;
                        // 서브옵션값
                        if(this.optionselect[i][j] != null)
                        {
                            this.SubOpOrder[i][j] = this.optionselect[i][j];
                            subNum++;
                        }

                    }
                    this.OpCount[i]     = OpNum;
                    this.subOpCount[i]  = subNum;
                }

                axios.post('/translateOrder', {
                    Menu        : this.MenuOrder,
                    Option      : this.OpOrder,
                    subOption   : this.SubOpOrder,
                    MenuCount   : this.MenuOrder.length,
                    OpCount     : this.OpCount,
                    subOpCount  : this.subOpCount
                }).then((response) => {
                    this.translatedText = response.data.translatedText
                });

                // 메뉴 번역된것 DB에서 받기
                this.MenuTranslate();
            },

            MenuTranslate() {
                // DB에서 번역된 값 받기
                // axios.post('/trans', {
                // }).then((response) => {
                //
                // })

                var Menu = this.translatedText.split('&');

                // db에서 받은값 문자열 자르기
                for(var i = 0; i < Menu.length-1; i++)
                {
                    this.TransMenu[i] = Menu[i].split('=');
                }

                // 이쁘게 배열에 넣기
                for(var i = 0; i < this.TransMenu.length; i++)
                {
                    this.MenuList[i] = [];
                    this.MenuList[i]['name'] = this.TransMenu[i][0];
                    this.MenuList[i]['option'] = this.TransMenu[i][1];
                }

                console.log(this.MenuList)
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
                    menulength  : this.menuid.length,       // 메뉴 개수
                    menu_id     : this.menuid,              // 선택한 메뉴가 있는 배열
                    option      : this.optionId,            // 옵션 Id
                    suboption   : this.optionselect,        // 서브 옵션
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
            'CustomLayout'   : CustomLayout,
            'DefaultLayout1' : DefaultLayout1,
            'DefaultLayout2' : DefaultLayout2,
            'DefaultLayout3' : DefaultLayout3,
            'DefaultLayout4' : DefaultLayout4,
        }
    }
</script>
<style>
    /* 모바일 */
    @media (max-width: 639px){
        .total {
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 10%;
            font-size: 17px;
        }
        .Trans_Title {
            font-size:16px;
        }
        .Trans_Main {
            font-size: 13px;
        }
    }
    /* 테블릿 */
    @media (min-width: 640px) and (max-width: 1023px){
        .total {
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 10%;
            font-size: 20px;
        }
        .Trans_Title {
            font-size:18px;
        }
        .Trans_Main {
            font-size: 14px;
        }
    }
    /* 데스트 탑 */
    @media (min-width: 1024px){
        .total {
            padding-left: 5%;
            padding-right: 5%;
            padding-top: 10%;
            font-size: 20px;
        }
        .Trans_Title {
            font-size:20px;
        }
        .Trans_Main {
            font-size: 15px;
        }
    }
</style>