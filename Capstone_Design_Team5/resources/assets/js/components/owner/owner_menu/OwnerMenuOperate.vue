<template>
    <div class="container" style="width:100%; border:1px solid; "> 
        <h3 style="float:left"> 메뉴추가 </h3>
        <input type="button" id="save"   value="저장" class="header_btn" @click="save_data">
        <hr>  

        <form id="form_el" style="width:95%; margin:auto; margin-top:1%;">
            <div class="inner_div"> 
                <div style="width: 90%">
                    <h4 style="float:left"> 이미지 </h4>     
                    <input 
                        type    = "file" 
                        id      = "img_upload_btn" 
                        accept  = ".png, .jpg, .jpeg" 
                        @change = "img_upload"
                    >    
                    <label for="img_upload_btn">이미지 추가</label>
                </div>
                <img id="menu_img">
            </div>

            <div class="inner_div"> 
                <h4> 메뉴 명 </h4>
                <input type="text" name="name" class="values input_text">

                <h4> 가격 </h4>
                <input type="text" name="price" class="values input_text">

                <h4> 카테고리 </h4>
                
                <input 
                    type   = "text" 
                    name   = "category" 
                    class  = "values input_text" 
                    value  = "입력 또는 선택"
                    @click = "click_category"
                > 
                <div id="category_list" class="select_category">
                    <ul>
                        <li @click="select_finish"> 직접입력 </li>
                        <li @click="select_finish"> 특선 </li>
                        <li @click="select_finish"> 추천메뉴 </li>
                        <li @click="select_finish"> 식사류 </li>
                        <li @click="select_finish"> 안주류 </li>
                        <li @click="select_finish"> 주류 </li>
                        <li @click="select_finish"> 디저트 </li>
                        <li @click="select_finish"> 음료 </li>
                    </ul>
                </div>

                <h4> 메뉴 설명</h4>
                <textarea name="explanation" class="values" style="height:30%;"></textarea>
            </div>
            
            <div class="inner_div"> 
                <h4> 런치 디너 구분 </h4>
                <select name="remark" class="values">
                    <option value="default"> 상관 없음 </option>
                    <option value="lunch"> 런치 메뉴 </option>
                    <option value="dinner"> 디너 메뉴 </option>
                </select>

                <div style="width: 100%; margin-top: 7%;">
                    <h4 style="float: left"> 옵션 설정 </h4> 
                    <label for="create_option_value"> 옵션 값 생성 </label>
                    <input type="button" id="create_option_value" @click="create_option" style="opacity: 0;">
                </div>

                <div class="option_box">
                    <h5 class="option_column"> 옵션 명 </h5>
                    <input 
                        type  = "text" 
                        name  = "option_name" 
                        class = "values option_input" 
                        value = "없으면 입력 x"
                    >
                </div>

                <div id="options"> </div>
            </div>
        </form>
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';

var option_num = 0;
 
