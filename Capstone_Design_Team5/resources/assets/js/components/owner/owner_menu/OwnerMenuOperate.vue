<template>
    <div class="container" style="border:2px solid;"> 
    <v-container>
        <v-layout>
            <v-flex xs10> 
                <b style="font-size:2rem"> 메뉴추가 </b>
            </v-flex>  
            <v-flex xs2>
                <v-btn color="error" @click="save_data"> 저장 </v-btn>
            </v-flex> 
        </v-layout>
         
        <v-layout mt-4> 
            <!-- 메뉴 이미지 영역 -->
            <v-flex xs4 mr-4>                         
                <v-card elevation-24 class="card" >
                    <h2 class="card_title"> 메뉴 이미지 </h2>
                    <input type="file" id="img_upload_btn" accept=".png, .jpg, .jpeg" @change="img_upload">    
                    <label for="img_upload_btn"><b>이미지 추가</b></label>

                    <div class="img_div">
                        <img id="menu_img">
                    </div>
                </v-card>
            </v-flex>

            <!-- 메뉴 정보 입력 -->
            <v-flex xs4 mr-4>
                <v-card elevation-24 class="card">
                    <h2 class="card_title"> 메뉴 정보 입력 </h2>

                    <v-text-field label="메뉴명" v-model="name" :rules="nameRule"></v-text-field>
                        
                    <v-text-field label="가격" v-model="price" :rules="priceRule"></v-text-field>

                    <v-select v-model="category" :items="states" item-text="name" autocomplete
                        :filter="customFilter" label="카테고리 설정 (직접입력 가능)"></v-select>

                    <v-select v-model="remark" :items="remarkList" label="런치 / 디너 메뉴 구분"></v-select>                   

                    <v-text-field v-model="explanation" label="메뉴 설명" multi-line></v-text-field>
                </v-card>
            </v-flex>
 
            <!-- 메뉴 옵션 추가하기 -->
            <v-flex xs4>
                <v-card elevation-24 class="card">
                    <h2 class="card_title"> 옵션 설정 </h2> 
                    <label for="create_option"> <b>옵션 생성</b> </label>
                    <input type="button" id="create_option" @click="create_option" style="opacity:0;">
                    <div id="options"></div>                
                </v-card>
            </v-flex>
        </v-layout>
        <input type="hidden" name="op_num" value="0">
        
    </v-container>
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';
 
// var shop_id = this.$route.params.shop_id; 
var num = 0;                                    // 옵션 갯수
 
