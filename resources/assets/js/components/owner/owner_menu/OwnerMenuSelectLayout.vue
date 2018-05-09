<!-- 식당 사장이 메뉴판이 출력될 레이아웃을 선택하거나 직접 제작 할 수 있도록 한다. -->

<template>
    <div class="container" style="width:100%;">
        <v-container grid-list-md>
            <!-- 서비스에서 제공하는 메뉴판 기본 템플릿 중 하나 선택하기. -->
            <v-layout elevation-3>
                <v-flex xs10 style="font-size: 2rem;">
                    <v-card>
                        <v-card-text><b>메뉴판 템플릿 선택 - 선택한 템플릿 : {{selected_template}} </b></v-card-text>
                    </v-card> 
                </v-flex>
                <v-flex xs2 style="font-size: 2rem;">
                    <v-btn dark block style="height:90%;" @click="save_data"> 
                        저장하기
                    </v-btn>
                </v-flex>
            </v-layout>

            <v-layout text-xs-center mb-5>
                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿1 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿1 </v-card-text>

                        <div class="tem_img"> <img :src="exImg1"> </div>
                         
                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card align-content-center>
                                <v-card-text> 기본 템플릿1 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg1"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                         <v-dialog  v-model="tem1" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿1으로 적용하시겠습니까? </h3>
                                    <v-btn flat color="green darken-1" 
                                        @click.native="selected_template=1; tem1=false"> 예 </v-btn>
                                    <v-btn  color="green darken-1" flat  @click.native="tem1 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿2 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿2 </v-card-text> 
                        
                        <div class="tem_img"> <img :src="exImg2"> </div>

                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card>
                                <v-card-text> 기본 템플릿2 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg2"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                        <v-dialog v-model="tem2" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿2으로 적용하시겠습니까? </h3> 
                                    <v-btn  color="green darken-1" flat 
                                        @click.native="selected_template=2; tem2 = false"> 예 </v-btn>
                                    <v-btn  color="green darken-1" flat  @click.native="tem2 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿3 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿3 </v-card-text>

                        <div class="tem_img"> <img :src="exImg3"> </div>

                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card>
                                <v-card-text> 기본 템플릿3 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg3"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                        <v-dialog v-model="tem3" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿3으로 적용하시겠습니까? </h3>
                                    <v-btn  color="green darken-1" flat 
                                        @click.native="selected_template=3; tem3 = false"> 예 </v-btn>                                    
                                    <v-btn color="green darken-1" flat  @click.native="tem3 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>

                <!-- 서비스에서 제공하는 메뉴판 기본 템플릿4 -->
                <v-flex xs3 style="font-size: 1.2rem;" elevation-3>
                    <v-card>
                        <v-card-text> 기본 템플릿4 </v-card-text>

                        <div class="tem_img"> <img :src="exImg4"> </div>

                        <!-- 템플릿 예시 이미지 출력 : 모달 -->
                        <v-dialog max-width="50%">
                            <v-btn dark block slot="activator"> 예시 보기 </v-btn>
                            <v-card>
                                <v-card-text> 기본 템플릿4 예시 이미지 출력 </v-card-text>
                                <div class="tem_img"> <img :src="exImg4"> </div>
                            </v-card>
                        </v-dialog>

                        <!-- 템플릿 선택하기 : 모달 -->
                        <v-dialog v-model="tem4" max-width="20%">
                            <v-btn dark block slot="activator"> 템플릿 선택 </v-btn>
                            <v-card>
                                <v-card-text> 
                                    <h3> 기본 템플릿4으로 적용하시겠습니까? </h3> 
                                    <v-btn  color="green darken-1" flat 
                                        @click.native="selected_template=4; tem4 = false"> 예 </v-btn>
                                    <v-btn color="green darken-1" flat @click.native="tem4 = false"> 아니오 </v-btn>
                                </v-card-text>
                            </v-card>
                        </v-dialog>
                    </v-card>
                </v-flex>
            </v-layout>

            <!-- 메뉴판 템블릿 커스터마이징 -->
            <v-layout elevation-3>
                <v-flex xs12 style="font-size: 2rem;">
                    <v-card>
                         <v-card-text>
                            <b> 메뉴판 템플릿 제작 </b>
                        </v-card-text>
                    </v-card>
                </v-flex>
            </v-layout>

            <!-- 제작 툴로 이동. -->
            <v-layout elevation-3>
                <v-flex xs12>
                    <v-card>
                        <v-card-text style="font-size: 1rem;">                             
                            <v-btn dark @click.stop="createMode=true"> 
                                메뉴판 제작 
                            </v-btn>
                                제작 툴을 사용하여 자신만의 메뉴판을 직접 제작합니다.
                        </v-card-text> 
                    </v-card>   
                </v-flex>     
            </v-layout> 

            <!-- 제작 툴 -->
            <v-layout row justify-center>
                <v-dialog v-model="createMode" fullscreen hide-overlay style="z-index:0"
                    transition="dialog-bottom-transition">
                    <v-card>
                        <!-- 상단 툴바 -->
                        <v-toolbar color="grey lighten-5">
                            <!-- 사이드 툴바 호출 버튼 -->
                            <v-toolbar-side-icon @click.stop="sideToolBar = !sideToolBar" >                                 
                            </v-toolbar-side-icon>

                            <v-toolbar-title class="black--text"><b>메뉴판 제작</b></v-toolbar-title>

                            <!-- ctrl + z -->
                            <v-btn icon ml-5>
                                <v-icon> undo </v-icon>
                            </v-btn>

                            <!-- ctrl + y -->
                            <v-btn icon>
                                <v-icon> redo </v-icon>
                            </v-btn>

                            <v-spacer></v-spacer>

                            <!-- 출력 형식 -->
                            <v-btn dark @click="SetMenuPrt"> 메뉴 출력 설정 </v-btn>

                            <!-- 저장하기 나가기 버튼 -->
                            <v-btn class="white--text" color="red lighten-1" @click="createSave"> 저장하기 </v-btn>
                            <v-btn class="white--text" color="grey darken-1" @click="createMode=false"> 
                                나가기 
                            </v-btn>
                        </v-toolbar>

                        <!-- 메뉴 출력 설정창 -->
                        <div id="MenuPrt">       
                            <div style="width:100%; text-align:center;">                                
                                <b class="designSet_title"> 메뉴 출력 설정 </b>
                                <v-btn icon style="float:right" 
                                    onclick="document.getElementById('MenuPrt').classList.remove('active');">
                                        <v-icon large> clear </v-icon>
                                </v-btn>
                            </div>

                            <div class="designSet_tr"> 
                                <b class="designSet_name">1줄에 출력될 메뉴의 갯수</b> <br> 

                                <select id="MenuNum" class="designSet_ipt">
                                    <option value=1> 1 </option>
                                    <option value=2> 2 </option>
                                    <option value=3 selected> 3 </option>
                                    <option value=4> 4 </option>
                                    <option value=5> 5 </option> 
                                    <option value=6> 6 </option>
                                    <option value=7> 7 </option>                              
                                </select> 개
                            </div>          

                            <div class="designSet_tr" style="margin-bottom: 5%"> 
                                <b class="designSet_name">메뉴 간격</b> <br> 
                                <input type="text" id="MenuMargin" class="designSet_ipt" value="10"> px
                            </div>           
                        </div>

                        <!-- 사이드 툴바 -->
                        <v-navigation-drawer v-model="sideToolBar" temporary absolute style="z-index:100">   
                             <v-list class="pa-1">
                                <v-list-tile avatar>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">
                                            <b>메뉴판 요소 선택</b>
                                        </v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>
                            </v-list>

                            <v-list class="pt-0"> 
                                <v-divider></v-divider>
                                <!-- 메뉴 영역 div 생성 -->
                                <v-list-tile @click="createSomething" class='mt-4'
                                    @click.capture="item = 'createMenu'"
                                    @click.stop="sideToolBar = !sideToolBar">
                                    <v-list-tile-action>
                                        <v-icon>subtitles</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">메뉴 영역</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>

                                <!-- 메뉴 이미지 -->
                                <v-list-tile @click="createSomething" class='mt-3'
                                    @click.capture="item = 'createImg'"
                                    @click.stop="sideToolBar = !sideToolBar">
                                    <v-list-tile-action>
                                        <v-icon>image</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">메뉴 이미지</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>

                                <!-- 메뉴 명 생성 -->
                                <v-list-tile @click="createSomething" class='mt-3'
                                    @click.capture="item = 'createName'"
                                    @click.stop="sideToolBar = !sideToolBar">
                                    <v-list-tile-action>
                                        <v-icon>title</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">메뉴 명</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>

                                <!-- 메뉴 설명 생성 -->
                                <v-list-tile @click="createSomething" class='mt-3'
                                    @click.capture="item = 'createExpl'"
                                    @click.stop="sideToolBar = !sideToolBar">
                                    <v-list-tile-action>
                                        <v-icon>assignment</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">메뉴 설명</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>

                                <!-- 메뉴 가격 -->
                                <v-list-tile @click="createSomething" class='mt-3'
                                    @click.capture="item = 'createPrice'"
                                    @click.stop="sideToolBar = !sideToolBar">
                                    <v-list-tile-action>
                                        <v-icon>attach_money</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">메뉴 가격</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile>

                                <!-- 메뉴 선택 버튼 -->
                                <v-list-tile @click="createSomething" class='mt-3'
                                    @click.capture="item = 'createSelect'"
                                    @click.stop="sideToolBar = !sideToolBar">
                                    <v-list-tile-action>
                                        <v-icon>check_circle</v-icon>
                                    </v-list-tile-action>
                                    <v-list-tile-content>
                                        <v-list-tile-title class="list-style">메뉴 선택 버튼</v-list-tile-title>
                                    </v-list-tile-content>
                                </v-list-tile> 
                            </v-list>                                                                        
                        </v-navigation-drawer>

                        <!-- 마우스 오른쪽 버튼 클릭스 나타나는 메뉴 창 -->
                        <div id="click_menu" class="context-menus">
                            <ul>
                                <li id="goFont" @click="zIndexSet"><b>앞으로</b></li>  
                                <li id="goBack" @click="zIndexSet"><b>뒤로</b></li> <hr> 

                                <li @click="CallDesignSet"><b>영역 서식</b></li> <hr> 

                                <!-- <li @click="elementGrouping"><b>그룹화</b></li>   -->
                                <li @click="DeleteElement"><b>삭제하기</b></li>
                            </ul>
                        </div>

                        <!-- 영역 서식 메뉴창 -->
                        <div id="designSet">    
                            <div style="text-align: left;"> 
                                <b class="designSet_title"> 영역 서식 </b>
                                
                                <v-btn icon style="float:right" @click="CloseDesignSet">
                                    <v-icon large> clear </v-icon>
                                </v-btn>
                                <v-btn icon style="float:right" @click="SetColorAndShape">
                                    <v-icon large> done </v-icon>
                                </v-btn>
                            </div> 

                            <div class="designSet_tr">
                                <b class="designSet_name">선 굵기 설정</b> <br> 
                                <input type="text" id="line_width" class="designSet_ipt" value="2"> px
                            </div>

                            <div class="designSet_tr"> 
                                <b class="designSet_name">선 스타일 설정</b> <br> 

                                <select id="line_style" class="designSet_ipt">
                                    <option value="solid"> 직선 </option>
                                    <option value="none"> 없음 </option>
                                    <option value="dotted"> 짧은 점선 </option>
                                    <option value="dashed"> 긴 점선 </option>
                                    <option value="double"> 곂선 </option>                                
                                </select> (선택)
                            </div>

                            <div class="designSet_tr">
                                <b class="designSet_name">선 색상 선택</b> <br>

                                <div style="width:100%; overflow:hidden">
                                    <div class="designSet_color">
                                        <div id="line_color" class="designSet_color_inner"
                                            style="background-color:black;"></div>
                                    </div>
                                    <button class="designSet_color_btn" @click="CallColorPicker"
                                        @click.capture="appColor = 'line_color'">  
                                        <b>선택하기</b> 
                                    </button>
                                    <button class="designSet_color_btn" @click="ColorNull"
                                        @click.capture="appColor = 'line_color'">  
                                        <b>색 없음</b> 
                                    </button>
                                </div>                                
                            </div>

                             <div class="designSet_tr">
                                <b class="designSet_name">글자 색 선택</b> <br>

                                <div style="width:100%; overflow:hidden">
                                    <div class="designSet_color">
                                        <div id="text_color" class="designSet_color_inner"
                                            style="background-color:black;"></div>
                                    </div>
                                    <button class="designSet_color_btn" @click="CallColorPicker"
                                        @click.capture="appColor = 'text_color'">  
                                        <b>선택하기</b> 
                                    </button>                                    
                                </div>                                
                            </div>

                            <div class="designSet_tr">
                                <b class="designSet_name">영역 색상</b> <br>
                                <div style="width:100%; overflow:hidden">
                                    <div class="designSet_color">
                                        <div id="area_color" class="designSet_color_inner"></div>
                                    </div>
                                    <button class="designSet_color_btn" @click="CallColorPicker" 
                                        @click.capture="appColor = 'area_color'"> 
                                        <b>선택하기</b> 
                                    </button>
                                    <button class="designSet_color_btn" @click="ColorNull" 
                                        @click.capture="appColor = 'area_color'"> 
                                        <b>색 없음</b> 
                                    </button>
                                </div>
                            </div> 

                            <div class="designSet_tr">
                                <b class="designSet_name">영역 모양 설정</b> <br>
                                <select id="area_style" class="designSet_ipt">
                                    <option value="quadrangle"> 사각형 </option>
                                    <option value="quadrangle_R"> 둥근 사각형 </option>
                                    <option value="circle"> 원 </option>                  
                                </select> (선택)
                            </div>  
                        </div>

                        <!-- color picker -->
                        <div id="colorPicker">
                            <div>
                                <canvas id="palette" @click="Palette_Click"> </canvas>
                                <canvas id="bar"     @click="Bar_Click"> </canvas>
                            </div>
                            
                            <div style="width:100%;">
                                <div id="click_color"><b> 선택한 색상 </b></div>
                            </div>

                            <div style="width:100%;">
                                <button class="color_btn" @click="SetColor"><b>적용</b></button>
                                <button class="color_btn" @click="CloseColorPicker"><b>취소</b></button>
                            </div>
                        </div>

                        <!-- 작업 공간 @mousedown="dragSelect"-->
                        <div id="workSpace"></div>
                    </v-card>
                </v-dialog>
            </v-layout>
        </v-container>
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios'; 

