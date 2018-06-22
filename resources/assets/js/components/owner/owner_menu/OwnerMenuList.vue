<template>
<div class="container" style="width:100%;">
<v-app>
<!-- 스낵바 : 경고 창 출력 -->
<v-snackbar :timeout="timeout" :top="'top'" v-model="snackbar">
    {{ snackbar_text }}
    <v-btn flat color="pink" icon @click.native="snackbar = false">
        <v-icon large> close </v-icon>
    </v-btn>
</v-snackbar>    

<div id="menus">
    <!-- 카테고리 영역 -->
    <div style="width:100%"> 
        <div style="max-width:100%; margin:auto">
            <v-bottom-nav :value="true" :active.sync="e2">
                <v-btn 
                    style="color:black; font-weight:bold"
                    v-for="(value,key) in categorys" 
                    :key="key" 
                    :value="value" 
                    @click="click_category">
                    {{value}}
                </v-btn>
            </v-bottom-nav>
        </div>
    </div> 

    <!-- 메뉴들 class="Inner" style="overflow:auto;"-->
    <v-layout id="prtArea">
        <v-flex xs12> 
            <!-- 메뉴 영역 --> 
            <v-card v-for="n in range(0, menu_num-1)" :key="n" class="menuBody" :id="n+1">                
                <!-- 메뉴 이미지 -->
                <div class="menuOuter">
                    <!-- <img src="./ny2.png" class="menuImg"> -->
                    <img class="menuImg" :src="get_menus[n].path + get_menus[n].filename">
                </div>

                <!-- 메뉴 정보 -->
                <div class="menuOuter">  
                    <div class="Inner">
                        <!-- 메뉴 명 -->
                        <div class="menuContent">
                            <b style="color: cadetblue;"> 메뉴 명 </b>  
                            <h3 class="h3_style"> {{get_menus[n].name}}</h3>
                        </div>              

                        <!-- 메뉴 점심 메뉴 / 저녁 메뉴 구분 -->
                        <div class="menuContent">
                            <b style="color: cadetblue;"> 런치 / 디너 </b>
                            <h3 class="h3_style"> {{get_menus[n].remark}} </h3>
                        </div> 
                                        
                        <!-- 메뉴 가격 -->
                        <div class="menuContent">
                            <b style="color: cadetblue;"> 가격 </b> 
                            <h3 class="h3_style"> {{get_menus[n].price}} </h3>
                        </div> 
                    </div>                
                </div>

                <!-- 메뉴 설명 -->
                <div class="menuOuter">
                    <div class="Inner">                 
                        <div class="menuBtn">                            
                            <!-- 메뉴 옵션 출력 -->
                            <button class="mBtns" :value="n+1" @click="showOptions" 
                                @click.stop="OptionDialog=true" style="background-color:#E1F5A9;">
                                옵션 보기
                            </button>
                            <v-dialog v-model="OptionDialog" width="50%" scrollable="">
                                <v-card @click.native="OptionDialog = false">
                                    <!-- 타이틀, x 버튼 -->
                                    <v-card-title>
                                        <h1 style="margin: auto"> Options </h1>
                                        <v-btn icon style="float:right" @click="OptionDialog=false">
                                            <v-icon large> clear </v-icon>
                                        </v-btn>
                                    </v-card-title>

                                    <!-- 옵션 출력 영역 --> 
                                    <div id="prtOptions" style="padding-bottom:10%;" v-if="OptionDialog==true">                                       
                                        <div v-if="clickedMenu === null" style="margin-top:5%; text-align:center">    
                                            <h1> 등록된 옵션이 없습니다. </h1>   
                                        </div>  
                                        <div v-else v-for="i in range(1, clickedMenu.num)" :key="i" style="margin-top:4%;">
                                            <b class="opName">
                                                {{clickedMenu[i]['name']}}
                                            </b><br> 
                                            <div class="opSelect" v-for="j in range(1, clickedMenu[i].length-1)" :key="j">
                                                {{clickedMenu[i][j]}}
                                            </div>
                                        </div>           
                                    </div>
                                </v-card>
                            </v-dialog> 

                            <!-- 메뉴 수정하기. -->
                            <button class="mBtns" :value="n+1" @click="modifyMenu" style="background-color:#A9D0F5;">
                                수정
                            </button>                        
                            
                            <!-- 메뉴 삭제하기. -->
                            <button class="mBtns" :value="n+1" style="background-color:#F5A9A9;"
                                @click.stop="DeleteDialog = true; clickedMenu = n+1">
                                삭제
                            </button>
                            <v-dialog v-model="DeleteDialog" width="30%" persistent>
                                <v-card style="padding:3%;">                                    
                                    <div style="width:100%; text-align:center; margin-bottom:3%;">
                                        <b style="font-size:1.5rem;"> 메뉴를 삭제하시겠습니까? </b> 
                                    </div> 
                                    <div style="width:100%;">
                                        <v-btn color="primary" @click="deleteMenu" style="width:45%"  
                                            large @click.stop="DeleteDialog = false">
                                            확인
                                        </v-btn>
                                        <v-btn color="error" style="width:45%" large 
                                            @click.stop="DeleteDialog = false">
                                            취소
                                        </v-btn>  
                                    </div>                                                                     
                                </v-card>
                            </v-dialog>
                        </div>

                        <!-- 메뉴 설명 -->
                        <div class="menuExpl">
                            <b style="color: cadetblue;"> 메뉴 설명 </b> 
                            <h3 class="h3_style"> {{get_menus[n].explanation}} </h3>                    
                        </div>                        
                    </div>
                </div>  
            </v-card> 
        </v-flex>
    </v-layout>  