export default {
    methods : {
        // 저장
        save_data : function () {
            var formData  = new FormData(document.getElementById('form_el')); 
            var get_img   = document.getElementById('img_upload_btn');  // 등록한 이미지 
            var get_data  = document.getElementsByClassName('values');  // 등록한 데이터들
            var check     = true;                                       // 유효성 검사용

            // 업로드한 이미지가 있는지 체크 후 진행함
            if(get_img.files[0] !== undefined){   
                formData.append('menu_img',get_img.files[0]);
 
                for(let i=0; i < get_data.length; i++){
                    // 입력한 값이 있는지 체크 후 배열에 저장
                    let ipt = get_data[i].value.replace(/ /gi, "");

                    if(ipt === "" || ipt === "입력또는선택"){   
                        alert('값을 모두 입력 해주세요!');
                        check = false;
                        break;   
                    }
                }
                // 모든 값이 입력 되었다면 전송함.
                if (check === true){    

                    // 콘솔창에 띄우기
                    for(var pair of formData.entries()) {
                        console.log(pair[0]+ ', '+ pair[1]); 
                    }

                    axios.post('/test',formData)
                    .then( (response) => { 
                        alert('메뉴 등록 성공'); 

                        var get_options = document.getElementById('options');
                        while(get_options.children.length > 0) {
                            get_options.removeChild(get_options.children[get_options.children.length-1]);
                        }
 
                        document.getElementById('menu_img').src ='';

                        for(let i=0; i < get_data.length; i++){
                            get_data[i].value = '';
                        }
                        get_img.value = '';

                    })
                    .catch((ex)=>{
                        console.log('failed',ex);
                    })
                }
            }
            // 등록된 이미지가 없는 경우 경고 메세지 출력
            else {
                alert('이미지 등록 해 주세요');
            }
            
        },

        // 이미지 업로드하기.
        img_upload: function(){
            var menu_img = document.getElementById("menu_img");  // 메뉴 이미지
            var reader   = new FileReader();

            // 이미지 미리보기 띄우기
            reader.onload = function() {
                menu_img.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        },

        // 카테고리 선택 창 클릭 시 호출되는 메소드. 카테고리 선택 리스트 띄우기
        click_category : function() {
            var category_list = document.getElementById('category_list');
            category_list.classList.add("active");
            category_list.style.top  = event.y + "px";
            category_list.style.left = event.x + "px";
        },

        // 카테고리 리스트를 클릭하면 호출되는 메소드
        select_finish : function() {
            var category_list = document.getElementById('category_list');
            var category      = document.getElementsByName('category')[0];
            var clicked_v     = event.target;
 
            // 직접 입력이 아닌 다른 것을 선택하면 선택 값을 카테고리 값으로 지정함.
            if(clicked_v.innerText !== '직접입력'){
                category.value = clicked_v.innerText;
            } 
            // 직접 입력 선택 시 카테고리 값 지우고 커서 이동시킴.
            else if(clicked_v.innerText === '직접입력'){
                category.value = '';
                category.focus(); 
            }
            // css 제거
            category_list.classList.remove("active");
        },

        // 옵션 값 만들기.(하위 옵션)
        create_option : function() {
            var created_h5  = document.createElement('h5');
            var created_div = document.createElement('div');
            var created_ipt = document.createElement('input');
            var get_options = document.getElementById('options');

            created_div.classList.add("option_box");
            created_h5.classList.add("option_column");
            created_ipt.classList.add("option_input"); 
            created_ipt.classList.add("values"); 

            created_h5.innerText = '옵션 값';
            created_ipt.name     = 'option_value' + option_num; option_num++;

            created_div.appendChild(created_h5);
            created_div.appendChild(created_ipt);
            get_options.appendChild(created_div);
        }
    }
}
</script>

<style>
    .header_btn{
        width: 10%;
        margin:0.5%; 
        margin-top: 1%; 
        font-size: 130%;
        float: right; 
        overflow: hidden;
    }
    h4 {
        margin-top: 7%;
        margin-bottom: 1%;
    }
    hr {
        width: 100%;
        border:1.3px solid;
    } 
    .inner_div{
        width: 30%;
        min-height: 450px; 
        background:white;
        float: left;
        margin: 1%;
        padding: 3%;  
    }
    #menu_img{
        width: 100%;
        height: 60%;    
        object-fit: contain; 
    }
    .values{
        width: 98%;
        font-size: 17px;
    }
    #img_upload_btn{
        width: 0%;
        font-size: 0px;
        opacity: 0;
        position: relative; 
    }
    label{
        color: cadetblue; 
        float:right;
        font-size: 17px;
        margin-top: 3%;
    }
    .select_category {
        position: absolute;
        display: none;
        border: 1px solid black;
        width: auto;
        text-align: center;
    }
    .select_category.active {
        display: block;
        background-color: white;
    }
    .select_category.active>ul>li {
        list-style: none;
        padding: 10px;
    }
    .select_category.active>ul>li:hover {
        background-color: lightgreen;
    }
    ul {
        margin: 0px;
        padding: 0px;
    } 
    .input_text{
        border: 0;
        border-bottom: 1px solid; 
    } 
    .option_column {
        width: 30%;
        float: left;
    }
    .option_input {
        width: 70%;
        border: 0;
        border-bottom: 1px solid; 
        float: left;
    }
    .option_box {
        width: 100%; 
        margin-top: 7%; 
        overflow: hidden;
    }
</style>