// element move
var target_L   = 0;
var target_T   = 0;
var target_Obj = null;

// color picker 
var bar         = null;             // color bar
var bar_cntxt   = null;             // color bar context
var palet       = null;             // palette
var palet_cntxt = null;             // palette context  
 
export default {  

    created(){
        // this.dragSelect();
        // 메뉴 레이아웃 가져오기
        var url = '';
        var layoutNum = null;
        var shop_id = this.$route.params.shop_id;

        url = '/owner/' + shop_id + '/getLayout';

        // 템플릿 가져오기
        axios.get(url)
            .then( (response) => {
                layoutNum = response.data.layoutNum;
                this.selected_template = "기본 템플릿" + layoutNum;
            })
            .catch((ex)=>{
                alert('레이아웃 로드 실패');
            });
    },

    data () {
        return { 
            // 이미지 주소 주소 설정 좀여
            exImg1 : '/images/template/template1.jpeg',
            exImg2 : '/images/template/template2.png',
            exImg3 : '/images/template/template3.png',
            exImg4 : '/images/template/template4.png',

            // 모달 용 
            tem1: false,
            tem2: false,
            tem3: false,
            tem4: false,

            // 선택한 템플릿
            selected_template : "없음",

            // 메뉴판 커스텀마이징
            createMode  : false,                     // 모달 용
            sideToolBar : null,                      // 사이드 툴바 용 
            item        : null,                      // 사이드 툴바에서 선택한 리스트 값 저장
            Resizer     : null,                      // 엘리먼트 리사이즈 용 
            RCmenu      : 'item',
 
            // 선 색 || 영역 색상 구분용
            appColor : null,
        }
    }, 
    methods : { 
        // 템플릿 선택 - 저장하기
        save_data : function () { 
            let slt_tem = this.selected_template;       // 선택한 템플릿

            if ( slt_tem === '없음'){
                alert('메뉴판 템플릿을 선택해주세요');
            }
            else { 
                // 선택한 템플릿 설정 저장하기.
                let url = '선주야 부탁한다!';
            
                axios.post(url, slt_tem)
                .then( (response) => {
                    get_datas = response.data 
                })
                .catch((ex)=>{
                    alert('저장 실패');
                })
            }
        },

        // 메뉴 출력 형식 설정하기.
        SetMenuPrt : function() { 
            let MenuPrt = document.getElementById('MenuPrt');
            MenuPrt.classList.add('active');
        },
 
        // 메뉴판 제작 - 작업 내용 저장하기.
        createSave : function() {
            let MenuNum    = document.getElementById('MenuNum');
            let MenuMargin = document.getElementById('MenuMargin');
            let workSpace  = document.getElementById('workSpace');                     // 작업 공간 div 가져오기
            let formData   = new FormData();                                           // 엘리먼트들을 담음
            
            for(let i = 0; i < workSpace.children.length; i++){
                let className = workSpace.children[i].getAttribute('class').split(' ')[0];  // 클래스 명 찾기
                let item_w    = workSpace.children[i].style.width.replace('px', '');        // 엘리먼트의 width
                let item_h    = workSpace.children[i].style.height.replace('px', '');       // 엘리먼트의 height
                let browser_w = window.outerWidth;                                          // 브라우저의 width
                let browser_h = window.outerHeight;                                         // 브라우저의 height
                
                // 퍼센트로 바꾸기
                let set_width  = Math.ceil( item_w / browser_w * 100 ) + "%";          
                let set_height = Math.ceil( item_h / browser_h * 100 ) + "%";

                workSpace.children[i].style.width  = set_width;
                workSpace.children[i].style.height = set_height;

                formData.append(className, workSpace.children[i]);    
            } 

            // 메뉴 출력 설정 사항 저장하기.
            formData.append('MenuNum', MenuNum.value);                      // 한 줄에 출력 될 메뉴의 갯수 
            formData.append('MenuMargin', MenuMargin.value + 'px');         // 메뉴 간의 간격 설정

            // formData 확인
            for(var pair of formData.entries()) {
                console.log(pair[0]+ ': '+ pair[1]); 
            }
 
            // 저장하기.
            // axios.post('선주야 부탁해', formData )
            // .then( (response) => {
            //     
            // })
            // .catch((ex)=>{
            //     alert('저장 실패');
            // });
        },  

        // 드래그로 엘리먼트 다중 선택하기. 
        dragSelect : function(){
            let workSpace = document.getElementById('workSpace');
            let Selecter  = document.createElement('div'); 

            Selecter.classList.add('selecter'); 
            Selecter.style.top  = (event.y -50) + "px";
            Selecter.style.left = (event.x -50) + "px";

            workSpace.appendChild(Selecter);  

            workSpace.addEventListener('mousemove', function(){ 
                event.preventDefault(); 
                Selecter.style.width  = (event.clientX - Selecter.offsetLeft) + 'px';
                Selecter.style.height = (event.clientY - Selecter.offsetTop)  + 'px';
                
            }, false);

            workSpace.addEventListener('mouseup', function(){    
                event.preventDefault();                
                Selecter.parentNode.removeChild(Selecter);
            }, false);
        },
  
        // 엘리먼트 움직이기 : 위치 값 얻기 - left
        getLeft : function(argObj){  
            return parseInt(argObj.style.left.replace('px', ''));;
        },
        // 엘리먼트 움직이기 : 위치 값 얻기 - top
        getTop : function(argObj) {
            return parseInt(argObj.style.top.replace('px', ''));
        },
        // 엘리먼트 움직이기 : mouseDown
        startDrag : function() { 
            let e_obj  = window.event ? window.event : event;               // 마우스 이벤트
            target_Obj = event.target;

            target_L = this.getLeft(target_Obj) - e_obj.clientX; 
            target_T = this.getTop(target_Obj)  - e_obj.clientY;
            
            document.onmousemove = this.moveStart;
            document.onmouseup   = this.moveStop;
        },
        // 엘리먼트 움직이기 : mouseMove  
        moveStart : function(){
            event.preventDefault();
            let e_obj  = window.event ? window.event : event; 
            let move_x = parseInt(e_obj.clientX + target_L);
            let move_y = parseInt(e_obj.clientY + target_T); 

            // 드래그 하는 element 이동 시키기
            target_Obj.style.left = move_x +"px";
            target_Obj.style.top = move_y +"px";
            return false;
        },
        // 엘리먼트 움직이기 : mouseUp
        moveStop : function(){
            document.onmousemove = null;
            document.onmouseup   = null;
        },

        // 엘리먼트 크기 조절 - mouseDown
        initResize : function() {
            this.Resizer = event.target.parentNode;    
            document.addEventListener('mousemove', this.Resize, false);
            document.addEventListener('mouseup', this.stopResize, false);
        },
        // 엘리먼트 크기 조절 - mouseMove
        Resize : function() {             
            event.preventDefault();
            this.Resizer.style.width  = (event.clientX - this.Resizer.offsetLeft) + 'px';
            this.Resizer.style.height = (event.clientY - this.Resizer.offsetTop ) + 'px';
        },
        // 엘리먼트 크기 조절 - mouseUp
        stopResize: function() {
            document.removeEventListener('mousemove', this.Resize, false);
            document.removeEventListener('mouseup', this.stopResize, false);
        },

        // 사이드 메뉴 : 영역(엘리먼트) 생성
        createSomething : function() { 
            let resizer      = document.createElement('div');               // element 크기 조절기
            let createdThing = document.createElement('div');               // 생성할 element
            let workSpace    = document.getElementById('workSpace');        // 작업 공간 div 가져오기
            let click_menu   = document.getElementById("click_menu");       // 마우스 우 클릭 시 나타나는 메뉴

            switch(this.item){
                // 메뉴 영역 만들기
                case 'createMenu' :          
                    createdThing.innerText    = '메뉴 영역'; 
                    createdThing.style.width  = '300px'; 
                    createdThing.style.height = '200px';
                    createdThing.classList.add('createdMenu'); break;                    

                // 메뉴 이미지 만들기
                case 'createImg' :                      
                    createdThing.style.width  = '200px'; 
                    createdThing.style.height = '200px';
                    createdThing.classList.add('createdImg'); break;
 
                // 메뉴 이름 만들기
                case 'createName' :             
                    createdThing.innerText    = '메뉴명'; 
                    createdThing.style.width  = '200px'; 
                    createdThing.style.height = '50px';  
                    createdThing.classList.add('createdName'); break;                   

                // 메뉴 설명 만들기
                case 'createExpl' :  
                    createdThing.innerText    = '메뉴 설명'; 
                    createdThing.style.width  = '200px'; 
                    createdThing.style.height = '80px';
                    createdThing.classList.add('createdExpl'); break;                    

                // 메뉴 가격
                case 'createPrice' :   
                    createdThing.innerText = '메뉴 가격'; 
                    createdThing.style.width  = '100px'; 
                    createdThing.style.height = '50px';
                    createdThing.classList.add('createdPrice'); break;                    

                // 메뉴 선택 
                case 'createSelect' :  
                    createdThing.innerText = '메뉴 선택'; 
                    createdThing.style.width  = '100px'; 
                    createdThing.style.height = '50px';
                    createdThing.classList.add('createdSelect'); break;                           
            }

            // 마우스 오른쪽 클릭 시 메뉴 창 열기.
            createdThing.addEventListener("contextmenu", function() {
                event.preventDefault();
                target_Obj  = createdThing;
                this.RCmenu = 'item'; 

                // if(target_Obj.style.border !== '2px solid red'){
                //     target_Obj.style.border = '2px solid blue';
                // }
                click_menu.classList.add("active");
                click_menu.style.top  = event.y +"px";
                click_menu.style.left = event.x +"px";             
            });  
            
            // 마우스 왼쪽 클릭 시 메뉴 창 닫기.
            workSpace.addEventListener("click", function() {
                // if(target_Obj.classList[0] !== 'groupDiv' && target_Obj.style.border == '2px solid blue'){
                //     target_Obj.style.border = '2px solid black';
                // }
                // else if(target_Obj.classList[0] === 'groupDiv'){ 
                //     target_Obj.style.border = '1px solid lightgreen';
                // }
                click_menu.classList.remove("active");
            });
            
            // 생성된 element                         
            createdThing.style.top    = '100px';
            createdThing.style.left   = '100px';
            createdThing.style.zIndex = 10; 
            createdThing.onmousedown  = this.startDrag;       
            createdThing.classList.add('dragElement');

            // double click method
            // createdThing.addEventListener('dblclick', this.dblclickMethod);

            // element 크기 조절기
            resizer.onmousedown = this.initResize;
            resizer.classList.add('resizer');
            
            // 포함 시키기 ( 크기 조절기 -> 생성된 element -> 작업 공간 )
            createdThing.appendChild(resizer);
            workSpace.appendChild(createdThing);  

        }, // end of createSomething

        // 엘리먼트 더블 클릭 시 테두리 색을 빨간색으로 바꿈.
        dblclickMethod : function() {
            event.preventDefault();

            if(event.target.style.border !== '2px solid red')
                event.target.style.border = '2px solid red';             
            else if(event.target.style.border === '2px solid red')
                event.target.style.border = '2px solid black';             
        },
  
        // 우클릭 메뉴창 : 선택한 엘리먼트 앞으로 보내기 또는 뒤로 보내기
        zIndexSet : function() {  
            let click_menu = document.getElementById("click_menu");     
            
            // 클릭한 리스트에 맞춰서 z-index 값 변경하기
            if(event.target.id === 'goFont')
                target_Obj.style.zIndex++;                      
            else if (event.target.id === 'goBack')
                target_Obj.style.zIndex--;                     

            // 테두리 색 되돌리기.
            if(target_Obj.classList[0] !== 'groupDiv')            
                target_Obj.style.border = '2px solid black';  
            else if(target_Obj.classList[0] === 'groupDiv') 
                target_Obj.style.border = '1px solid lightgreen';            

            // 우클릭 메뉴창 닫기
            click_menu.classList.remove("active");                         
        },

        // 우클릭 메뉴창 : 영역 서식 창 열기
        CallDesignSet : function(){            
            let click_menu = document.getElementById("click_menu");         // 우 클릭 메뉴창 
            let designSet  = document.getElementById('designSet');          // 영역 서식 메뉴창            
            
            designSet.classList.add('active');                              // 영역 서식 메뉴창 열기.   
            click_menu.classList.remove("active");                          // 우클릭 메뉴창 닫기
        },
        // 우클릭 메뉴창 : 영역 서식 설정 사항 적용하기.
        SetColorAndShape : function() {
            let designSet = document.getElementById('designSet');                           // 영역 서식 메뉴창
            let lineWidth = document.getElementById('line_width').value;                    // 선 굵기
            let lineStyle = document.getElementById('line_style').value;                    // 선 스타일
            let lineColor = document.getElementById('line_color').style.backgroundColor;    // 선 색
            let textColor = document.getElementById('text_color').style.backgroundColor;    // 글자 색
            let areaColor = document.getElementById('area_color').style.backgroundColor;    // 영역 색
            let areaStyle = document.getElementById('area_style').value;                    // 영역 스타일

            // 선 스타일 설정(굵기, 색, 형식)
            if(lineStyle !== 'none' && lineColor !== '') {
                target_Obj.style.border = lineWidth + 'px ' + lineStyle + ' '  + lineColor;
            } 
            else if(lineStyle === 'none' || lineColor === ''){
                target_Obj.style.border = 0;
            }

            // 글자 색 설정.
            target_Obj.style.color = textColor;

            // 영역 색상 설정.
            target_Obj.style.backgroundColor = areaColor;
            
            // 영역 모양 설정
            switch(areaStyle){
                case 'quadrangle'   : target_Obj.style.borderRadius = '0';      break;
                case 'quadrangle_R' : target_Obj.style.borderRadius = '20px';   break;
                case 'circle'       : target_Obj.style.borderRadius = '100%';   break; 
            }
            designSet.classList.remove('active');
        },
        // 우클릭 메뉴창 : 영역 서식 창 닫기.
        CloseDesignSet : function(){ 
            let designSet  = document.getElementById('designSet');          // 영역 서식 메뉴창

            // 테두리 색 되돌리기.
            // if(target_Obj.classList[0] !== 'groupDiv')            
            //     target_Obj.style.border = '2px solid black';  
            // else if(target_Obj.classList[0] === 'groupDiv') 
            //     target_Obj.style.border = '1px solid lightgreen';
            
            // 영역 서식 메뉴창 닫기. 
            designSet.classList.remove('active');
        },

        // 우클릭 메뉴창 : 색 없음
        ColorNull : function() {
            let appColor = document.getElementById(this.appColor);
            appColor.style.backgroundColor = '';
        },
        // 우클릭 메뉴창 : color picker 열기(색상 선택)
        CallColorPicker : function() {
            let colorPicker = document.getElementById('colorPicker');
            colorPicker.classList.add('active');
            this.ColorPicker_init();
        },
        // color picker 초기화
        ColorPicker_init : function() {
            let click_color = document.getElementById('click_color');
            click_color.style.backgroundColor = '';
            this.Bar_init();
            this.Palette_init();
            this.DrawingPalette(255, 0, 0);
        },
        // 색상 바 초기화
        Bar_init : function() {  
            bar          = document.getElementById('bar');
            bar_cntxt    = bar.getContext('2d');  
            let width    = bar.width = 20;
            let height   = bar.height = 256;
            let gradient = bar_cntxt.createLinearGradient(0, 0, width, height);

            gradient.addColorStop(0, '#ff0000');
            gradient.addColorStop(0.166, '#ff00ff');
            gradient.addColorStop(0.333, '#0000ff');
            gradient.addColorStop(0.5, '#00ffff');
            gradient.addColorStop(0.666, '#00ff00');
            gradient.addColorStop(0.834, '#ffff00');
            gradient.addColorStop(1, '#ff0000');

            bar_cntxt.fillStyle = gradient;
            bar_cntxt.fillRect(0, 0, width, height);
        },
        // 색상바 클릭
        Bar_Click : function() {  
            let y     = event.clientY - bar.offsetParent.offsetTop;     // y 좌표를 가져온다.
            let color = bar_cntxt.getImageData(0, y, 1, 1).data;        // 해당 위치의 색상을 가져온다.
            this.DrawingPalette(color[0], color[1], color[2]);          // 팔레트 그리기.     
        },
        // 팔레트 초기화.
        Palette_init : function() { 
            palet        = document.getElementById('palette');
            palet_cntxt  = palet.getContext('2d');
            palet.width  = 256;
            palet.height = 256;
        },
        // 팔레트 그리기.
        DrawingPalette : function(r, g, b) { 
            // 위에서부터 1픽셀씩 내려오면서 그림
            for (let i = 0; i < 255; i++)
            {
                let leftColor = 255 - i; // 왼쪽 [상 -> 하] 명도 계산
                let gradient = palet_cntxt.createLinearGradient(0, 0, 256, 1); // 그리기
                gradient.addColorStop(0,'rgb(' + leftColor + ', ' + leftColor + ', ' + leftColor + ')');
                gradient.addColorStop(1,'rgb(' + r + ', ' + g + ', ' + b + ')');
                palet_cntxt.fillStyle = gradient;
                palet_cntxt.fillRect(0, i++, 256, i);

                // 루프당 명도를 1씩 떨어뜨림.
                if (r > 0) { r--; }
                if (g > 0) { g--; }
                if (b > 0) { b--; }
            }
        },
        // 팔레트 클릭
        Palette_Click : function(){
            let x           = event.clientX - palet.offsetParent.offsetLeft;    // x 좌표를 가져온다.
            let y           = event.clientY - palet.offsetParent.offsetTop;     // y 좌표를 가져온다.
            let color       = palet_cntxt.getImageData(x, y, 1, 1).data;        // 해당 위치의 색상을 가져온다.
            let click_color = document.getElementById('click_color');
 
            click_color.style.backgroundColor 
                    = 'rgba(' + color[0] + ', ' + color[1] + ', ' + color[2] + ', ' + color[3] +')';
        },
        // 우클릭 메뉴창 : color picker - color 적용
        SetColor : function() {
            let click_color = document.getElementById('click_color');
            let appColor = document.getElementById(this.appColor);
            
            appColor.style.backgroundColor = click_color.style.backgroundColor;
            this.CloseColorPicker();             
        },
        // 우클릭 메뉴창 : color picker 닫기
        CloseColorPicker : function() {
            let colorPicker = document.getElementById('colorPicker');
            colorPicker.classList.remove('active');
        },

        // 우클릭 메뉴창 : 선택한 엘리먼트들 그룹핑하기
        elementGrouping : function() { 
            let workSpace = document.getElementById('workSpace');       
            let groupDiv  = document.createElement('div');              // 클릭한 element들을 담을 div 
            let resizer   = document.createElement('div');              // element 크기 조절기
            let box       = [];                                         // 더블 클릭한 element를 담을 배열
           
            // 더블 클릭한 element를 box에 push
            for(let i=0; i < workSpace.children.length; i++){    
                if(workSpace.children[i].style.border === '2px solid red'){                
                    workSpace.children[i].style.border = '2px solid black'; 
                    box.push(workSpace.children[i]);
                }
            }

            // 더블 클릭한 대상을 그룹화
            for(let i=0; i<box.length; i++){
                groupDiv.appendChild(box[i]);
            }

            // 마우스 드래그 이벤트 설정.
            groupDiv.onmousedown = this.startDrag; 

            // 마우스 오른쪽 클릭 시 메뉴 창 열기.
            groupDiv.addEventListener("contextmenu", function() {
                event.preventDefault();
                target_Obj = event.target; 

                if(target_Obj.style.border !== '2px solid red') {
                    target_Obj.style.border = '2px solid blue';
                }
                click_menu.classList.add("active");
                click_menu.style.top  = event.y +"px";
                click_menu.style.left = event.x +"px";             
            });   
             
            // 그룹 스타일 지정
            groupDiv.style.top    = groupDiv.children[0].style.top;
            groupDiv.style.left   = groupDiv.children[0].style.left;             
            groupDiv.style.zIndex = 10;
            groupDiv.classList.add('groupDiv');
            groupDiv.classList.add('dragElement'); 

            // element 크기 조절기
            resizer.onmousedown = this.initResize;
            resizer.classList.add('resizer');
            
            // 포함 시키기  
            groupDiv.appendChild(resizer);
            workSpace.appendChild(groupDiv);

            // 우 클릭 메뉴판 닫기.
            click_menu.classList.remove("active");
        },

        // 우클릭 메뉴창 : 선택한 엘리먼트 삭제하기.
        DeleteElement : function() { 
            let click_menu = document.getElementById("click_menu");
            
            target_Obj.parentNode.removeChild(target_Obj);
            click_menu.classList.remove("active");
        },

    }, // end of method
}

