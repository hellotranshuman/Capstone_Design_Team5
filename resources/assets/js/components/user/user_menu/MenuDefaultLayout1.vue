<!-- 기본 제공 레이아웃 1  persistent-->

<template>
<div class="container" style="width:100%; border:1px solid; " >
<v-container class="text_set" style="color:white">
    
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
    
    <!-- 메뉴 영역 -->
        <div v-for="n in range(0, menu_num-1)" :key="n" class="menu_body">        
            <v-card color="white" style="color: black;">                
                <!-- 메뉴 이미지 -->
                <div class="tem_img">
                    <img class="inner_img" :src="get_menus[n].path + get_menus[n].filename">
                </div>

                <!-- 메뉴 정보 -->
                <v-card-title primary-title style="padding:2%;"  elevation-20>                    
                    <!-- 메뉴 명 -->
                    <div class="menu-outer" style="width: 100%;">
                        <h3 class="menu_info"> {{get_menus[n].name}}</h3>
                    </div>                 

                    <!-- 메뉴 설명 -->
                    <div class="menu_expl"><div class="menu_info"> {{get_menus[n].explanation}}</div></div>
                                
                    <!-- 메뉴 점심 메뉴 / 저녁 메뉴 구분 -->
                    <div class="menu-outer" style="width: 100%;">
                        <h4 class="menu_info"> 런치 / 디너 구분 : &nbsp;{{get_menus[n].remark}} </h4>
                    </div> 
                                 
                    <!-- 메뉴 가격 -->
                    <div class="menu-outer" style="width:50%;">
                        <b class="menu_info" style="margin-top:2%; margin-left:2%;"> 
                            가격 : {{get_menus[n].price}} 
                        </b>
                    </div> 
                                                                                  
                    <!-- 주문하기 버튼 -->
                    <div class="menu-outer" style="width: 50%;">      
                        <button :id="n" @click="select_menu"
                            style="width:100%; padding-top:5%; color:cadetblue;">
                            선택하기
                        </button>
                    </div>
                </v-card-title>
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
        var url = '/menu/getCategory';
        var get_categorys = null;
        this.shop_id = this.$route.params.shop_id;      // 샵 아이디 

        // 카테고리 요청하기.
        axios.post(url, {
          'shop_id' : this.shop_id
        })
        .then( (response) => {
            get_categorys = response.data.category;
            this.categorys = this.unique(get_categorys); // 카테고리 중복 값 제거.
        })
        .catch((ex)=>{alert('메뉴 로드 실패');});          
    },
    
    data() {
        return {  
            e2           : null,       // 카테고리 클릭 값
            categorys    : null,       // 카테고리 배열
            get_menus    : null,       // 해당 카테고리 메뉴들
            menu_num : 0,              // 메뉴 출력 v-layout 갯수 
            select_menus : [],         // 상위 컴퍼넌트에 보낼 값
            shop_id      : null,       // 가게 아이디 값 
        }
    },

    methods : {
        // 메뉴 카테고리 클릭
        click_category : function() {
            let category = event.target;                        // 선택한 카테고리 
            let url = "";                          // 서버에 요청할 주소
            let send_data = [];

            // 클릭한 값 검사
            if(category.value === undefined) {
                category = category.parentNode.value;
            } else {
                category = category.value;
            }

            url = '/menu/getMenu/' + this.shop_id + '/' + category;

            // 보낼 데이터 초기화
            send_data['shop_id']  = this.shop_id;
            send_data['category'] = category;
 
            // 클릭한 카테고리의 메뉴 호출
            axios.get(url)
            .then( (response) => {
                this.get_menus = response.data.menu;
                this.menu_num  = this.get_menus.length;                  
            })
            .catch((ex)=>{
                alert('메뉴 로드 실패');
            });
 

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
            let menu = event.target;                            // 클릭한 메뉴 가져오기. 
            let arr  = [];

            arr['menu'] = this.get_menus[menu.id]
            this.select_menus.push(arr);    // 보낼 값 배열에 담기.  
            EventBus.$emit('select_menus', this.select_menus);
            alert('선택하신 메뉴가 추가 되었습니다.');
        }
    }// end of method

}// end of export default
</script> 

<style>
/* 모바일 */
@media (max-width: 639px){  
    .text_set       { font-size: 15px; }
    .menu_body { width:100%; margin:2%;} 
    .menu_expl { padding-bottom: 15%; }
}

/* 테블릿 */
@media (min-width: 640px) and (max-width: 1023px){
    .text_set       { font-size: 13px; }
    .menu_body { width:47%; margin:1%; }
    .menu_expl { padding-bottom: 15%; }
}

/* 데스트 탑 */
@media (min-width: 1024px){
    .text_set       { font-size: 12px; }
    .menu_body { width:31%; margin :1%;}
    .menu_expl { padding-bottom: 25%; }
} 

/* 메뉴 */
.menu_body { 
    float: left;
}

/* 메뉴 이미지 바깥 */
.tem_img {
    width: 100%;
    height: 0;
    padding-bottom: 70%;
    overflow: hidden;
    position: relative;
}
/* 메뉴 이미지 안쪽 */
.inner_img {
    top: 0;
    left: 0;
    width: 105%;
    height: 105%;
    position: absolute;
} 

/* 메뉴 정보 길고 얇은거 */
.menu-outer { 
    height: 0;  
    padding-bottom: 11%;   
    overflow: hidden;
    position: relative;
}
/* 메뉴 설명 */
.menu_expl { 
    width: 100%;
    height: 0; 
    
    overflow: auto;
    position: relative;
}

.menu_info {
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
    position: absolute;
}  
</style>
