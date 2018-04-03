<!--
    [ 가게 정보 입력 페이지 ]
    가게 사장이 가게 정보 입력하면 입력 받은 정보들을 서버 딴으로 보냄.

     이미지 파일 백엔드로 보내기 
-->
<template>
    <div class="container" style="border:1px solid"> 
    <br>
    <form id="upload_info" enctype="multipart/form-data" action="test" method="get">
         <div class="frame">
            <h1 style="font-size:60px;"> 가게 정보 입력 </h1>    
            <input type="submit" class="submit_btn" @click="save_data">
        </div> <br>
 
<!--******************************************** 가게 기본 정보 *******************************************-->       
        <h2> 가게 기본 정보</h2> 
        <div class="input_info_frame" style="border-bottom:0px; margin-bottom: 0%;">
            <div class="info_row">
                <div class="info_column">가게 명</div>
                <div class="info_value_75"> 
                    <input type="text" name="name" style="width:98%">
                </div>
            </div>

            <div class="info_row">
                <div class="info_column">가게 설명</div>
                <div class="info_value_75"> 
                    <textarea name="explanation" style="width:98%; min-height : 100px;"></textarea>
                </div>
            </div>

            <div class="info_row">
                <div class="info_column">주소</div>
                <div class="info_value_75"> 
                    <input type="text" name="address" style="width:89%;"> 
                    <input type="button" style="font-size:75%;" value="주소 찾기" @click="find_address"> 
                </div>
            </div>           
        </div>

        <div class="input_info_frame" style="border-top:0px;">
            <div class="info_row">
                <div class="info_column">업종</div>
                <div class="info_value_25"> 
                    <input type="text" name="type" style="width:98%; text-align: center;"> 
                </div>

                <div class="info_column">전화번호</div>
                <div class="info_value_25"> 
                    <input type="text" name="phone" style="width:98%; text-align: center;"> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column">결제 방법</div>
                <div class="info_value_25"> 
                    <select name="payment">
                        <option value="card">카드 가능</option>
                        <option value="cashe">현금 결제</option>
                    </select> 
                </div>

                <div class="info_column">좌석 수</div>
                <div class="info_value_25"> 
                    <input type="text" name="seat_num" style="width:70%; text-align: center;"> 석 
                </div>
            </div> 
        </div>

<!--********************************************* 영업 시간 정보 ******************************************-->
        <h2>  영업 시간 정보 </h2> 
        <div id="OperationTime" class="input_info_frame">
            <div class="info_row">
                <div class="info_column"> 런치 오픈 </div>
                <div class="info_value_25"> 
                    <!-- <input type="text" name="LunchTimeInfo" class="EnterTheTime"> 
                    : 
                    <input type="text" name="LunchTimeInfo" class="EnterTheTime"> -->
                    <!-- <timePicker format="hh:mm" class="timePicker_width"></timePicker> -->
                    <input type="time" name="lunch_open" class="timePicker"/>
                </div>

                <div class="info_column"> 디너 오픈 </div>
                <div class="info_value_25">  
                    <input type="time" name="dinner_open" class="timePicker"/>
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 런치 종료 </div>
                <div class="info_value_25">  
                    <input type="time" name="lunch_close" class="timePicker"/>
                </div>

                <div class="info_column"> 디너 종료 </div>
                <div class="info_value_25">  
                    <input type="time" name="dinner_close" class="timePicker"/>
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 런치 라스트 오더 </div>
                <div class="info_value_25">  
                    <input type="time" name="lunch_lo" class="timePicker"/>
                </div>

                <div class="info_column"> 디너 라스트 오더 </div>
                <div class="info_value_25">  
                    <input type="time" name="dinner_lo" class="timePicker"/>
                </div>
            </div>
        </div>

<!--************************************************ 기타 정보 ********************************************-->
        <h2> 기타 정보 </h2> 
        <div class="input_info_frame">
            <div class="info_row">
                <div class="info_column"> 아이 동반</div>
                <div class="info_value_25">  
                    <select name="children">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>

                <div class="info_column"> 애완동물 동반</div>
                <div class="info_value_25">  
                    <select name="pet">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 주차 공간</div>
                <div class="info_value_25">  
                    <select name="parking">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>

                <div class="info_column"> 흡연석</div>
                <div class="info_value_25">  
                    <select name="smoking">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 개인실 </div>
                <div class="info_value_25">  
                    <select name="privateroom">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>
            </div>
        </div>

