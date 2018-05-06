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

            <v-layout elevation-3>
                <v-flex xs12>
                    <v-card>
                        <v-card-text style="font-size: 1rem;"> 
                            <!-- 제작 툴로 이동. -->
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

                            <!-- 저장하기 나가기 버튼 -->
                            <v-btn class="white--text" color="red lighten-1" @click="createSave"> 저장하기 </v-btn>
                            <v-btn class="white--text" color="grey darken-1" @click="createMode=false"> 
                                나가기 
                            </v-btn>
                        </v-toolbar>

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
                                <li id="goFont" @click="zIndexSet"> 앞으로 </li>
                                <li id="goBack" @click="zIndexSet"> 뒤로 </li>
                                <li > 색상 조절 </li>
                                <li @click="elementGrouping"> 그룹화 </li> 
                                <li @click="DeleteElement"> 삭제하기 </li>
                            </ul>
                        </div>

                        <!-- 작업 공간 -->
                        <div id="workSpace"  @mousedown="dragSelect"></div>

                    </v-card>
                </v-dialog>
            </v-layout>
        </v-container>
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios'; 

var target_L    = 0;
var target_T    = 0;
var target_Obj  = null;
 
export default {  

    created(){
        // this.dragSelect();     
    },

    data () {
        return { 
            // 이미지 주소 주소 설정 좀여
            exImg1 : '선주야 부탁한다!',  
            exImg2 : '선주야 부탁한다!',
            exImg3 : '선주야 부탁한다!',
            exImg4 : '선주야 부탁한다!',

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
        }
    }, 
    methods : { 
        // 템플릿 선택 - 저장하기
        save_data : function () { 
            let slt_tem = this.selected_template; // 선택한 템플릿

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

        // v-for 용 함수, start에서 시작해서 end까지 1식 반환
        range : function (start, end) {
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        }, 

        // 메뉴판 제작 - 작업 내용 저장하기.
        createSave : function() {
            let workSpace   = document.getElementById('workSpace');        // 작업 공간 div 가져오기
            let createdItem = [];

            console.log(workSpace);

            // for(let i = 0; i < workSpace.children.length; i++){

            // }
        },  

        // dragSelecter
        dragSelect : function(){
            let Selecter = document.createElement('div');
            Selecter.classList.add('selecter');
            
            
        },
  
        // div move : 위치 값 얻기 - left
        getLeft : function(argObj){  
            return parseInt(argObj.style.left.replace('px', ''));;
        },
        // div move : 위치 값 얻기 - top
        getTop : function(argObj) {
            return parseInt(argObj.style.top.replace('px', ''));
        },
        // div move : mouseDown
        startDrag : function() { 
            let e_obj  = window.event ? window.event : event;               // 마우스 이벤트
            target_Obj = event.target;

            target_L = this.getLeft(target_Obj) - e_obj.clientX; 
            target_T = this.getTop(target_Obj)  - e_obj.clientY;
            
            document.onmousemove = this.moveStart;
            document.onmouseup   = this.moveStop;
        },
        // div move : mouseMove  
        moveStart : function(){
            event.preventDefault();
            let e_obj  = window.event ? window.event : event; 
            let move_x = parseInt(e_obj.clientX + target_L);
            let move_y = parseInt(e_obj.clientY + target_T); 

            // 드래그 하는 element 이동 시키기
            target_Obj.style.left = move_x +"px";
            target_Obj.style.top  = move_y +"px";
            return false;
        },
        // div move : mouseUp
        moveStop : function(){
            document.onmousemove = null;
            document.onmouseup   = null;
        },

        // div Resizing - mouseDown
        initResize : function() {
            this.Resizer = event.target.parentNode;    
            document.addEventListener('mousemove', this.Resize, false);
            document.addEventListener('mouseup', this.stopResize, false);
        },
        // div Resizing - mouseMove
        Resize : function() {             
            event.preventDefault();
            this.Resizer.style.width  = (event.clientX - this.Resizer.offsetLeft) + 'px';
            this.Resizer.style.height = (event.clientY - this.Resizer.offsetTop) + 'px';
        },
        // div Resizing - mouseUp
        stopResize: function() {
            document.removeEventListener('mousemove', this.Resize, false);
            document.removeEventListener('mouseup', this.stopResize, false);
        },

        // 사이드 메뉴 : 영역 만들기
        createSomething : function() { 
            let resizer      = document.createElement('div');               // element 크기 조절기
            let createdThing = document.createElement('div');               // 생성할 element
            let workSpace    = document.getElementById('workSpace');        // 작업 공간 div 가져오기
            let click_menu   = document.getElementById("click_menu");       // 마우스 우 클릭 시 나타나는 메뉴

            switch(this.item){
                // 메뉴 영역 만들기
                case 'createMenu' :          
                    createdThing.innerText = '메뉴 영역'; 
                    createdThing.classList.add('createdMenu'); break;                    

                // 메뉴 이미지 만들기
                case 'createImg' :                     
                    createdThing.classList.add('createdImg'); break;
 
                // 메뉴 이름 만들기
                case 'createName' :             
                    createdThing.innerText = '메뉴명';  
                    createdThing.classList.add('createdName'); break;                   

                // 메뉴 설명 만들기
                case 'createExpl' :  
                    createdThing.innerText = '메뉴 설명';
                    createdThing.classList.add('createdExpl'); break;                    

                // 메뉴 가격
                case 'createPrice' :   
                    createdThing.innerText = '메뉴 가격';
                    createdThing.classList.add('createdPrice'); break;                    

                // 메뉴 선택 
                case 'createSelect' :  
                    createdThing.innerText = '메뉴 선택';
                    createdThing.classList.add('createdSelect'); break;                           
            }

            // 마우스 오른쪽 클릭 시 메뉴 창 열기.
            createdThing.addEventListener("contextmenu", function() {
                event.preventDefault();
                target_Obj  = createdThing;
                this.RCmenu = 'item'; 

                if(target_Obj.style.border !== '2px solid red'){
                    target_Obj.style.border = '2px solid blue';
                }
                click_menu.classList.add("active");
                click_menu.style.top  = event.y +"px";
                click_menu.style.left = event.x +"px";             
            });  
            
            // 마우스 왼쪽 클릭 시 메뉴 창 닫기.
            workSpace.addEventListener("click", function() {
                if(target_Obj.classList[0] !== 'groupDiv'){
                    target_Obj.style.border = '2px solid black';
                }
                else if(target_Obj.classList[0] === 'groupDiv'){ 
                    target_Obj.style.border = '1px solid lightgreen';
                }
                click_menu.classList.remove("active");
            });
            
            // 생성된 element                         
            createdThing.style.top    = '100px';
            createdThing.style.left   = '100px';
            createdThing.style.zIndex = 10; 
            createdThing.onmousedown  = this.startDrag;       
            createdThing.classList.add('dragElement');

            // double click method
            createdThing.addEventListener('dblclick', this.dblclickMethod);

            // element 크기 조절기
            resizer.onmousedown = this.initResize;
            resizer.classList.add('resizer');
            
            // 포함 시키기 ( 크기 조절기 -> 생성된 element -> 작업 공간 )
            createdThing.appendChild(resizer);
            workSpace.appendChild(createdThing);  

        }, // end of createSomething

        // element 더블 클릭 시 테두리 색을 빨간색으로 바꿈.
        dblclickMethod : function() {
            event.preventDefault();

            if(event.target.style.border !== '2px solid red')
                event.target.style.border = '2px solid red';             
            else if(event.target.style.border === '2px solid red')
                event.target.style.border = '2px solid black';             
        },
 
        // 우클릭 메뉴창 : element 앞으로 보내기 & 뒤로 보내기
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

        // 우클릭 메뉴창 : element 삭제하기.
        DeleteElement : function() { 
            let click_menu = document.getElementById("click_menu");
            
            target_Obj.parentNode.removeChild(target_Obj);
            click_menu.classList.remove("active");
        },

        // 우클릭 메뉴창 : 선택한 요소 그룹핑
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
                box[i].style.top  = '10%';
                box[i].style.left = '10%';
                groupDiv.appendChild(box[i]);
            }

            // 마우스 드래그 이벤트 설정.
            groupDiv.onmousedown = this.startDrag; 

            // 마우스 오른쪽 클릭 시 메뉴 창 열기.
            groupDiv.addEventListener("contextmenu", function() {
                event.preventDefault();
                target_Obj = event.target; 

                if(target_Obj.style.border !== '2px solid red'){
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

/* 리스트 스타일 */
.list-style{
    font-size: 1.5rem;
}

/* 메뉴 영역 */
.createdMenu {
    /* width: 20%;
    height: 50%;  */
    width: 200px;
    height: 400px;
    border: 2px solid black; 
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
}
/* 메뉴 이미지 영역 */
.createdImg {
    /* width: 20%;
    height: 40%;   */
    width: 200px;
    height: 200px;
    border: 2px solid black; 
    /* background-image: url('./image.jpg'); */
    background-size: 100% 100%;
}
/* 메뉴 이름 영역 */
.createdName {
    /* width: 20%;
    height: 5%;  */
    width: 200px;
    height: 50px;
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
} 
/* 메뉴 설명 영역 */
.createdExpl {
    /* width: 20%;
    height: 10%;  */
    width: 200px;
    height: 100px;
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
}
/* 메뉴 가격 영역 */
.createdPrice {
    /* width: 10%;
    height: 5%;  */
    width: 100px;
    height: 50px;
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    background-color:white;
}
/* 메뉴 선택 영역 */
.createdSelect {
    /* width: 10%;
    height: 5%;  */
    width: 100px;
    height: 50px;
    border: 2px solid black;
    font-size: 1.5rem;
    text-align: center;
    color: white;
    background-color:grey;
}

/* 드래그 용 */
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
}
.context-menus {
    z-index:100;
    position: absolute;
    display: none;
    border: 1px solid black;
    width: 15%;
    text-align: center;
}
.context-menus.active {
    display: block;
    background-color: white;
}
.context-menus.active>ul>li {
    list-style: none;
    padding: 10px;
}
.context-menus.active>ul>li:hover {
    background-color: lightgreen;
}

/* 그룹화 div */
.groupDiv {
    width: 100%;
    height: 100%;
    
    overflow: hidden;   
    border: 1px solid lightgreen;  
}

.selecter {
    width: 1px;
    height: 1px;
    background-color: aqua;

}

</style>