export default {
    data() {
        return { 
            // 입력 받을 거
            name        : null,
            category    : null,
            price       : null,
            remark      : null,
            explanation : null,

            // 입력하지 않으면 경고 메세지 출력
            nameRule        : [ v => !!v || '메뉴 명을 입력해주세요!' ],            
            categoryRule    : [ v => !!v || '카테고리를 입력해주세요!' ],
            priceRule       : [ v => !!v || '가격을 입력해주세요!' ], 

            states: [
                { name: '특선'}, { name: '추천메뉴'}, { name: '식사류'},
                { name: '탕류'}, { name: '찜류'}, { name: '안주류'},
                { name: '주류'}, { name: '음료'}, { name: '추가 메뉴'},
            ],
            customFilter (item, queryText, itemText) {
                const hasValue = val => val != null ? val : ''
                const text = hasValue(item.name)
                const query = hasValue(queryText)
                return text.toString()
                .toLowerCase()
                .indexOf(query.toString().toLowerCase()) > -1
            },

            // 점심, 저녁 메뉴 구분
            remarkList : [{ text: '상관 없음'},{ text: '런치 메뉴'},{ text: '디너 메뉴'}],
            
        }
    },

    methods : {
        // 저장
        save_data : function () {
            let formData = new FormData(); 
            let menu_img = document.getElementById('img_upload_btn');   // 등록한 이미지 
            let options  = document.getElementById('options');          // 카테고리 리스트 가져오기
            let op_array = [];
            
            // 업로드한 이미지가 있는지 체크 후 진행함
            if(menu_img.files[0] !== undefined){   
                formData.append('menu_img',menu_img.files[0]);
                // formData.append('shop_id',shop_id);

                if( this.name !== null && this.price !== null && this.category !== null && 
                    this.explanation !== null && this.remark !== null) {
                    
                    formData.append('name', this.name);
                    formData.append('price', this.price);
                    formData.append('category', this.category.name);
                    formData.append('remark', this.remark.text);
                    formData.append('explanation', this.explanation); 
 
                    for(let i=0; i < options.children.length; i++){
                        let optionName   = document.getElementById('optionName' + i);
                        let optionValues = document.getElementsByName('option' + i + 'values');

                        op_array[i] = []; 

                        formData.append('option['+ i +'][name]', optionName.children[0].innerText);

                        for(let j=0; j < optionValues.length; j++){
                            formData.append('option['+ i +'][value' + j+']', 
                                optionValues[j].children[0].innerText);
                        }
                        formData.append('option['+ i +'][num]', optionValues.length);
                    }

                    // 콘솔창에 띄우기
                    // for(var pair of formData.entries()) {
                    //     console.log(pair[0]+ ', '+ pair[1]); 
                    // }
                      
                    axios.post('/test',formData)
                    .then( (response) => { 
                        alert('메뉴 등록 성공'); 
                        console.log(response.data.ddd);

                    })
                    .catch((ex)=>{
                        console.log('failed',ex);
                    })
                    
                }
                // 메뉴 정보가 모두 입력되지 않은 경우 경고 메세지 출력
                else {
                    alert('메뉴 정보를 모두 입력해 주세요');
                } 
            }
            // 등록된 이미지가 없는 경우 경고 메세지 출력
            else {
                alert('이미지 등록 해 주세요');
            }
            
        },

        // 이미지 업로드하기.
        img_upload: function(){
            let menu_img = document.getElementById("menu_img");  // 메뉴 이미지
            let reader   = new FileReader();

            // 이미지 미리보기 띄우기
            reader.onload = function() {
                menu_img.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        },

        // 옵션 만들기.
        create_option : function() {
            let options         = document.getElementById('options');       // 옵션들이 들어갈 div
            let options_box     = document.createElement('div');            // 옵션 명, 옵션 값을 담을 div
            let created_option  = document.createElement('div');            // 옵션 명이 될 div  
            let created_b       = document.createElement('b');              // 옵션 명
            let created_btns    = [                                         // 옵션 명 div에 들어갈 버튼들.
                                    document.createElement('input'),       
                                    document.createElement('input'),        
                                    document.createElement('input')       
                                ]
            created_b.innerText = "옵션" + num;                             // 옵션 초기 이름 값 설정.
            created_b.classList.add('op_b'); 

            created_option.id = 'optionName' + num;
            created_option.classList.add('optionName');                     // 옵션 명에 css 추가
            created_option.prepend(created_b);                               

            // 들어갈 버튼들 값 설정, css 추가, 메소드 설정
            for (let i=0; i < created_btns.length; i++){                   
                created_btns[i].setAttribute('type','button');
                created_btns[i].classList.add('optionBtn');

                switch(i){
                    case 0:
                        created_btns[i].value   = '삭제';
                        created_btns[i].onclick = this.delete_option; break;
                    case 1:
                        created_btns[i].value   = '옵션 값 생성';
                        created_btns[i].onclick = this.add_opionValue; break;
                    case 2: 
                        created_btns[i].value   = '수정';
                        created_btns[i].onclick = this.rename_option; break;
                }
                created_option.appendChild(created_btns[i]);
            }
            // 옵션 목록 div에 옵션 삽입
            options_box.id = 'option' + num; num++;
            options_box.classList.add('box');
            options_box.appendChild(created_option);
            options.appendChild (options_box);

        }, // end of create_option

        // 옵션 명 수정하기
        rename_option : function(event){
            let get_option      = event.target.parentNode;             // 해당 옵션 가져오기
            let get_rename_btn  = event.target                         // 수정 버튼 가져오기 
            let created_input   = document.createElement('input');     // 카테고리 명 입력 창 만들기.

            get_rename_btn.value   = "완료";                           // 수정 버튼을 완료 버튼으로 변경
            get_rename_btn.onclick = this.rename_complete;
 
            created_input.classList.add('op_ipt'); 

            get_option.removeChild(get_option.children[0]);             // 기본 카테고리명 지우기.
            get_option.prepend(created_input);                          // 첫번째 자식으로 넣음
        }, 

        // 이름 수정 완료
        rename_complete : function(){
            let get_option  = event.target.parentNode;          // 해당 카테고리 가져오기
            let get_cpt_btn = event.target;                     // 완료 버튼 가져오기.
            let get_iptText = get_option.children[0];           // input 태그 가져오기
            let created_b   = document.createElement('b');      // 카테고리 명 생성.
 
            created_b.innerText = get_iptText.value;                                                   
            created_b.classList.add('op_b');
            
            get_cpt_btn.value   = "수정";                       // 완료 버튼을 수정 버튼으로 변경시킴. 
            get_cpt_btn.onclick = this.rename_option;   
 
            get_option.removeChild(get_iptText);              // input 태그 삭제.
            get_option.prepend(created_b);                    // 첫번째 자식으로 넣음
        },

        // 옵션 값 생성
        add_opionValue : function(event){  
            let get_box         = event.target.parentNode.parentNode;      // 해당 카테고리 박스 가져오기
            let optionValue     = document.createElement('div');           // 하위 카테고리 div 생성
            let created_b       = document.createElement('b');             // 카테고리 명 입력할 b 태그
            let created_btns    = [
                                    document.createElement('input'), 
                                    document.createElement('input')
                                ]; 
            // 들어갈 버튼들 값 설정, css 추가.
            for (let i=0; i < created_btns.length; i++){                   
                created_btns[i].setAttribute('type','button');
                created_btns[i].classList.add('optionBtn');

                switch(i){
                    case 0:
                        created_btns[i].value   = '삭제';
                        created_btns[i].onclick = this.delete_optionValue; break;
                    case 1:
                        created_btns[i].value   = '수정';
                        created_btns[i].onclick = this.rename_option; break; 
                }
                optionValue.appendChild(created_btns[i]);
            }
            
            created_b.innerText = '옵션 값';
            created_b.classList.add('op_b');

            optionValue.setAttribute('name', get_box.id + "values"); 
            optionValue.prepend(created_b);
            optionValue.classList.add('optionValue');

            get_box.appendChild(optionValue);
        }, // end of add_opionValue

        // 클릭한 옵션 삭제 
        delete_option : function(){
            let option = event.target.parentNode;
            option.parentNode.parentNode.removeChild(option.parentNode);   
        },

        // 클릭한 옵션 값 삭제 
        delete_optionValue : function(){
            let op_value = event.target.parentNode;
            op_value.parentNode.removeChild(op_value);          
        },

    }, // end of method
}
</script>

<style>

/* v-card padding 값 통일 */
.card{
    padding: 5%;
}
.card_title{
    float:left; 
    margin-bottom: 3%;
}

/* input file 안보이게 하기 */
#img_upload_btn{
    width: 0%;
    font-size: 0px;
    opacity: 0;
    position: relative; 
}
/* 메뉴 이미지 업로드 라벨 */
label{
    color: cadetblue; 
    float:right;
    font-size: 1.5rem;
    margin-right: 3%; 
}
/* 메뉴 이미지 비율 고정용 */
.img_div {
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 70%;
}
/* 메뉴 이미지 스타일 */
#menu_img { 
    position: absolute;
    top: 0;
    left: 0;
    width: 105%;
    height: 105%; 
    object-fit: cover; 
} 
/* 옵션들이 출력될 div 스타일 */
#options{
    width:100%;
    height: auto;
    overflow: hidden;
    margin-top: 5%;
    margin-bottom: 5%;
    /* border: 1px solid black; */
}
/* 하나의 옵션명과 그 옵션 값들을 감싸는 div */
.box {
    width: 100%;
    height: auto; 
    overflow:hidden; 
    margin-top: 10%;
}
/* 옵션명 */
.optionName {
    width: 100%; 
    margin-top: 1%;
    border-bottom: 1px solid;
    position: relative; 
    overflow:hidden; 
}
/* 옵션명의 버튼들 */
.optionBtn {
    min-width: 10%;
    margin: 1%;
    float: right;
    position: relative;
    color: cadetblue; 
}
/* 옵션의 값 */
.optionValue {
    width: 95%; 
    margin-top: 1%;
    border-bottom: 1px solid;
    position: relative;
    overflow:hidden; 
    float: right; 
}
/* 옵션 명을 출력할 b태그 */
.op_b {
    float: left; 
    margin-left: 1%;
}
/* 옵션 수정에 사용할 input text 태그 */
.op_ipt {
    float: left; 
    width: 40%; 
    margin-left: 1%;
    /*border: 1px solid;*/
    background-color: rgb(135, 194, 196);  
}
</style>
