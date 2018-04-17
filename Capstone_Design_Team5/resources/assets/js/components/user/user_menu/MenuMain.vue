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
                    <v-card color="white lighten-1" class="mb-5">

                        <v-container> 
                            <v-layout v-for="i in range(0, click_menu.length-1)" :key="i"
                                style="margin-bottom:5%;"> 

                                <v-flex xs2 color="white" class="div_img">
                                    <img src="" class="menu_img">
                                </v-flex>

                                <v-flex xs4 class="div_img">
                                    <v-card class="menu_img" elevation-20>
                                        <v-card-text style="font-size:1.2rem">
                                            <b> 메뉴명 : {{click_menu[i].menu.name}} </b>
                                        </v-card-text> 
                                        <v-card-text style="font-size:1.2rem"> 
                                            <b v-if="click_menu[i].option !== undefined"> 옵션명 : {{click_menu[i].menu.optionName1}} </b>
                                        </v-card-text> 
                                    </v-card>
                                </v-flex>

                                <v-flex xs4 class="div_img">
                                    <v-card class="menu_img" elevation-20> 
                                        <v-card-text style="font-size:1.2rem"> 
                                            <b> 가격 : {{click_menu[i].menu.price}} </b> 
                                        </v-card-text> 
                                        <v-card-text style="font-size:1.2rem"> 
                                            <b v-if="click_menu[i].option !== undefined"> 선택 옵션 : {{click_menu[i].option.value}} </b>
                                        </v-card-text>
                                    </v-card>
                                </v-flex>  


                            </v-layout>                            
                        </v-container> 
                         
                    </v-card>

                    <!-- btn -->
                    <v-btn color="error" @click.native="Menu_Order = 3">확인</v-btn>
                    <v-btn flat @click.native="Menu_Order = 1">돌아가기</v-btn>
                </v-stepper-content>
                
                <!-- 3. 번역  height="200px"-->
                <v-stepper-content step="3">
                    <v-card color="white lighten-1" class="mb-5"></v-card>

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
                            <v-btn color="error" @click.stop="Ordercheck=false, OrderMenu">확인</v-btn>
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

var layout = DefaultLayout1;    // 사장이 선택한 메뉴판 탬플릿
var obj    = [];                   // 클릭한 배열 담기
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


            // itemList2 : [],
            // itemList:[], 
            // test : "",
        }
    },
    methods : {
        OrderMenu() {
            
        },
        // 주문하기 버튼 클릭 시 호출되는 함수
        check_menus : function() {
            // alert('안녕?');
            this.click_menu = obj;
            console.log(this.click_menu);
        }, 
        // v-for 용 함수, start에서 시작해서 end까지 1식 반환
        range : function (start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },
    },
    components : {
        'Layout' : layout
    }
}
</script>

<style> 

.div_img {
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 15%;
}
.menu_img { 
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
} 
</style>