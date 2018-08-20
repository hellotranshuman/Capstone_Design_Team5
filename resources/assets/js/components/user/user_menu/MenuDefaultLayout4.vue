<!-- 기본 제공 레이아웃 4 -->
<template>
<div class="container" style="width:100%; color:black">
<v-container style="color:white"> 
    <!--스낵바 : 경고 창 출력-->
    <v-snackbar :timeout="timeout" :top="'top'" v-model="snackbar">
        {{ snackbar_text }}
        <v-btn flat color="pink" icon @click.native="snackbar = false">
            <v-icon large> close </v-icon>
        </v-btn>
    </v-snackbar>      

    <!-- 카테고리 영역 -->
    <v-layout xs12> 
        <v-card style="margin:auto">
            <v-bottom-nav :value="true" :active.sync="e2">
                <v-btn 
                    v-for="(value,key) in categorys" 
                    :key="key" 
                    :value="value" 
                    @click="click_category"
                >
                    {{value}} 
                </v-btn>
            </v-bottom-nav>
        </v-card>
    </v-layout> 

    <!-- 메뉴 영역 -->
    <div 
        v-for="n in range(0, menu_num-1)" 
        :key="n" 
        class="menu4_body"
    >        
        <!-- 메뉴 이미지 --> 
        <!-- <img src="./example7.jpg" class="menu4_img">  -->
        <img :src="get_menus[n].path + get_menus[n].filename" class="menu4_img">

        <!-- 메뉴 정보 그라데이션 --> 
        <div id="menu4InfoGra"> </div>

        <!-- 메뉴 정보 --> 
        <div id="menu4Info">
            <!-- 메뉴 명 --> 
            <div class="menu4_name"> 
                {{get_menus[n].name}}
            </div> 

            <!-- 메뉴 설명 -->
            <div class="menu4_expl">
                <div class="expl4_inner"> 
                    {{get_menus[n].explanation}}
                </div>
            </div>

            <!-- 메뉴 구분/가격/선택 -->
            <v-layout class="menu4_rps">
                <v-flex xs7>
                    <div class="menu4_remark"> 
                        Time : &nbsp;{{get_menus[n].remark}} 
                    </div>
                                    
                    <!-- 메뉴 가격 --> 
                    <div class="menu4_price"> 
                        {{get_menus[n].price}}&nbsp;원 
                    </div>
                </v-flex>

                <v-spacer></v-spacer>

                <v-flex xs4> 
                    <button :id="n" @click="select_menu" class="menu4_select">
                         {{selectBtn}} 
                    </button>  
                </v-flex>
            </v-layout>
        </div>
    </div> 
</v-container> 
</div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';
import { EventBus } from './eventBus.js';
  
export default {
   
    created() {
        let url           = '/menu/getCategory';
        let get_categorys = null;
        let shop_id       = this.$route.params.shop_id;      // 샵 아이디 
        let notion = this.$session.get('user_country');
 
        // 카테고리 요청하기.
        axios.post(url, {
          'shop_id' : shop_id
        })
        .then( (response) => {
            get_categorys = response.data.category;
            this.categorys = this.unique(get_categorys); // 카테고리 중복 값 제거.
        })
        .catch((ex)=>{ 
        });          
        
        switch(notion){
            case 'Korea': this.selectBtn = '선택하기';   break;
            case 'Japan': this.selectBtn = '選択';      break;
            case 'China': this.selectBtn = '選択';      break;
            case 'USA':   this.selectBtn = 'Select';   break;
        } 
    },
    
    data() {
        return {  
            // 스낵바 설정값
            timeout         : 2000,
            snackbar_text   : '',
            snackbar        : false,

            e2              : null,     // 카테고리 클릭 값
            categorys       : null,     // 카테고리 배열
            get_menus       : null,     // 해당 카테고리 메뉴들
            menu_num        : 0,        // 메뉴 출력 v-layout 갯수 
            select_menus    : [],       // 상위 컴퍼넌트에 보낼 값
            shop_id         : null,     // 가게 아이디 값 
            selectBtn    : '選択'
        }
    },

    methods : {
        // 메뉴 카테고리 클릭
        click_category : function() {
            let category = event.target;                    // 선택한 카테고리 
            let url      = "";                              // 서버에 요청할 주소 
            let shop_id  = this.$route.params.shop_id;      // 샵 아이디 
             
            // 클릭한 값 검사
            if(category.value === undefined) {
                category = category.parentNode.value;
            } else {
                category = category.value;
            }
            url = '/menu/getMenu/' + shop_id + '/' + category;
 
            // 클릭한 카테고리의 메뉴 호출
            axios.get(url)
            .then( (response) => {
                this.get_menus = response.data.menu; 
                this.menu_num  = this.get_menus.length;                  
            })
            .catch((ex)=>{ 
            });
            
            this.translate();
        }, // end of click_category
                
        // 칼럼 번역하기.
        translate : function( ){
            let notion = this.$session.get('user_country');
            
            for(let i=0; i < this.menu_num; i++){

                switch(this.get_menus[i].remark){
                    case '디너 메뉴' : 
                             if(notion == 'Korea') this.get_menus[i].remark = '디너 메뉴'
                        else if(notion == 'Japan') this.get_menus[i].remark = 'ディナ'
                        else if(notion == 'China') this.get_menus[i].remark = 'Dinner '
                        else if(notion == 'USA')   this.get_menus[i].remark = 'Dinner '                        
                    break;

                    case '런치 메뉴' :
                             if(notion == 'Korea') this.get_menus[i].remark = '런치 메뉴'
                        else if(notion == 'Japan') this.get_menus[i].remark = 'ランチ'
                        else if(notion == 'China') this.get_menus[i].remark = 'Lunch'
                        else if(notion == 'USA')   this.get_menus[i].remark = 'Lunch'  
                    
                    break;

                    case '상관 없음' : 
                             if(notion == 'Korea') this.get_menus[i].remark = '상관 없음'
                        else if(notion == 'Japan') this.get_menus[i].remark = '関係ない'
                        else if(notion == 'China') this.get_menus[i].remark = 'All time'
                        else if(notion == 'USA')   this.get_menus[i].remark = 'All time'                      
                    break;
                }                
            }
        },

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
            return Array(end - start + 1).fill().map((_, idx) => start + idx);
        },

        // 주문하기 클릭한 메뉴
        select_menu : function () {
            let menu = event.target;                            // 클릭한 메뉴 가져오기. 
            let arr  = [];

            arr['menu'] = this.get_menus[menu.id]
            this.select_menus.push(arr);    // 보낼 값 배열에 담기.  
            EventBus.$emit('select_menus', this.select_menus);
            this.snackbar_text = '선택하신 메뉴가 추가 되었습니다.';
            this.snackbar = true;
        }
    }// end of method
}
</script>

