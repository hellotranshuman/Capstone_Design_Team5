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
                        @click="check_menus">
                        주문하기
                    </v-btn>
                </v-stepper-content>
                
                <!-- 2. 메뉴 확인  height="200px" -->
                <v-stepper-content step="2">
                    <v-card color="white lighten-1" class="mb-5" >

                        <v-container :id="'menu_check_container'"> 
                            <v-layout v-for="i in range(0, click_menu.length-1)" :key="i" 
                                :id="'menu_layout'+i"  mb-3> 
 
                                <v-flex xs4 >
                                    <v-card elevation-20>

                                        <v-card-text style="font-size:1.2rem" class="info_div">
                                            <div class="menu_info">
                                                <b> 메뉴명 : {{click_menu[i].menu.name}} </b>
                                            </div>
                                        </v-card-text> 

                                        <v-card-text style="font-size:1.2rem" class="info_div"> 
                                            <div class="menu_info">
                                                <b v-if="click_menu[i].option !== undefined"> 
                                                    옵션명 : {{click_menu[i].menu.optionName1}} 
                                                </b>
                                            </div>
                                        </v-card-text> 

                                    </v-card>
                                </v-flex>

                                <v-flex xs4>
                                    <v-card  elevation-20> 

                                        <v-card-text style="font-size:1.2rem" class="info_div"> 
                                            <div class="menu_info">
                                                <b> 가격 : {{click_menu[i].menu.price}} </b> 
                                                <v-btn icon 
                                                    style="float : right" 
                                                    @click="click_cancel"
                                                    :id="i"
                                                >
                                                    <v-icon dark> close </v-icon>
                                                </v-btn>
                                            </div>
                                        </v-card-text> 

                                        <v-card-text style="font-size:1.2rem" class="info_div"> 
                                            <div class="menu_info">
                                                <b v-if="click_menu[i].option !== undefined"> 
                                                    선택 옵션 : {{click_menu[i].option.value}} 
                                                </b>
                                            </div>
                                        </v-card-text>
                                        
                                    </v-card>
                                </v-flex>  
                            </v-layout>                                            
                        </v-container>   
                    </v-card>
                    <div style="margin-bottom:0">
                        <v-flex xs12 class="info_div">
                            <v-card class="menu_info">
                                <b style="margin-right:10%; font-size: 2rem"> 총 : {{click_menu.length}} 개 </b> 
                                <b style="margin-right:10%; font-size: 2rem"> 합계 : {{sum_price}} 円 </b>
                            </v-card> 
                        </v-flex>
                    </div>    

                    <!-- btn -->
                    <v-btn color="error" @click.native="Menu_Order = 3"
                        @click="translate_menu"
                    >
                        확인
                    </v-btn>
                    <v-btn flat @click.native="Menu_Order = 1">돌아가기</v-btn>
                </v-stepper-content>
                
                <!-- 3. 번역  height="200px"-->
                <v-stepper-content step="3">
                    <v-card color="white lighten-1" class="mb-5">
                        <v-card-text 
                            v-for="j in range(0, translateText.length-1)" :key="j">
                            <b style="margin-right:10%; font-size: 2rem; color:black"> 
                                {{ translateText[j] }} 
                            </b>
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
                                <v-btn color="error" to="/restaurant/1/info" @click.stop="Ordercheck=false, OrderMenu">
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

// 사용자 설정에 따라 레이아웃을 선택함.
import DefaultLayout1 from './MenuDefaultLayout1.vue';
// import DefaultLayout2 from './MenuDefaultLayout2.vue';
// import DefaultLayout3 from './MenuDefaultLayout3.vue';
// import DefaultLayout4 from './MenuDefaultLayout4.vue';
//import CustomLayout from './MenuDefaultLayout1.vue';      // 아직

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
        }
    },
    methods : {
        // 메뉴 번역 - 확인 버튼 클릭 시 호출되는 함수
        OrderMenu() {
            
        },
        // 주문하기 버튼 클릭 시 호출되는 함수
        check_menus : function() {
            // alert('안녕?');
            this.click_menu = obj;
            this.sum_price = 0;
            console.log(this.click_menu);

            for(let i=0; i< this.click_menu.length; i++){
                this.sum_price += this.click_menu[i].menu.price
            }
        }, 
        // v-for 용 함수, start에서 시작해서 end까지 1식 반환
        range : function (start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },
        click_cancel : function() {
            var id          = event.target.parentNode.id;                        // 클릭한 메뉴 click_menu의 배열 키 값
            var container   = document.getElementById('menu_check_container');   // 메뉴 확인 창
             
            this.sum_price  = this.sum_price - this.click_menu[id].menu.price;   // 총 가격 빼기
            this.click_menu.splice(id, 1);                                       // 선택한 메뉴 배열에서 취소한 메뉴 삭제
            // console.log(this.click_menu);
            alert('선택한 메뉴를 취소하였습니다.');
        },
        translate_menu : function() {
            // 번역할 문장 만들기.
            for(let i=0; i < this.click_menu.length; i++){
                var text = this.click_menu[i].menu.name + " : ";

                if(this.click_menu[i].option !== undefined){
                    text += this.click_menu[i].menu.optionName1 + "은 " +
                        this.click_menu[i].option.value + "으로" ;
                }
                
                text += " 한 개";

                this.translateText[i] = text;
            }
            console.log(this.translateText);
        }
    },
    components : {
        'Layout' : layout
    }
}
</script>

<style> 

.info_div {
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 10%;
}
.menu_info { 
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
    padding:3%;
} 
</style>