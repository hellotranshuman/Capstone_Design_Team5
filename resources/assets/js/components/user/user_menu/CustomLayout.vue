<!-- 커스텀마이징한 템플릿 -->
<template>
<div class="container" style="width:100%; border:1px solid; "> 
<v-container style="color:white">
    <!--스낵바 : 경고 창 출력-->
    <v-snackbar 
        v-model="snackbar"
        :timeout="timeout" 
        :top="'top'" 
    >
        {{ snackbar_text }}
        <v-btn 
            @click.native="snackbar = false"
            color="pink" 
            icon flat 
        >
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
                    {{ value }} 
                </v-btn>
            </v-bottom-nav>
        </v-card>
    </v-layout> 
    
    <!-- 메뉴 영역 -->
    <div 
        name="createdMenu" 
        v-for="n in range(0, menu_num-1)" 
        :key="n" 
        class="menu_body"
    >        
        <!-- 메뉴 이미지 -->
        <div name="createdImg" style="overflow:hidden">
            <!-- <img class="menu_img" src="./example7.jpg"> -->
            <img class="menu_img" :src="get_menus[n].path + get_menus[n].filename">
        </div>
            
        <!-- 메뉴 명 -->
        <div name="createdName">
            <h3 class="menu_info"> 
                {{get_menus[n].name}} 
            </h3>
        </div>                 

        <!-- 메뉴 설명 -->
        <div name="createdExpl">
            <div class="menu_info">
                {{get_menus[n].explanation}}
            </div>
        </div>
                    
        <!-- 메뉴 점심 메뉴 / 저녁 메뉴 구분 -->
        <div name="createdL_D">
            <h4 class="menu_info"> 
                Time : &nbsp;{{get_menus[n].remark}} 
            </h4>
        </div> 
                        
        <!-- 메뉴 가격 -->
        <div name="createdPrice">
            <b class="menu_info" style="margin-top:2%; margin-left:2%;"> 
                {{get_menus[n].price}}円
            </b>
        </div> 
                                                                        
        <!-- 주문하기 버튼 -->
        <div name="createdSelect" class="menu_element">      
            <button :id="n" @click="select_menu" class="SelectBtn"> 
                {{selectBtn}} 
            </button>
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
        let url = '/menu/getCategory';
        let get_categorys = null;                       // 카테고리 값들을 받을 변수
        let get_menuData  = null;                       // 커스텀마이징 메뉴판 JSON 값 받을 변수
        let shop_id = this.$route.params.shop_id;       // 샵 아이디  
        let notion = this.$session.get('user_country');

        // 카테고리 && 커스텀 메뉴판 JSON 값 요청 요청하기.
        axios.post(url, {
            'shop_id' : shop_id
        })
        .then( (response) => {
            get_categorys  = response.data.category;                    // 카테고리 값 받기
            get_menuData   = response.data.layout[0].layout_data;       // 커스텀 메뉴판 값
            this.categorys = this.unique(get_categorys);                // 카테고리 중복 값 제거.
            this.MenuData  = JSON.parse(get_menuData);          
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

            e2           : null,       // 카테고리 클릭 값
            categorys    : null,       // 카테고리 배열
            MenuData     : null,       // 메뉴 스타일
            get_menus    : null,       // 해당 카테고리 메뉴들
            menu_num     : 0,          // 메뉴 출력 v-layout 갯수 
            select_menus : [],         // 상위 컴퍼넌트에 보낼 값
            shop_id      : null,       // 가게 아이디 값 

            selectBtn    : '選択'
        }
    },

    updated() {
        this.setMenuItem();     // 메뉴 설정.
    }, 

    methods : {
        // 메뉴 요소들 스타일 추가
        setMenuItem : function(){ 
            if(this.MenuData == null ) return;

            let MenuWidth   = 0;                                            // 메뉴의 가로 길이(%)
            let MenuHeight  = 0;                                            // 메뉴의 세로 길이(%)
            let MenuMargin  = this.MenuData.MenuMargin;                     // 메뉴 간격 (%)
            let browser_w   = window.outerWidth;                            // 브라우저의 width (px)             
            let createdMenu = document.getElementsByName('createdMenu');    // 메뉴 div
                        
            // 모바일 : 한줄에 메뉴 1개
            if(browser_w < 639){ 
                MenuWidth = 100;
            }
            // 테블릿 : 한 줄에 메뉴 2개 
            else if(638 < browser_w && browser_w < 1024){ 
                MenuWidth = 50 - (MenuMargin * 2);
            }
            // 데스크 탑 : 100 / 한 줄에 올 메뉴 갯수 - 메뉴 간격 값 * 2 
            else if(1023 < browser_w){ 
                MenuWidth = Math.floor(100 / this.MenuData.MenuNum) - (MenuMargin * 2);
            }

            // 메뉴 세로 비율 값 구하기.
            MenuHeight = Math.floor(MenuWidth * this.MenuData.createdMenu.ratio / 100);

            for(let i=0; i < createdMenu.length; i++){ 
                let MenuData = this.MenuData.createdMenu;                           // 메뉴 스타일 

                // 메뉴 스타일 지정.
                createdMenu[i].style.width           = MenuWidth  + '%';            // 메뉴 가로
                createdMenu[i].style.paddingBottom   = MenuHeight + '%';            // 메뉴 세로
                createdMenu[i].style.margin          = MenuMargin + '%';            // 메뉴 간격
                createdMenu[i].style.border          = MenuData.border;             // 선 
                createdMenu[i].style.color           = MenuData.color;              // 색
                createdMenu[i].style.backgroundColor = MenuData.backgroundColor;    // 배경색
                createdMenu[i].style.borderRadius    = MenuData.borderRadius;       // 테두리

                for(let j=0; j < createdMenu[i].children.length; j++){ 
                    let item  = createdMenu[i].children[j];                     // 메뉴 div 안의 엘리먼트
                    let index = item.getAttribute('name');                      // 엘리먼트의 name 속성
                    
                    // 엘리먼트 스타일 지정
                    item.style.top             = this.MenuData[index].top;                 
                    item.style.left            = this.MenuData[index].left;
                    item.style.width           = this.MenuData[index].width;
                    item.style.height          = this.MenuData[index].height;
                    item.style.zIndex          = this.MenuData[index].zIndex; 
                    item.style.border          = this.MenuData[index].border;
                    item.style.color           = this.MenuData[index].color;
                    item.style.backgroundColor = this.MenuData[index].backgroundColor;
                    item.style.borderRadius    = this.MenuData[index].borderRadius; 
                    item.style.position        = 'absolute';                      

                    // 이미지 테두리 맞추기.
                    if(index == 'createdImg'){
                        item.children[0].style.borderRadius = this.MenuData[index].borderRadius; 
                    }
                }                
            }
        },  // end of setMenuItem
 
        // 메뉴 카테고리 클릭 > 메뉴 출력
        click_category : function() {
            let category = event.target;                // 선택한 카테고리 
            let shop_id  = this.$route.params.shop_id;  // 가게 아이디
            let url = "";                               // 서버에 요청할 주소 

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
        },  
        
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
            let array = [];
 
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
            this.select_menus.push(arr);                        // 보낼 값 배열에 담기.  
            EventBus.$emit('select_menus', this.select_menus);
            this.snackbar_text = '선택하신 메뉴가 추가 되었습니다.';
            this.snackbar = true; 
        }
    }// end of method

}// end of export default
</script> 

<style scoped>
/* 모바일 */
@media (max-width: 639px){  
    .menu_body { width:100%;}
    .menu_info {font-size: 12px;}
}

/* 테블릿 */
@media (min-width: 640px) and (max-width: 1299px){  
    .menu_body { width:47%;}
    .menu_info {font-size: 13px;}  
}

/* 데스트 탑 */
@media (min-width: 1300px){   
    .menu_info {font-size: 15px;}  
}  

/* 메뉴 */
.menu_body {  
    float: left;
    color: black;
    border :1px solid;
    position: relative;
    overflow: hidden;
}  

.menu_info {
    padding-left: 3px;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%; 
    word-break:normal;
    font-weight: bold;
    overflow: auto; 
    overflow-x: hidden;
    position: absolute;
}  

.menu_info::-webkit-scrollbar {
    width: 0px;                     /* remove scrollbar space */
    background: transparent;        /* optional: just make scrollbar invisible */
}

.menu_img { 
    top: 0;
    left: 0;
    width: 105%;
    height: 105%; 
    position: absolute;
    object-fit: cover;
} 
.SelectBtn{
    width: 100%;
    height: 100%;
    position: relative;
    font-weight: bold;
}
</style>