<style scoped>

/* 모바일 */
@media (max-width: 639px){   
    .menu4_body      { width:100%; padding-bottom: 130%; margin:1%; } 
    .menu4_name      { font-size: 2.3rem; }
    .menu4_expl      { font-size: 1.5rem; }    
    .menu4_remark    { font-size: 1.5rem; }    
    .menu4_price     { font-size: 1.7rem; }    
    .menu4_select    { font-size: 1.7rem; }
}

/* 테블릿 */
@media (min-width: 640px) and (max-width: 1023px){   
    .menu4_body      { width:47%; padding-bottom: 63%; margin:1%; } 
    .menu4_name      { font-size: 1.7rem; }
    .menu4_expl      { font-size: 1rem; }    
    .menu4_remark    { font-size: 0.9rem; }    
    .menu4_price     { font-size: 1.3rem; }    
    .menu4_select    { font-size: 1.3rem; }
}

/* 데스트 탑 */
@media (min-width: 1024px){   
    .menu4_body      { width:31%; padding-bottom: 45%; margin :1%;} 
    .menu4_name      { font-size: 2rem; }
    .menu4_expl      { font-size: 1.2rem; }    
    .menu4_remark    { font-size: 1rem; }    
    .menu4_price     { font-size: 1.2rem; }    
    .menu4_select    { font-size: 1.3rem; }
} 

/* 메뉴 */
.menu4_body {  
    height: 0;
    overflow: hidden;
    position: relative;
    float: left; 
}
 
/* 메뉴 이미지 안쪽 */
.menu4_img { 
    top: 0;
    left: 0;
    width: 105%;
    height: 105%; 
    position: absolute;
    object-fit: cover;
} 

#menu4InfoGra {
    z-index: 2;
    top: 65%;
    width: 100%;
    height: 35%;    
    background-image: 
        linear-gradient( 
            to bottom, 
            rgba(0,0,0,0),
            rgba(0,0,0,0.7),
            rgba(0,0,0,1)
        );
    position: absolute;
}

/* 메뉴 정보  */
#menu4Info {
    z-index: 3;
    top: 65%;
    width: 100%;
    height: 35%;
    padding: 1%;  
    color: #ffffff; 
    position: absolute;
    font-weight: bold;
    text-align: left;    
}
 
/* 메뉴 이름 */
.menu4_name { 
    width: 100%;    
    height: 20%; 
    margin-bottom: 1%; 
    overflow: hidden;
    position: relative;   
}

/* 메뉴 설명 */
.menu4_expl { 
    width: 96%;
    height: 45%;     
    margin: auto;
    margin-bottom: 2%;
    opacity: 0.8;  
    overflow: hidden; 
    position: relative;  
}
.expl4_inner {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
    font-weight: bold; 
    position: absolute; 
    overflow: auto; 
    overflow-x: hidden; 
}
/* 설명 스크롤바 없애기 */
.expl4_inner::-webkit-scrollbar {
    width: 0px;                     /* remove scrollbar space */
    background: transparent;        /* optional: just make scrollbar invisible */
}

/* 구분/가격/선택 */
.menu4_rps{
    width: 100%;
    height: 30%;     
    margin-bottom:  1%; 
    padding-right:  2%;  
    padding-left:   2%;  
    padding-bottom: 2%;  
}

/* 런치 디너 구분 */
.menu4_remark { 
    width: 100%;
    height: 50%;   
    font-weight: bold; 
    position: relative; 
    margin: auto; 
}

/* 메뉴 가격 */
.menu4_price { 
    width: 100%;
    height: 50%;   
    font-weight: bold;   
    position: relative; 
    margin: auto;
    margin-bottom: 20px;
}

/* 메뉴 선택 */
.menu4_select{  
    width: 100%;  
    height: 90%; 
    border:2px solid #ffffff;
    font-weight: bold;  
    margin: auto;     
    position: relative;       
}
</style>