<!--**************************************** 갤러리, 타이틀 이미지 등록 *************************************-->

        <h2> 이미지 등록 </h2> 
        <div class="input_info_frame">
            <div class="info_row">
                <div class="info_column"> 타이틀 이미지 <br>
                    <label for="TitleImgForm" class="upload_btn"> 이미지 업로드 </label> 
                    <input 
                        type    = "file" 
                        id      = "TitleImgForm"
                        accept  = ".png, .jpg, .jpeg" 
                        class   = "upload_btn_hidden" 
                        @change = "title_img_load"> 
                </div>
                <div class="info_value_75" >  
                    <div id="TitleDiv" style="width:95%; height:300px; border:1px solid; margin:auto; ">  
                        <img id="TitleImg">
                    </div>
                    
                </div>    
            </div>

            <div class="info_row">
                <div class="info_column"> 이미지 갤러리 <br>
                    <label for="GalleryImgForm[]" class="upload_btn"> 이미지 업로드 </label> 
                    <input 
                        type    = "file" 
                        id      = "GalleryImgForm[]" 
                        accept  = ".png, .jpg, .jpeg" 
                        class   = "upload_btn_hidden" 
                        @change = "gallery_img_load">  
                </div>
                <div id="GalleryDiv" class="info_value_75" style="min-height:100px;">  
                    <div class="gallery_div"> <img src="./null.png" alt="yet"> </div>
                    <div class="gallery_div"> <img src="./null.png" alt="yet"> </div>
                    <div class="gallery_div"> <img src="./null.png" alt="yet"> </div>      
                </div>
            </div>
        </div>
    </form>
    </div> 
</template>

<script type="text/javascript">
// import timePicker from 'vue-timepicker';
 
export default {
    // data : () => ({
    //     csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    // }),

 
    methods : {
        // 주소 찾기 메서드
        find_address : function() {
            alert("기모띠");
        },

        // 타이틀 이미지 업로드 메서드
        title_img_load : function(evnet){ 
            var titleImg = document.getElementById("TitleImg");  // 타이틀 이미지
            var reader   = new FileReader();

            reader.onload = function() {
                titleImg.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        },

        // 갤러리 이미지 업로드 메서드
        // multiple는 추 후 고려
        gallery_img_load : function(event){
            var GalleryDiv = document.getElementsByName("GalleryDiv");

            // 추가된 이미지가 3개 이하면 기존의 div 속 img src 변경,
            if(GalleryDiv.children.length === 3 && 
            GalleryDiv.children[2].children[0].alt === "yet") { 
                let i = 0; 
                while( i < GalleryDiv.children.length) {       
                    if(GalleryDiv[0].children[i].children[0].alt === "yet"){
                        var reader = new FileReader();
                        reader.onload = function() {
                            GalleryDiv[0].children[i].children[0].src = reader.result;
                        };
                        reader.readAsDataURL(event.target.files[0]);
                        GalleryDiv[0].children[i].children[0].alt = "changed";
                        break;
                    }
                    i++;
                }
            } 
            // 추가된 이미지가 3개 초과면 새 div를 추가한 후 img 추가
            else {
                var reader     = new FileReader();                  // 업로드한 파일 미리보기
                var createdDiv = document.createElement("div");     // 새 div 생성
                var createdImg = document.createElement("img");     // 새 img 생성

                reader.onload = function() {
                    createdImg.src = reader.result;
                };
                reader.readAsDataURL(event.target.files[0]);
                
                createdDiv.classList.add("gallery_div");            // css 적용
                createdImg.alt = "changed";                         // 새 img alt 속성 추가

                createdDiv.appendChild(createdImg);                 
                GalleryDiv.appendChild(createdDiv);
            }

        },
        // 입력한 데이터 저장하기
        save_data :function() {  
            var form     = document.getElementById("upload_info");
            var formdata = new FormData();
            var xhr      = new XMLHttpRequest();

            formdata.append();

            xhr.onreadystatechange = function(){
                if(xhr.readyState === 4 && xhr.status==200){
                     alert('앙저장띠');
                }
            }
            xhr.open("get",'test',true);
            xhr.send(formdata);
        }
        
    },
    components : {
    }
 
};
</script>

<style> 
select {
    width: 95%;
}  
.input_info_frame {
    width: 100%;
    margin-bottom: 5%;
    border : 1px solid;
    display: table;
}
.info_row {
    border: 1px solid;
    display : table-row;
}
.info_column {
    width: 25%;
    padding: 3px;
    font-size: 25px;
    text-align: center; 
    border: 1px solid;
    vertical-align: middle;
    background: #d8d8d8;
    color: black;
    display : table-cell;
}
.info_value_75 {
    width: 75%;
    padding: 3px; 
    font-size: 20px;
    text-align: center; 
    border: 1px solid;
    vertical-align: middle;
    display : table-cell;
}
.info_value_25 {
    width: 25%; 
    padding: 3px;
    text-align: center; 
    vertical-align: middle;
    display : table-cell;
    font-size: 20px;
    border: 1px solid;
}
.upload_btn {
    width: 60%;
    font-size: 70%;
    position: relative; 
    background: #A4A4A4;
}
.upload_btn_hidden {
    width: 0%;
    font-size: 0px;
    position: relative; 
    opacity: 0;
}
.gallery_div {
    width :30%;  
    height: 190px;
    margin: 1.5%;
    float: left;
    border :2px solid;
    position: relative;
}  
.gallery_img {
    width: 100%;
    height: 100%;
    position: relative;
    /* object-fit:fill; */
}

img {
    width: 100%;
    height: 100%;
    position: relative;
    object-fit: cover;
}
.timePicker {
    width: 98%; 
    text-align: center
}
.submit_btn{
    width:15%; height: 15%; font-size:200%; float:right;
}

</style>