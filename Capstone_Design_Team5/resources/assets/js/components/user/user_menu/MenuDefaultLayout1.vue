<!-- 기본 제공 레이아웃 1  persistent-->

<template>
<div class="container" style="width:100%; border:1px solid; "> 
<v-container style="color:white">
    
    <!-- 카테고리 영역 -->
    <v-layout xs12> 
            <v-card style="margin:auto">
            <v-bottom-nav :value="true" :active.sync="e2">
                <v-btn 
                    v-for="(value,key) in categorys" :key="key"
                    :value="value" @click="click_category" >
                    {{value}} 
                </v-btn>
            </v-bottom-nav>
        </v-card>
    </v-layout> 
    
    <!-- 메뉴 영역 메뉴 비율 고정 시키기-->
    <v-layout xs12 
        v-if="menu_row_num !== 0" 
        v-for="index in range(0, menu_row_num-1)" :key="index">
        
        <v-flex 
            v-for="n in range( index*3, index * 3 + 2)" :key="n"  
            v-if="n < get_menus.length"
            xs4 elevation-20 mx-3 my-3 >
        
            <v-card color="white" style="color:black;">
                
                <div class="tem_img">
                    <!-- <img :src="get_menus[n].path + get_menus[n].filename"> -->
                    <img src="">
                </div>

                <v-card-title primary-title>
                    <div class="menu_name">
                        <h3 class="menu_info"> {{get_menus[n].name}} </h3>
                    </div>
                    <div class="menu_expl">
                        <div class="menu_info"> {{get_menus[n].explanation}} </div>
                    </div>

                    <div class="menu_name" style="margin-top:5%;">
                        <h4 v-if="get_menus[n].optionValue1 !== undefined" 
                            style="float:left; width:50%;">
                            옵션 : {{get_menus[n].optionName1}}
                        </h4>
                        <select 
                            :id="'value'+n" v-if="get_menus[n].optionValue1 !== undefined"
                            style="float:left; width:50%;">
                            <!--    -->
                            <option
                            v-for="(value, key) in options[n]" :key="key"
                            v-if ="value !== undefined"
                                :value="value" >
                                {{value}}
                            </option>
                        </select>
                    </div>

                    <div class="menu_price">
                        <h4 class="menu_info"> 가격 : {{get_menus[n].price}} </h4>
                    </div> 
                    
                    <div class="menu_price">     
                        <v-btn color="primary" slot="activator" 
                            width=100%; @click="select_menu" flat :id="n">
                            주문하기
                        </v-btn>
                    </div>
                </v-card-title>
            </v-card>
        </v-flex>
    </v-layout>
 
</v-container> 
</div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';
import { EventBus } from './eventBus.js';
  