</div>

<!-- 메뉴 수정하기. -->
<div style="width:100%">
    <v-card v-if="editMenu !== null">
        <!-- 타이틀 -->
        <v-card-title style="background-color:#E6E6E6">
            <h1 style="float:left"> 메뉴 수정하기 </h1>
            <v-spacer></v-spacer>

            <v-btn color="primary" style="float:right" large @click="modifySave"  >수정</v-btn>
            <v-btn color="error"   style="float:right" large @click="modifyCancel">취소</v-btn>
        </v-card-title>   

        <!-- 메뉴 수정 영역 -->
        <v-layout style="margin-top:1%;">
            <!-- 이미지 영역 -->
            <v-flex xs4 ml-4 mr-4 elevation-5>
                <v-card>
                    <h2 class="card_title"> 메뉴 이미지 </h2>
                    
                    <input type="file" id="img_upload_btn" class="ipt_btn"
                        accept=".png, .jpg, .jpeg" @change="menuImgEdit">    
                    <label for="img_upload_btn" class="label_style">
                        <b>이미지 추가</b>
                    </label>

                    <div class="img_div">
                        <!-- <img id="editImg" class="menuImg" src="./image.jpg"> -->
                        <img id="editImg" class="menuImg" :src="editMenu.path + editMenu.filename">
                    </div>
                </v-card>
            </v-flex>

            <!-- 정보 영역 -->
            <v-flex xs4 mr-4 elevation-5>
                <v-card id="menu">
                    <div class="editInfo">
                        <h2 class="card_title"> 메뉴 정보 </h2> 
                    </div>

                    <div class="editInfo">
                        <div class="editColumn">메뉴 명</div> 
                        <input type="text" id="ed_name" class="editInput" :value="editMenu.name">
                    </div>

                    <div class="editInfo">
                        <div class="editColumn">가격</div> 
                        <input type="text" id="ed_price" class="editInput" :value="editMenu.price">
                    </div>

                    <div class="editInfo">
                        <div class="editColumn">카테고리</div> 
                        <select class="editInput" id="ed_category">
                            <option v-for="j in range(0, states.length-1)" :key="j">
                                <h2 v-if="editMenu.category == states[j].name" selected>
                                    {{states[j].name}}
                                </h2>
                                <h2 v-else>{{states[j].name}}</h2>
                            </option>
                        </select>
                    </div>

                    <div class="editInfo">
                        <div class="editColumn">런치 / 디너 구분</div> 
                        <select class="editInput" id="ed_remark">
                            <option v-for="j in range(0, remarkList.length-1)" :key="j">
                                <h2 v-if="editMenu.remark == remarkList[j].text" selected>
                                    {{remarkList[j].text}}
                                </h2>
                                <h2 v-else>{{remarkList[j].text}}</h2>                                                            
                            </option>
                        </select>
                    </div>

                    <div class="editInfo">
                        <div class="editColumn">메뉴 설명</div> 
                        <textarea class="editInput" id="ed_expl" style="height:200px;" :value="editMenu.explanation">
                        </textarea>
                    </div> 
                </v-card>
            </v-flex>

            <!-- 옵션 영역 -->
            <v-flex xs4 mr-4 elevation-5>
                <div style="color:black;">
                    <h2 class="card_title"> 옵션 설정 </h2> 
                    <label for="create_option" id="create_option_label" class="label_style"> 옵션 생성 </label>
                    <input type="button" id="create_option" @click="createOption" class="ipt_btn">                    
                    <div id="editOptions"></div>
                </div>
            </v-flex>
        </v-layout>                                    
    </v-card>                                
