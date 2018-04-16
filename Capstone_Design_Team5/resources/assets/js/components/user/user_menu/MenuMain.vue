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
                    <v-btn color="error" @click.native="Menu_Order = 2">주문하기</v-btn>
                </v-stepper-content>
                
                <!-- 2. 메뉴 확인 -->
                <v-stepper-content step="2">
                    <v-card color="white lighten-1" class="mb-5" height="200px"></v-card>

                    <!-- btn -->
                    <v-btn color="error" @click.native="Menu_Order = 3">확인</v-btn>
                    <v-btn flat @click.native="Menu_Order = 1">돌아가기</v-btn>
                </v-stepper-content>
                
                <!-- 3. 번역 -->
                <v-stepper-content step="3">
                    <v-card color="white lighten-1" class="mb-5" height="200px"></v-card>

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
import DefaultLayout1 from './MenuDefaultLayout1.vue';
// import DefaultLayout2 from './MenuDefaultLayout2.vue';
// import DefaultLayout3 from './MenuDefaultLayout3.vue';
// import DefaultLayout4 from './MenuDefaultLayout4.vue';
//import CustomLayout from './MenuDefaultLayout1.vue';

// 사용자 설정에 따라 레이아웃을 선택함.

var layout = DefaultLayout1;
   
export default { 

    data () {
        return {
            Menu_Order: 0,

            /* 주문 확인 창 */
            Ordercheck: false,

            /* 전자 메뉴판 */
            menu : [
                {
                    menuid : '',
                    shopid : '',
                    name : '',
                    explanation : '',
                    price : 1000,
                    category : '',
                    opNum : 1,
                    menuId : 1,
                    opName : '면 굵기',
                    subopName : '굵게',
                }
            ]
        }
    },
    methods : {
        OrderMenu() {
            
        }
    },
    components : {
        'Layout' : layout
    }
}
</script>
<style> 
</style>