export default {

    created() {
        var url = '';
        var get_categorys = null;
        this.shop_id = this.$route.params.shop_id;      // 샵 아이디 

        // 카테고리 요청하기.
        // axios.post(url, this.shop_id)
        // .then( (response) => {
        //     get_categorys = response.data 
        //     this.categorys = this.unique(get_categorys); // 카테고리 중복 값 제거.
        // })
        // .catch((ex)=>{
        //     alert('메뉴 로드 실패');
        // });
         
        get_categorys = [   
            {"category" : '특식'},
            {"category" : '추천 메뉴'},
            {"category" : '식사류'},
            {"category" : '찌개류'},
            {"category" : '안주류'},
            {"category" : '음료'},
            {"category" : '커피'},
            {"category" : '디저트'},  
            {"category" : '특식'},
            {"category" : '추천 메뉴'},
            {"category" : '식사류'},
            {"category" : '찌개류'},
            {"category" : '안주류'},
            {"category" : '음료'},
            {"category" : '커피'},
            {"category" : '디저트'},  
            {"category" : '특식'},
            {"category" : '추천 메뉴'},
            {"category" : '식사류'},
            {"category" : '찌개류'},
            {"category" : '안주류'},
            {"category" : '음료'},
            {"category" : '커피'},
            {"category" : '디저트'},  
            {"category" : '특식'},
            {"category" : '추천 메뉴'},
            {"category" : '식사류'},
            {"category" : '찌개류'},
            {"category" : '안주류'},
            {"category" : '음료'},
            {"category" : '커피'},
            {"category" : '디저트'},  
            {"category" : '특식'},
            {"category" : '추천 메뉴'},
            {"category" : '식사류'},
            {"category" : '찌개류'},
            {"category" : '안주류'},
            {"category" : '음료'},
            {"category" : '커피'},
            {"category" : '디저트'},  
            {"category" : '특식'},
            {"category" : '추천 메뉴'},
            {"category" : '식사류'},
            {"category" : '찌개류'},
            {"category" : '안주류'},
            {"category" : '음료'},
            {"category" : '커피'},
            {"category" : '디저트'},  
        ]
        this.categorys = this.unique(get_categorys); // 카테고리 중복 값 제거.
    },
    
    data() {
        return {  
            e2           : null,       // 카테고리 클릭 값
            categorys    : null,       // 카테고리 배열
            get_menus    : null,       // 해당 카테고리 메뉴들
            menu_row_num : 0,          // 메뉴 출력 v-layout 갯수 
            select_menus : [],         // 상위 컴퍼넌트에 보낼 값
            shop_id      : null,       // 가게 아이디 값
            options      : []
        }
    },

    methods : {
        // 메뉴 카테고리 클릭
        click_category : function() {
            var category = event.target;                        // 선택한 카테고리 
            var url = "선주야 부탁한다!"                          // 서버에 요청할 주소 
            var send_data = [];

            // 클릭한 값 검사
            if(category.value === undefined) {
                category = category.parentNode.value;
            } else {
                category = category.value;
            }

            // 보낼 데이터 초기화
            send_data['shop_id']  = this.shop_id;
            send_data['category'] = category;
 
            // 클릭한 카테고리의 메뉴 호출
            // axios.post(url, send_data)
            // .then( (response) => {
            //     this.get_menus = response.data 

            //     // 출력할 v-layout 개수 설정
            //     if( this.get_menus.length%3 === 0 ){
            //         this.menu_row_num = this.get_menus.length / 3;
            //     }
            //     else {
            //         this.menu_row_num = Math.floor(this.get_menus.length / 3) + 1;
            //     }

            //     // 옵션 값 뽑아내기
            //     for(let i=0; i < this.get_menus.length; i++) {   
            //         this.options[i] = [];
            //         for(let j=1; j <= this.get_menus[i].subOpNum; j++){
            //             this.options[i].push(this.get_menus[i]['optionValue'+j] );
            //         }
            //     }    
            // })
            // .catch((ex)=>{
            //     alert('메뉴 로드 실패');
            // });

            this.get_menus = [
                { 
                    "id"            : 1, 
                    "name"          : "짬뽕" ,
                    "explanation"   : "짬뽕입니다." ,
                    "price"         : 9000 ,
                    "remark"        : "default" ,
                    "path"          : "/images/menu/1/" ,
                    "filename"      : "1_menuImg_1.jpeg" ,
                    "optionName1"   : "맵기 조절" ,
                    "optionValue1"  : "순한맛" ,
                    "optionValue2"  : "보통맛" ,
                    "optionValue3"  : "매운맛" ,
                    "subOpNum"      : 3
                }, 
                { 
                    "id"            : 2,
                    "name"          : "연두부", 
                    "explanation"   : "연두부" ,
                    "price"         : 5000,
                    "remark"        : "default", 
                    "path"          : "/images/menu/1/", 
                    "filename"      : "1_menuImg_2.jpeg" ,
                    "optionName1"   : "소스" ,
                    "optionValue1"  : "특제 소스" ,
                    "optionValue2"  : "간장 소스" ,
                    "subOpNum"      : 2,
                },                 
                { 
                    "id"            : 3 ,
                    "name"          : "케이크" ,
                    "explanation"   : "123123" ,
                    "price"         : 9999,
                    "remark"        : "default",
                    "path"          : "/images/menu/1/" ,
                    "filename"      : "1_menuImg_3.jpeg",
                    "optionName1"   : "없으면 입력 x" ,
                    "subOpNum"      : 0
                },   
            ];

            // 출력할 v-layout 개수 설정
                if( this.get_menus.length%3 === 0 ){
                    this.menu_row_num = this.get_menus.length / 3;
                }
                else {
                    this.menu_row_num = Math.floor(this.get_menus.length / 3) + 1;
                }

                // 옵션 값 뽑아내기
                for(let i=0; i < this.get_menus.length; i++) {   
                    this.options[i] = [];
                    for(let j=1; j <= this.get_menus[i].subOpNum; j++){
                        this.options[i].push(this.get_menus[i]['optionValue'+j] );
                    }
                }   

        }, // end of click_category

        // 배열 중복 값 제거, 인자는 서버에 받은 카테고리 목록
        unique : function(argArr) {
            var array = [];
 
            for(let i=0; i < argArr.length; i++){
                // array에 없는 값이면 push
                if( !array.includes(argArr[i]['category']) ) { 
                    array.push(argArr[i]['category']);
                }
            }
            return array;
        },

        // v-for 용 함수, start에서 시작해서 end까지 1식 반환
        range : function (start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },

        // 주문하기 클릭한 메뉴
        select_menu : function () {
            var menu  = event.target.parentNode;                     // 클릭한 메뉴 가져오기.
            var array = [];

            // 클릭한 메뉴 테두리 붉게
            // menu.parentNode.parentNode.parentNode.parentNode.style = "border: 3px solid red;"   

            array['menu'] = this.get_menus[menu.id];

            console.log(this.get_menus[menu.id]);

            if( this.get_menus[menu.id].optionValue1 !== undefined){
                var op_val = document.getElementById('value'+menu.id);  // 선택한 옵션 값 가져오기.

                array['option'] = { 'value' : op_val.value };
            }
            this.select_menus.push(array); 
            // console.log( this.select_menus );

            EventBus.$emit('select_menus', this.select_menus)
            alert('선택하신 메뉴가 추가 되었습니다.');
        }

    }// end of method

}// end of export default
</script>

<style>
.tem_img {
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 70%;
}
img { 
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
} 
.menu_name { 
    position: relative;
    width: 100%;
    height: 0; 
    overflow: hidden;
    padding-bottom: 10%;
}
.menu_expl { 
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 15%; 
}
.menu_price { 
    position: relative;
    width: 50%;
    height: 0; 
    overflow: hidden;
    padding-bottom: 12%; 
}
.menu_info {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
} 
select {
    widows: 100%;
    border-bottom: 1px solid;
}
</style>