</div>
</v-app>  
</div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios'; 
import menuOperate from './OwnerMenuOperate.vue';
import { jSXOpeningElement } from 'babel-types';
  
export default {
    created() {
        let url = '/menu/getCategory';
        let get_categorys = null;
        this.shop_id = this.$route.params.shop_id;      // 샵 아이디 
 
        // 카테고리 요청하기.
        axios.post(url, {
          'shop_id' : this.shop_id
        })
        .then( (response) => {
            get_categorys = response.data.category;
            this.categorys = this.unique(get_categorys); // 카테고리 중복 값 제거.
            this.click_category(this.categorys[0]);
        })
        .catch((ex)=>{
           this.snackbar_text = '레이아웃 로드 실패';
           this.snackbar      = true; 
        });  
    },
 
    data() {
        return {        
            // 스낵바 설정값
            timeout         : 2000,
            snackbar_text   : '',
            snackbar        : false,
            
            shop_id         : null,           // 가게 아이디
            e2              : null,           // 카테고리 클릭 값
            categorys       : null,           // 카테고리 
            clickedCategory : null,           // 클릭한 카테고리
            get_menus       : null,           // 서버에서 보내준 메뉴들 
            menu_num        : 0,              // 메뉴 갯수
            OptionDialog    : false,          // 옵션 보기 다이얼로그 
            DeleteDialog    : false,          // 삭제하기 다이얼로그
            clickedMenu     : null,           // 클릭한 메뉴
            editMenu        : null,           // 수정할 메뉴  

            // 카테고리
            states: [
                { name: '특선'}, { name: '추천메뉴'}, { name: '식사류'},
                { name: '탕류'}, { name: '찜류'}, { name: '안주류'},
                { name: '주류'}, { name: '음료'}, { name: '추가 메뉴'},
            ],

            // 점심, 저녁 메뉴 구분
            remarkList : [{ text: '상관 없음'},{ text: '런치 메뉴'},{ text: '디너 메뉴'}],
        }
    }, 

    // 메뉴 수정하기 클릭 시 메뉴 옵션 로드 메소드 실행함
    updated(){
        if(this.editMenu !== null && this.editMenu.opNum !== undefined){
            this.loadOptions(); 
        } 
    },

    methods : {        
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
            return Array(end - start + 1).fill().map((_, idx) => start + idx)
        },

        // 메뉴 카테고리 클릭
        click_category : function(argMenu) { 
            let url = "";                           // 서버에 요청할 주소 
            
            // 클릭으로 호출
            if(argMenu === event){
                this.clickedCategory = event.target;

                // 클릭한 값 검사
                if(this.clickedCategory.value === undefined)  
                    this.clickedCategory = this.clickedCategory.parentNode.value;
                else  
                    this.clickedCategory = this.clickedCategory.value;                
            }
            // 최초 호출 
            else {
                this.clickedCategory = argMenu;
            }

            url = '/menu/getMenu/' + this.shop_id + '/' + this.clickedCategory;
 
            // 클릭한 카테고리의 메뉴 호출
            axios.get(url)
            .then( (response) => {
                this.get_menus = response.data.menu; 
                this.menu_num  = this.get_menus.length;                  
            })
            .catch((ex)=>{
                this.snackbar_text = '메뉴 로드 실패';
                this.snackbar      = true; 
            });                       
        },  

        // 옵션 보기 
        showOptions : function(){
            let index = event.target.value;                     // 클릭한 button value
            let menu  = this.get_menus[index -1];               // 클릭한 메뉴
            let arr   = [];                                     // 옵션을 넣을 배열 

            this.clickedMenu = null;

            // 옵션이 있는 경우 작업 시작 - 옵션 배열 뽑아 내기
            if(menu.opNum !== undefined){   
                arr['num'] = menu["opNum"];                                 // 옵션 갯수
                
                for(let i=1; i <= menu.opNum; i++){
                    arr[i] = [];
                    arr[i]['name'] = menu["optionName" +i];                 // 옵션 이름 
                   
                    for(let j=1; j <= menu['subOpNum' +i]; j++){
                        arr[i][j] = menu[i +"optionValue" +j];             // 옵션 값 
                    } 
                }
                this.clickedMenu = arr; 
            }
            // 옵션이 없는 경우
            else { 
                this.OptionDialog = false; 
            }  
        },
        
        // 수정하기
        modifyMenu : function(){ 
            let index = event.target.value;                   // 클릭한 button value
            let menus = document.getElementById('menus');       // 메뉴 출력 창
            
            this.editMenu = null;
            this.editMenu = this.get_menus[index -1];           // 클릭한 메뉴 
            menus.style.display = 'none';  
        },

        // 수정하기 - 수정 완료 
        modifySave : function(){ 
            let formData    = new FormData(); 
            let menu_img    = document.getElementById('img_upload_btn');       // 등록한 이미지 
            let ed_name     = document.getElementById('ed_name').value;              
            let ed_price    = document.getElementById('ed_price').value;
            let ed_category = document.getElementById('ed_category').value;
            let ed_remark   = document.getElementById('ed_remark').value;
            let ed_expl     = document.getElementById('ed_expl').value;
            let editOptions = document.getElementById('editOptions');          

            formData.append('shop_id', this.shop_id);  
             
            // 업로드한 이미지가 있는지 체크 후 진행함
            if(menu_img.files[0] !== undefined){   
                formData.append('menu_img',menu_img.files[0]);                              
            }
            // 등록된 이미지가 없는 경우 기존 이미지 유지
            else {
                formData.append('menu_img', 1);
            }    
            
            // 메뉴 정보 빈 값 없는지 체크
            if(ed_name!=='' && ed_price!=='' && ed_category!=='' && ed_remark!=='' && ed_expl!=='') {                    
                formData.append('name', ed_name);
                formData.append('price', ed_price);
                formData.append('category', ed_category);
                formData.append('remark', ed_remark);
                formData.append('explanation', ed_expl);  
                formData.append('menu_id', this.editMenu.id);

                // 옵션 담기. 없으면 실행 안함.
                if(editOptions.children.length !== 0){
                    for(let i=0; i < editOptions.children.length; i++){
                        let optionBox = editOptions.children[i];        
                        let optionName = optionBox.children[0].children[0];
                        
                        if(optionName.tagName !== 'B' || optionName.innerText === ''){
                            this.snackbar_text = '입력이 완료 되지 않은 옵션 명이 있습니다!';
                            this.snackbar      = true;
                            return null;  
                        }
                        // 옵션 이름, 옵션 값 갯수 담기.
                        formData.append('option['+ i +'][name]', optionName.innerText);
                        formData.append('option['+ i +'][num]',  optionBox.children.length -1);

                        // 옵션 값 담기 (선택 값이 2개 이하면 경고 메세지 출력)
                        if(optionBox.children.length -1 > 1){
                            for(let j=0; j < optionBox.children.length -1; j++){
                                let optionValue = optionBox.children[j+1].children[0];  // 옵션 값

                                // 옵션 값이 입력 창인 상태이거나 옵션 명이 입력되지 않은 경우 경고 메세지 출력
                                if(optionValue.tagName !== 'B' || optionValue.innerText === ''){
                                    this.snackbar_text = '입력이 완료 되지 않은 옵션 값이 있습니다!';
                                    this.snackbar      = true; 
                                    return null; 
                                }
                                formData.append('option['+ i +'][value' + j+']',optionValue.innerText);
                            }
                        } else {
                            this.snackbar_text = '옵션의 선택 값을 2개 이상 생성해주세요!';
                            this.snackbar      = true;
                            return null; 
                        }
                        
                    }
                }                                 
                // 콘솔창에 띄우기
                for(var pair of formData.entries()) {
                    console.log(pair[0]+ ', '+ pair[1]); 
                }

                /* 선주야 이거 해줘 */   
                axios.post('/updateMenu',formData)
                .then( (response) => { 
                    this.snackbar_text = '수정 완료';
                    this.snackbar      = true;                
                    this.modifyCancel();
                    return null;
                })
                .catch((ex)=>{
                    console.log('failed',ex);
                });                
            }
            // 메뉴 정보가 모두 입력되지 않은 경우 경고 메세지 출력
            else { 
                this.snackbar_text = '메뉴 정보를 모두 입력해 주세요';
                this.snackbar      = true;                 
                return null;  
            } 
        },

        // 수정하기 - 수정 취소 
        modifyCancel : function(){
            let menus = document.getElementById('menus');       // 메뉴 출력 창            
            menus.style.display = 'block';
            this.editMenu = null;
            this.click_category();                              // 리스트 업
        },

        // 수정하기 - 옵션 불러오기
        loadOptions : function() { 
            let editOptions = document.getElementById('editOptions');         // 옵션들이 들어갈 div
           
            for(let i=1; i <= this.editMenu.opNum; i++){
                let options_box     = document.createElement('div');            // 옵션 명, 옵션 값을 담을 div
                let created_option  = document.createElement('div');            // 옵션 명이 될 div  
                let created_b       = document.createElement('b');              // 옵션 명
                let created_btns    = [                                         // 옵션 명 div에 들어갈 버튼들.
                                        document.createElement('input'),       
                                        document.createElement('input'),        
                                        document.createElement('input')       
                                    ];
                created_b.innerText = this.editMenu['optionName' +i];           // 옵션 초기 이름 값 설정.
                created_b.classList.add('ed_op_b');  

                created_option.classList.add('ed_op_div');                      // 옵션 명에 css 추가
                created_option.prepend(created_b);                               

                // 들어갈 버튼들 값 설정, css 추가, 메소드 설정
                for (let a=0; a < created_btns.length; a++){                   
                    created_btns[a].setAttribute('type','button');
                    created_btns[a].classList.add('ed_op_btn');

                    switch(a){
                        case 0:
                            created_btns[a].value   = '삭제';                  
                            created_btns[a].style.color = 'cadetblue';
                            created_btns[a].onclick = this.delete_option; break;
                        case 1:
                            created_btns[a].value   = '옵션 값 생성';
                            created_btns[a].onclick = this.add_opionValue; break;
                        case 2: 
                            created_btns[a].value   = '수정';                            
                            created_btns[a].style.color = 'cadetblue';
                            created_btns[a].onclick = this.rename_option; break;
                    }                    
                    created_option.appendChild(created_btns[a]);
                }                              

                // 옵션 목록 div에 옵션 삽입   
                options_box.classList.add('ed_op_box');
                options_box.appendChild(created_option);
                editOptions.appendChild(options_box);                

                for(let j=1; j <= this.editMenu['subOpNum' +i]; j++){ 
                    let optionValue   = document.createElement('div');           // 하위 카테고리 div 생성
                    let Value_b       = document.createElement('b');             // 카테고리 명 입력할 b 태그
                    let Value_btns    = [
                                            document.createElement('input'), 
                                            document.createElement('input')
                                        ];  

                    // 들어갈 버튼들 값 설정, css 추가.
                    for (let b=0; b < Value_btns.length; b++){                   
                        Value_btns[b].setAttribute('type','button');
                        Value_btns[b].classList.add('ed_op_btn');

                        switch(b){
                            case 0:
                                Value_btns[b].value   = '삭제';
                                Value_btns[b].onclick = this.delete_optionValue; break;
                            case 1:
                                Value_btns[b].value   = '수정';                  
                                Value_btns[b].style.color = 'cadetblue';
                                Value_btns[b].onclick = this.rename_option; break; 
                        }                        
                        optionValue.appendChild(Value_btns[b]);
                    }      

                    Value_b.innerText = this.editMenu[i+ 'optionValue' +j];  
                    Value_b.classList.add('ed_op_b');
 
                    optionValue.prepend(Value_b);
                    optionValue.classList.add('ed_op_value');

                    options_box.appendChild(optionValue);
                }
            }           
           
        }, // end of loadOptions
        
        // 수정하기 - 이미지 업로드하기.
        menuImgEdit: function(){ 
            let editImg = document.getElementById("editImg");  // 메뉴 이미지
            let reader  = new FileReader();

            // 이미지 미리보기 띄우기
            reader.onload = function() {
                editImg.src = reader.result;  
            }; 
            reader.readAsDataURL(event.target.files[0]); 
        },

        // 수정하기 - 옵션 만들기.
        createOption : function() { 
            let editOptions     = document.getElementById('editOptions');   // 옵션들이 들어갈 div
            let options_box     = document.createElement('div');            // 옵션 명, 옵션 값을 담을 div
            let created_option  = document.createElement('div');            // 옵션 명이 될 div  
            let created_input   = document.createElement('input');          // 카테고리 명 입력 창 만들기.
            let created_btns    = [                                         // 옵션 명 div에 들어갈 버튼들.
                                    document.createElement('input'),       
                                    document.createElement('input'),        
                                    document.createElement('input')       
                                ]; 
            created_input.classList.add('ed_op_ipt');
            created_option.classList.add('ed_op_div');                     // 옵션 명에 css 추가
            created_option.prepend(created_input);                               

            // 들어갈 버튼들 값 설정, css 추가, 메소드 설정
            for (let i=0; i < created_btns.length; i++){                   
                created_btns[i].setAttribute('type','button');
                created_btns[i].classList.add('ed_op_btn');

                switch(i){
                    case 0:
                        created_btns[i].value       = '삭제';
                        created_btns[i].style.color = 'cadetblue';
                        created_btns[i].onclick     = this.delete_option; break;
                    case 1:
                        created_btns[i].value   = '옵션 값 생성';
                        created_btns[i].onclick = this.add_opionValue; break;
                    case 2: 
                        created_btns[i].value       = '완료';
                        created_btns[i].style.color = 'cadetblue';
                        created_btns[i].onclick     = this.rename_complete; break;
                }
                created_option.appendChild(created_btns[i]);
            }
            // 옵션 목록 div에 옵션 삽입 
            options_box.classList.add('ed_op_box');
            options_box.appendChild(created_option);
            editOptions.appendChild(options_box);  
        }, // end of create_option

        // 수정하기 - 옵션 명 수정하기
        rename_option : function(event){
            let get_option      = event.target.parentNode;             // 해당 옵션 가져오기
            let get_rename_btn  = event.target                         // 수정 버튼 가져오기 
            let created_input   = document.createElement('input');     // 카테고리 명 입력 창 만들기.

            get_rename_btn.value   = "완료";                           // 수정 버튼을 완료 버튼으로 변경
            get_rename_btn.onclick = this.rename_complete;
 
            created_input.classList.add('ed_op_ipt'); 

            get_option.removeChild(get_option.children[0]);             // 기본 카테고리명 지우기.
            get_option.prepend(created_input);                          // 첫번째 자식으로 넣음
        }, 

        // 수정하기 - 이름 수정 완료
        rename_complete : function(){
            let get_option  = event.target.parentNode;          // 해당 카테고리 가져오기
            let get_cpt_btn = event.target;                     // 완료 버튼 가져오기.
            let get_iptText = get_option.children[0];           // input 태그 가져오기
            let created_b   = document.createElement('b');      // 카테고리 명 생성.
 
            if(get_iptText.value.replace(/ /gi, "") === ''){
                this.snackbar_text = '값을 입력해 주세요!';
                this.snackbar      = true;                 
                return null; 
            }
            created_b.innerText = get_iptText.value;                                                   
            created_b.classList.add('ed_op_b');
            
            get_cpt_btn.value   = "수정";                       // 완료 버튼을 수정 버튼으로 변경시킴. 
            get_cpt_btn.onclick = this.rename_option;   
 
            get_option.removeChild(get_iptText);              // input 태그 삭제.
            get_option.prepend(created_b);                    // 첫번째 자식으로 넣음
        },

        // 수정하기 - 옵션 값 생성
        add_opionValue : function(event){  
            let get_box         = event.target.parentNode.parentNode;      // 해당 카테고리 박스 가져오기
            let optionValue     = document.createElement('div');           // 하위 카테고리 div 생성
            let created_input   = document.createElement('input');          // 카테고리 명 입력 창 만들기.
            let created_btns    = [
                                    document.createElement('input'), 
                                    document.createElement('input')
                                ]; 
            // 들어갈 버튼들 값 설정, css 추가.
            for (let i=0; i < created_btns.length; i++){                   
                created_btns[i].setAttribute('type','button');
                created_btns[i].classList.add('ed_op_btn');

                switch(i){
                    case 0:
                        created_btns[i].value   = '삭제';
                        created_btns[i].onclick = this.delete_optionValue; break;
                    case 1:
                        created_btns[i].value       = '완료';
                        created_btns[i].style.color = 'cadetblue';
                        created_btns[i].onclick     = this.rename_complete; break; 
                }
                optionValue.appendChild(created_btns[i]);
            } 
            created_input.classList.add('ed_op_ipt');

            optionValue.classList.add('ed_op_value');
            optionValue.prepend(created_input);

            get_box.appendChild(optionValue);
        }, // end of add_opionValue

        // 수정하기 - 클릭한 옵션 삭제 
        delete_option : function(){
            let option = event.target.parentNode;
            option.parentNode.parentNode.removeChild(option.parentNode);   
        },

        // 수정하기 - 클릭한 옵션 값 삭제 
        delete_optionValue : function(){
            let op_value = event.target.parentNode;
            op_value.parentNode.removeChild(op_value);          
        },
        
        // 삭제하기
        deleteMenu : function(){ 
            let get_menu = document.getElementById(this.clickedMenu);
            let prtArea  = document.getElementById('prtArea').children[0];
            let url      = '/deleteMenu';

            // 데이터베이스에서 삭제
            axios.post(url,{
                'shop_id' : this.shop_id,
                'menu_id' : get_menu.id
            })
            .then( (response) => {
                let result = response.data.result;      // 삭제 성공 / 실패 여부
                if(true){                    
                    prtArea.removeChild(get_menu);
                    this.snackbar_text = '삭제 되었습니다.';
                    this.snackbar      = true;                 
                    return null; 
                } else {                 
                    this.snackbar_text = '삭제 실패.';
                    this.snackbar      = true;                 
                    return null;    
                }                
            })
            .catch((ex)=>{
                this.snackbar_text = '서버 연결 실패';
                this.snackbar      = true;                 
                return null; 
            });       
        } 
    }
}