</script>

<style>
/* 이미지 비율용 스타일 */
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

/* 메뉴 제작 작업 공간 */
#workSpace {
    width: 100%; 
    height: 90%; 
    position:absolute; 
    overflow:hidden;
}

/* 메뉴 출력 설정 */
#MenuPrt {
    width: 30%;  
    z-index:100;
    margin-top: 5%;
    border: 3px solid #585858; 
    background-color: #EFF5FB; 
    position: absolute;
    display: none;  
}
#MenuPrt.active { 
    display: block;  
    left : 35%;
}

/* 리스트 스타일 */
.list-style{
    font-size: 1.5rem;
}

/* 메뉴 영역 */
.createdMenu { 
    border: 2px solid black; 
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
}
/* 메뉴 이미지 영역 */
.createdImg { 
    border: 2px solid black; 
   /* background-image: url('./image.jpg');*/
    background-size: 100% 100%;
}
/* 메뉴 이름 영역 */
.createdName { 
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
} 
/* 메뉴 설명 영역 */
.createdExpl { 
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
}
/* 메뉴 가격 영역 */
.createdPrice { 
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
}
/* 메뉴 선택 영역 */
.createdSelect { 
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center; 
}

/* 엘리먼트 움직이기 용 */
.dragElement { 
    position: absolute;
    cursor: pointer;  
}
/* div 크기 조절기 */
.resizer {
    width: 10px;
    height: 10px; 
    right: 0;
    bottom: 0;
    z-index: 90;
    position: absolute;
    cursor: se-resize;
    background-color:salmon;
}

