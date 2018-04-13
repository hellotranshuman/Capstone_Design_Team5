<template>
    <div class="container" style="border:1px solid; padding-bottom: 5%;"> 
        <div style="width:95%; margin: auto;">
            <h1 style="float:left"> 카테고리 관리 </h1>
            <input type="button" id="cancel" value="취소" class="save_cancel" @click="work_cancel">
            <input type="button" id="save"   value="저장" class="save_cancel" @click="save_data">
            <hr>  
            <input type="button" id="create_HC_btn" value="상위 카테고리 만들기" @click="create_high_category">
        </div>
        <!-- 카테고리 리스트 출력 div -->
        <div id="categorys">
        </div> 
    </div>
</template>
        
<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios    from 'axios';

var user_id = '';   // 사장님 아이디 값.
var num = 0;        // 기본 카테고리 명을 입력할 때 사용할 카운트용 변수

export default {
    
    methods : {
        // 상위 카테고리
        create_high_category : function () {
            var categorys        = document.getElementById('categorys');  // 카테고리들이 들어갈 div
            var category_box     = document.createElement('div');         // 상위, 하위 카테고리를 담을 div
            var created_category = document.createElement('div');         // 상위 카테고리가 될 div  
            var created_b        = document.createElement('b');           // 앙기모띠
            var created_btns = [                                          // 카테고리에 들어갈 버튼들.
                document.createElement('input'),       
                document.createElement('input'),        
                document.createElement('input')       
            ]

            created_b.innerText = "Category" + num; num++;                  // 카테고리 초기 이름 값 설정.
            created_b.style     = 'float:left; margin-left:1%;'; 

            created_category.name = created_b.innerText + "_high";
            created_category.classList.add('high_Category');                // 카테고리에 css 추가
            created_category.prepend(created_b);                            // 첫 자식으로 넣음

            // 들어갈 버튼들 값 설정, css 추가.
            for (let i=0; i < created_btns.length; i++){                   
                created_btns[i].type = 'button';
                created_btns[i].classList.add('category_btn');

                switch(i){
                    case 0:
                        created_btns[i].value   = '삭제';
                        created_btns[i].onclick = this.delete_high_category; break;
                    case 1:
                        created_btns[i].value   = '하위 카테고리 생성';
                        created_btns[i].onclick = this.add_low_category; break;
                    case 2: 
                        created_btns[i].value   = '수정';
                        created_btns[i].onclick = this.rename_category; break;
                }
                created_category.appendChild(created_btns[i]);
            }
            // 카테고리 목록 div에 카테고리 삽입
            category_box.name = created_b.innerText;
            category_box.classList.add('box');
            category_box.appendChild(created_category);

            categorys.appendChild(category_box);
        },

        // 카테고리 이름 수정하기
        rename_category : function(event){
            var get_category   = event.target.parentNode;             // 해당 카테고리 가져오기
            var get_rename_btn = event.target                         // 수정 버튼 가져오기 
            var created_input  = document.createElement('input');     // 카테고리 명 입력 창 만들기.

            get_rename_btn.value   = "완료";                           // 수정 버튼을 완료 버튼으로 변경
            get_rename_btn.onclick = this.rename_complete;
 
            created_input.style = 'float:left; width:50%; margin-left:1%;';

            get_category.removeChild(get_category.children[0]);      // 기본 카테고리명 지우기.
            get_category.prepend(created_input);                     // 첫번째 자식으로 넣음
        }, 

        // 이름 수정 완료
        rename_complete : function(){
            var get_category = event.target.parentNode;         // 해당 카테고리 가져오기
            var get_cpt_btn  = event.target;                    // 완료 버튼 가져오기.
            var get_iptText  = get_category.children[0];        // input 태그 가져오기
            var created_b    = document.createElement('b');     // 카테고리 명 생성.
 
            created_b.innerText = get_iptText.value;                                                   
            created_b.style     = 'float:left; margin-left:1%;';
            
            get_cpt_btn.value   = "수정";                         // 완료 버튼을 수정 버튼으로 변경시킴. 
            get_cpt_btn.onclick = this.rename_category;   
 
            get_category.removeChild(get_iptText);              // input 태그 삭제.
            get_category.prepend(created_b);                    // 첫번째 자식으로 넣음
        },

        // 하위 카테고리 생성
        add_low_category : function(event){ 
            var categorys            = document.getElementById('categorys');    // 카테고리 목록 div
            var get_box              = event.target.parentNode.parentNode;      // 해당 카테고리 박스 가져오기
            var created_low_category = document.createElement('div');           // 하위 카테고리 div 생성
            var created_b            = document.createElement('b');             // 카테고리 명 입력할 b 태그
            var created_btns = [
                document.createElement('input'),
                document.createElement('input')
            ]; 

            // 들어갈 버튼들 값 설정, css 추가.
            for (let i=0; i < created_btns.length; i++){                   
                created_btns[i].type = 'button';
                created_btns[i].classList.add('category_btn');

                switch(i){
                    case 0:
                        created_btns[i].value   = '삭제';
                        created_btns[i].onclick = this.delete_low_category; break;
                    case 1:
                        created_btns[i].value   = '수정';
                        created_btns[i].onclick = this.rename_category; break; 
                }
                created_low_category.appendChild(created_btns[i]);
            }
            
            created_b.innerText = get_box.name;
            created_b.style = 'float:left; margin-left:1%;';

            created_low_category.name = get_box.name + "_low";
            created_low_category.prepend(created_b);
            created_low_category.classList.add('low_Category');

            get_box.appendChild(created_low_category);
        },
        // 클릭한 상위 카테고리 삭제 
        delete_high_category : function(){
            var clicked_high_category = event.target.parentNode;
            clicked_high_category.parentNode.parentNode.removeChild(clicked_high_category.parentNode);          // 클릭 당한 div의 부모 div에서 클릭 당한 div를 제거
        },

        // 클릭한 하위 카테고리 삭제 
        delete_low_category : function(){
            var clicked_category = event.target.parentNode;
            clicked_category.parentNode.removeChild(clicked_category);          // 클릭 당한 div의 부모 div에서 클릭 당한 div를 제거
        },

        // 카테고리 관리 저장
        save_data : function() {
            var categorys = document.getElementById('categorys');               // 카테고리 리스트 가져오기
            var cData = [];

            // 상위 카테고리 수 만큼 반복
            for (let i=0; i < categorys.children.length; i++){
                var tt = document.getElementsByName(categorys.children[i].name + '_high')[0];
                alert(categorys.children[i].children[0].name);

                // 하위 카테고리 수 만큼 반복
            }
             
            // axios.post('/test', )
            // .then( (response) => {
            //     this.result = response.data; 
            //     document.write(this.result);
            // })
            // .catch((ex)=>{
            //     console.lg( 'fail : ',ex);
            // })
        },

        // 카테고리 관리 취소
        work_cancel : function () {

        }
    },
}

</script>
<style> 
    .save_cancel{
        width: 10%;
        margin:0.5%; 
        margin-top: 1%; 
        font-size: 180%;
        float: right; 
    }
    hr {
        width: 100%;
        border:1.3px solid;
    }
    #categorys{
        width: 95%; 
        margin: auto; 
        margin-top: 1%; 
    } 
    .box {
        width: 100%;
        height: auto; 
        overflow:hidden; 
    }
    .high_Category {
        width: 100%;
        min-height: 40px;
        margin-top: 1%;
        border: 1px solid;
        position: relative;
        background-color:gainsboro;
    }
    .category_btn {
        min-width: 10%;
        margin: 0.5%;
        float: right;
        position: relative;
    }
    .low_Category {
        width: 95%;
        min-height: 40px;
        margin-top: 1%;
        border: 1px solid;
        position: relative;
        float: right;
        background-color:floralwhite;
    }
</style>
