<!-- 기본 제공 레이아웃 3 -->

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
        class="menu3_body"
    >        
        <v-card color="white" style="color: black; background-color: rgb(255, 248, 230);">                
            <!-- 메뉴 이미지 -->
            <div class="tem3_img">
                <!-- <img src="./example7.jpg" class="inner3_img">  -->
                <img :src="get_menus[n].path + get_menus[n].filename" class="inner3_img">
            </div>

            <!-- 메뉴 정보 -->
            <div class="menu3_info">                    
                <!-- 메뉴 명 --> 
                <div class="menu3_name"> 
                    <div class="expl3_inner">
                        {{get_menus[n].name}}
                    </div>
                </div> 

                <!-- 메뉴 설명 -->
                <div class="menu3_expl">
                    <div class="expl3_inner"> 
                        {{get_menus[n].explanation}}
                    </div>
                </div>
                            
                <!-- 메뉴 점심 메뉴 / 저녁 메뉴 구분 --> 
                <div class="menu3_remark"> 
                    Time : &nbsp;{{get_menus[n].remark}} 
                </div> <br>
                                
                <!-- 메뉴 가격 --> 
                <div class="menu3_price"> 
                    {{get_menus[n].price}}&nbsp;円
                </div> <br>
                                                                                
                <!-- 주문하기 버튼 -->  
                <div class="menu3-outer"> 
                    <button 
                        :id="n" 
                        @click="select_menu" 
                        class="menu3_select"                        
                    >
                         {{selectBtn}} 
                    </button> 
                </div> 
            </div>
        </v-card>
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
    .menu3_body      { width:100%; margin:1%;}  
    .menu3_name      { font-size: 1.9rem; }
    .menu3_expl      { font-size: 1.4rem; padding-bottom: 60%; margin: auto; margin-bottom: 15%;}    
    .menu3_remark    { font-size: 1.1rem; }    
    .menu3_price     { font-size: 1.9rem; margin: auto; margin-bottom: 15%;}    
    .menu3_select    { font-size: 1.5rem; }
}

/* 테블릿 */
@media (min-width: 640px) and (max-width: 1299px){   
    .menu3_body      { width:100%; margin:1%;}  
    .menu3_name      { font-size: 1.8rem; }
    .menu3_expl      { font-size: 1.3rem; padding-bottom: 60%; margin: auto; margin-bottom: 15%;}    
    .menu3_remark    { font-size: 1.1rem; }    
    .menu3_price     { font-size: 1.7rem; margin: auto; margin-bottom: 10%;}    
    .menu3_select    { font-size: 1.5rem; }
}

/* 데스트 탑 */
@media (min-width: 1300px){   
    .menu3_body      { width:48%; margin:1%; } 
    .menu3_name      { font-size: 1.8rem; }
    .menu3_expl      { font-size: 1.3rem; padding-bottom: 60%; margin: auto; margin-bottom: 10%;}    
    .menu3_remark    { font-size: 1.1rem; }    
    .menu3_price     { font-size: 1.3rem; margin: auto; margin-bottom: 5%;}    
    .menu3_select    { font-size: 1.7rem; }
} 

/* 메뉴 */
.menu3_body { 
    float: left;
    background-color: rgb(255, 248, 230); 
}

/* 메뉴 이미지 바깥 */
.tem3_img {
    width: 65%;
    height: 0; 
    padding-bottom: 60%;
    overflow: hidden;
    position: relative;
    float: left;
}
/* 메뉴 이미지 안쪽 */
.inner3_img { 
    top: 0;
    left: 0;
    width: 105%;
    height: 105%; 
    position: absolute;
    object-fit: cover;
} 

.menu3_info {    
    width: 35%;
    height: 0; 
    padding-bottom: 60%;
    background-color: rgb(255, 248, 230);
    float: left;
}

/* 메뉴 설명 */
.menu3_name { 
    width: 90%;   
    padding-bottom: 18%;
    margin: auto;
    margin-top: 10%;
    margin-bottom: 10px;
    border-bottom: 2px solid #ff9a55;
    font-weight: bold;
    text-align: left;
    color: rgb(70, 54, 44); 
    position: relative;  
}

/* 메뉴 설명 */
.menu3_expl { 
    width: 90%;
    height: 0;       
    color: #6d4d35;  
    font-weight: bold;
    overflow: hidden; 
    position: relative; 
}
.expl3_inner {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    font-weight: bold; 
    position: absolute; 
    overflow: auto;
    overflow-x: hidden;
}
.expl3_inner::-webkit-scrollbar {
    width: 0px;                     /* remove scrollbar space */
    background: transparent;        /* optional: just make scrollbar invisible */
}

/* 런치 디너 구분 */
.menu3_remark { 
    width: 90%;
    height: 0;   
    font-weight: bold;
    color: rgb(109, 77, 53);  
    position: relative; 
    margin: auto; 
    margin-bottom: 1%;
}

/* 메뉴 가격 */
.menu3_price { 
    width: 90%;
    height: 0;   
    font-weight: bold;
    color: rgb(109, 77, 53);   
    position: relative; 
}


/* 메뉴 정보 길고 얇은거 */
.menu3-outer { 
    width: 90%;
    height: 0;  
    padding-bottom: 20%;    
    margin: auto;
    overflow: hidden;
    position: relative;  
} 
.menu3_select{ 
    top: 0;
    left: 0%;
    width:100%;  
    height: 100%;
    border: 3px solid #d2b07d;
    font-weight: bold; 
    color:rgb(70, 54, 44);  
    position: absolute;            
}
</style>