</script>

<style>
.h3_style { margin-top: 1%; font-size: 1.2rem; padding: 1%;}

/* 메뉴 전체 */
#prtArea {
    width: 100%; 
    /* height: 0; */
    margin-top: 2%;
    padding-bottom: 50%; 
    position: relative;
    overflow: auto;  
} 

/* 옵션 보기 모달 */
#prtOptions {    
    width: 100%;
    height: 95%;
    border-top: 2px solid #6E6E6E; 
    color : black;
    background-color: white;  
    overflow: auto;
}
/* 옵션 이름 */
.opName{
    font-size: 1.8rem;
    color: cadetblue;
    margin-left: 7%;
}
/* 옵션 select */
.opSelect {    
    width: 80%;
    height: 10%;
    margin-top: 1.5%; 
    margin-left: 10%;  
    font-size: 1.5rem;
    border-bottom: 2px solid #6E6E6E; 
}

/* 메뉴 */
.menuBody {
    width: 100%; 
    margin-top: 2%;
    border: 1px solid #6E6E6E;
    color: black; 
    overflow: hidden;
}
/* 메뉴 div 비율용 */
.menuOuter {    
    width: 33.3%;
    height: 0;
    padding-bottom: 25%;
    /* border: 1px solid #6E6E6E; */
    position: relative;
    overflow: hidden;
    float: left;
}
/* div 비율용 */
.Inner{
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;    
    position: absolute;
}
/* 메뉴 이미지 */
.menuImg{
    top: 0;
    left: 0;
    width: 105%;
    height: 105%;    
    object-fit: cover;
    position: absolute;
}
/* 메뉴 정보 */
.menuContent{    
    width: 100%;
    height: 33.3%;
    padding: 1%;
    border-left: 1px solid #6E6E6E;
    border-bottom: 1px solid #6E6E6E;
    position: relative;
    overflow: auto;
}
/* 버튼 영역 */
.menuBtn{    
    width: 100%;
    height: 20%;
    border: 1px solid #6E6E6E;
    position: relative; 
}
/* 버튼 */
.mBtns {
    width: 33.3%;
    height: 100%;  
    font-weight: bolder;
    float: left;
    position: relative; 
    overflow: hidden;
} 
/* 메뉴 설명 */
.menuExpl{    
    width: 100%;
    height: 80%;
    padding: 1%;
    border: 1px solid #6E6E6E;
    position: relative;
    overflow: auto;
}
  