/* 마우스 메뉴 */
ul {
    margin: 0px;
    padding: 0px;
    font-size: 1.2rem;
}
hr {
    margin: 3%;
    border: thin solid #D8D8D8;
} 
.context-menus {
    width: 20%;
    border: 1px solid black;
    z-index:100;
    position: absolute;
    display: none;
    text-align: center;
}
.context-menus.active {
    display: block;
    background-color: #EFF5FB;
}
.context-menus.active>ul>li {
    list-style: none;
    padding: 10px;
    color: #424242;
}
.context-menus.active>ul>li:hover {
    background-color: lightgreen;
}

/* 영역 서식 메뉴창 */
#designSet {
    width: 40%; 
    max-height: 80%;
    z-index:100;
    border: 3px dashed #585858; 
    padding-bottom: 3%;
    background-color: whitesmoke; 
    position: absolute;
    display: none;  
}
#designSet.active {
    top : 15%;
    left: 30%;
    display: block;
    overflow: scroll;
}
.designSet_title {
    font-size: 2rem;
    margin-left: 3%;
    color: cadetblue;
}
.designSet_tr {
    width: 90%;
    font-size: 1.3rem;
    margin: auto;
    margin-top: 6%;  
}
.designSet_name {color: #6E6E6E;}
.designSet_ipt{
    width: 50%;
    font-size: 1.3rem;
    margin-left: 5%;
    text-align: center;
    color: #6E6E6E; 
    border-bottom: 1.5px solid #6E6E6E;
}
.designSet_color {
    width: 10%; 
    height: 0;
    border: 1px solid black;
    margin-left: 5%;
    margin-right: 3%; 
    position: relative; 
    float: left;
    overflow: hidden;
    padding-bottom: 9%;
} 
.designSet_color_inner{
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: absolute;
}
.designSet_color_btn {
    font-size: 1.5rem;
    margin-left: 5%;
    float: left;
    color: cadetblue;
} 

/* color-picker */
#colorPicker{
    width: auto; 
    z-index:100;
    border: 3px solid #585858; 
    background-color: whitesmoke; 
    position: absolute;
    display: none;
}
#colorPicker.active {
    top : 15%;
    left: 40%;
    display:inline-block; 
    overflow: hidden; 
}
#palette { width:256px; height:256px; }
#bar { width:20px; height:256px; }
#click_color {
    width: 100%; 
    height: 40px;
    font-size: 1.5rem;
    border-bottom: 3px solid #585858;  
    color: #6E6E6E; 
    text-align: center;
}
.color_btn {
    width: 50%;
    font-size: 1.5rem;
    text-align: center;
    float: left;
    color: #6E6E6E;  
}

/* 그룹화 div */
.groupDiv {
    width: auto;
    height: auto;
    min-width: 10px;
    min-height: 10px;
    overflow: hidden; 
    border: 1px solid lightgreen;  
}

/* 드래그로 div 선택 */
.selecter {
    width: 100px;
    height: 100px;
    opacity: 0.2;
    z-index: 100;
    background-color: aqua;
    position: absolute;

}

</style>