.card_title{
    margin-bottom: 3%;
    margin-left: 2%;
    text-align: left; 
    position: relative;
}
/* input file 안보이게 하기 */
.ipt_btn{
    width: 0%;
    font-size: 0px;
    opacity: 0;
    position: relative; 
}
/* 메뉴 이미지 업로드 라벨 */
.label_style{
    font-size: 1.5rem;
    margin-right: 3%; 
    color: cadetblue; 
    font-weight: bold;
    float:right;
    user-select:none;               /* 드래그 방지 */
    -ms-user-select: none; 
    -moz-user-select: -moz-none; 
    -webkit-user-select: none; 
    -khtml-user-select: none; 
} 
/* 마우스 클릭하고있을때 */
.label_style:active{
    color: darkseagreen;
}
/* 마우스 한번클릭후 */
.label_style:visited{
    color: cadetblue;
} 
/* 메뉴 이미지 비율 고정용 */
.img_div {
    width: 95%;
    height: 0;
    margin: 2.5%; 
    padding-bottom: 70%;
    overflow: hidden;
    position: relative;
}

/* 수정 메뉴 정보 타이틀 */
.editInfo {
    width:100%;
    height: 10%;
    padding: 1%;
    margin-bottom: 4%;  
}
.editColumn {
    font-size: 1.4rem;
    margin-bottom: 3%;  
    font-weight: bold;
}
.editInput {
    width: 90%;
    height: 10%;    
    font-size: 1.4rem;
    margin-left: 5%; 
    border-bottom: 2px solid #BDBDBD;
}

/* 옵션들이 출력될 div 스타일 */
#editOptions{
    width:100%;
    height: auto;
    overflow: hidden;
    margin-top: 5%;
    margin-bottom: 5%;  
}
/* 하나의 옵션명과 그 옵션 값들을 감싸는 div */
.ed_op_box {
    width: 100%;
    height: auto; 
    overflow:hidden; 
    margin-top: 10%;
}
/* 옵션 */
.ed_op_div {
    width: 100%; 
    margin-top: 1%;
    border-bottom: 1px solid;
    position: relative; 
    overflow:hidden; 
}
/* 옵션명의 버튼들 */
.ed_op_btn {
    min-width: 10%;
    margin: 1%;
    float: right;
    position: relative;
    color: rgb(135, 194, 196);  
    font-weight: bold;
}
/* 옵션의 값 */
.ed_op_value {
    width: 95%; 
    margin-top: 1%;
    border-bottom: 1px solid;
    position: relative;
    overflow:hidden; 
    float: right; 
}
/* 옵션 명을 출력할 b태그 */
.ed_op_b {
    font-size: 1.3rem;
    margin-left: 1%;
    float: left; 
}
/* 옵션 수정에 사용할 input text 태그 */
.ed_op_ipt {
    width: 40%; 
    margin-left: 1%; 
    font-size: 1.2rem;
    background-color: rgb(135, 194, 196);  
    float: left; 
    font-weight: bold;
}
</style>