<!--
    [ 가게 정보 입력 페이지 ]
    가게 사장이 가게 정보 입력하면 입력 받은 정보들을 서버 딴으로 보냄.

     이미지 파일 백엔드로 보내기 
-->
<template>
    <div class="container" style="border:1px solid"> 
    <v-container>
    <br>
    <form id="upload_info" enctype="multipart/form-data" action="/test" method="post"> 
        <div class="frame">
            <h1 style="font-size:60px;"> 가게 정보 입력 </h1>    
            <input type="button" class="submit_btn" @click="save_data" value="저장하기">
        </div> <br>
 
<!--******************************************** 가게 기본 정보 *******************************************-->       
        <h2> 가게 기본 정보</h2> 
        <div class="input_info_frame" style="border-bottom:0px; margin-bottom: 0%;">
            <div class="info_row">
                <div class="info_column">가게 명</div>
                <div class="info_value_75"> 
                    <input type="text" name="name" style="width:98%" class="send_datas"> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column">가게 설명</div>
                <div class="info_value_75"> 
                    <textarea name="explanation" style="width:98%; min-height : 100px;" class="send_datas"></textarea>
                </div>
            </div>

            <div class="info_row">
                <div class="info_column">주소</div>
                <div class="info_value_75"> 
                    <select name="dodobuken" style="width:30%; margin:1%" class="send_datas">
                        <option value="도쿄"> 도쿄 </option>
                        <option value="훗카이도" > 훗카이도 </option>
                        <option value="교코" > 교코 </option>
                        <option value="오사카" > 오사카 </option>
                        <option value="아오모리" > 아오모리 </option>
                        <option value="이와테" > 이와테 </option>
                        <option value="미야기" > 미야기 </option>
                        <option value="아키타no" > 아키타 </option>
                        <option value="야마가타" > 야마가타 </option>
                        <option value="후쿠시마" > 후쿠시마 </option>
                        <option value="이바라키" > 이바라키 </option>
                        <option value="토치기no" > 토치기 </option>
                        <option value="군마" > 군마 </option>
                        <option value="사이타마" > 사이타마 </option>
                        <option value="치바" > 치바 </option>
                        <option value="카나가와" > 카나가와 </option>
                        <option value="니가타" > 니가타 </option>
                        <option value="토야마" > 토야마 </option>
                        <option value="이시카와" > 이시카와 </option>
                        <option value="후쿠이" > 후쿠이 </option>
                        <option value="야마나시" > 야마나시 </option>
                        <option value="나가노" > 나가노 </option>
                        <option value="기후" > 기후 </option>
                        <option value="시즈오카" > 시즈오카 </option>
                        <option value="아이치" > 아이치 </option>
                        <option value="미에" > 미에 </option>
                        <option value="시가" > 시가 </option>
                        <option value="효고" > 효고 </option>
                        <option value="나라" > 나라 </option>
                        <option value="와카야마" > 와카야마 </option>
                        <option value="톳토리" > 톳토리 </option>
                        <option value="시마네" > 시마네 </option>
                        <option value="오카야마" > 오카야마 </option>
                        <option value="히로시마" > 히로시마 </option>
                        <option value="야마구찌" > 야마구찌 </option>
                        <option value="토쿠시마" > 토쿠시마 </option>
                        <option value="카가와" > 카가와 </option>
                        <option value="에히메" > 에히메 </option>
                        <option value="코치" > 코치 </option>
                        <option value="후쿠오카" > 후쿠오카 </option>
                        <option value="사가" > 사가 </option>
                        <option value="나가사끼" > 나가사끼 </option>
                        <option value="쿠마모토" > 쿠마모토 </option>
                        <option value="오이타" > 오이타 </option>
                        <option value="미야자키" > 미야자키 </option>
                        <option value="카고시마" > 카고시마 </option>
                        <option value="오키나와" > 오키나와 </option> 
                    </select> 
                    <input type="text" name="cities" style="width:30%; margin:1%" value="상세주소1" class="send_datas">
                    <input type="text" name="address" style="width:30%; margin:1%" value="상세주소2" class="send_datas">
                 </div>
            </div>           
        </div>

        <div class="input_info_frame" style="border-top:0px;">
            <div class="info_row">
                <div class="info_column">업종</div>
                <div class="info_value_25"> 
                    <input type="text" name="type" style="width:98%; text-align: center;" class="send_datas"> 
                </div>

                <div class="info_column">전화번호</div>
                <div class="info_value_25"> 
                    <input type="text" name="phone" style="width:98%; text-align: center;" class="send_datas"> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column">결제 방법</div>
                <div class="info_value_25"> 
                    <select name="payment" class="send_datas">
                        <option value="card">카드 가능</option>
                        <option value="cash">현금 결제</option>
                    </select> 
                </div>

                <div class="info_column">좌석 수</div>
                <div class="info_value_25"> 
                    <input type="text" name="seat_num" style="width:70%; text-align: center;" class="send_datas"> 석 
                </div>
            </div> 
        </div>

<!--********************************************* 영업 시간 정보 ******************************************-->
        <h2>  영업 시간 정보 </h2> 
        <div id="OperationTime" class="input_info_frame">
            <div class="info_row">
                <div class="info_column"> 런치 오픈 </div>
                <div class="info_value_25">  
                    <input type="time" name="lunch_open" class="timePicker send_datas"/>
                </div>

                <div class="info_column"> 디너 오픈 </div>
                <div class="info_value_25">  
                    <input type="time" name="dinner_open" class="timePicker send_datas"/>
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 런치 종료 </div>
                <div class="info_value_25">  
                    <input type="time" name="lunch_close" class="timePicker send_datas" />
                </div>

                <div class="info_column"> 디너 종료 </div>
                <div class="info_value_25">  
                    <input type="time" name="dinner_close" class="timePicker send_datas"/>
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 런치 라스트 오더 </div>
                <div class="info_value_25">  
                    <input type="time" name="lunch_lo" class="timePicker send_datas"/>
                </div>

                <div class="info_column"> 디너 라스트 오더 </div>
                <div class="info_value_25">  
                    <input type="time" name="dinner_lo" class="timePicker send_datas"/>
                </div>
            </div>
        </div>

<!--************************************************ 기타 정보 ********************************************-->
        <h2> 기타 정보 </h2> 
        <div class="input_info_frame">
            <div class="info_row">
                <div class="info_column"> 아이 동반</div>
                <div class="info_value_25">  
                    <select name="children" class="send_datas">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>

                <div class="info_column"> 애완동물 동반</div>
                <div class="info_value_25">  
                    <select name="pet" class="send_datas">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 주차 공간</div>
                <div class="info_value_25">  
                    <select name="parking" class="send_datas">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>

                <div class="info_column"> 흡연석</div>
                <div class="info_value_25">  
                    <select name="smoking" class="send_datas">
                        <option value="yes"> 예    </option>
                        <option value="no" > 아니오 </option>
                    </select> 
                </div>
            </div>

            <div class="info_row">
                <div class="info_column"> 개인실 </div>
                <div class="info_value_25">  
                    <select name="privateroom" class="send_datas">
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
                    <label for="TitleImgUpload" class="upload_btn"> 이미지 업로드 </label> 
                    <input 
                        type    = "file" 
                        id      = "TitleImgUpload"
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
                    <label for="GalleryImgUpload" class="upload_btn"> 이미지 업로드 </label> 
                    <input 
                        type    = "file" 
                        id      = "GalleryImgUpload"
                        accept  = ".png, .jpg, .jpeg" 
                        class   = "upload_btn_hidden" 
                        @change = "gallery_img_load"  >  
                </div>
                <div id="GalleryDiv" class="info_value_75" style="min-height:100px;">  
                    <div class="gallery_div"> <img src="./null.png" alt="yet"> </div>
                    <div class="gallery_div"> <img src="./null.png" alt="yet"> </div>
                    <div class="gallery_div"> <img src="./null.png" alt="yet"> </div>      
                </div>
            </div>
        </div>  
    </form>
    </v-container>
    </div> 
</template>

<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';

var num      = 0;                                                           // 갤러리 이미지 갯수 카운트
var formData = new FormData(document.getElementById("upload_info"));        // 입력 값들을 담아 전송함.

export default {
    methods : {
        // 타이틀 이미지 업로드 메서드
        title_img_load : function(event){
            var titleImg = document.getElementById("TitleImg");  // 타이틀 이미지
            var reader   = new FileReader();

            // 이미지 미리보기 띄우기
            reader.onload = function() {
                titleImg.src = reader.result;
            };
            reader.readAsDataURL(event.target.files[0]);
        },

        // 갤러리 이미지 업로드 메서드
        // multiple는 추 후 고려
        gallery_img_load : function(event){
            var GalleryDiv       = document.getElementById("GalleryDiv");
            var GalleryImgUpload = document.getElementById("GalleryImgUpload");
            var reader           = new FileReader(); 

            // 추가된 이미지가 3개 이하면 기존의 div 속 img src 변경,
            if(GalleryDiv.children.length === 3 && 
            GalleryDiv.children[2].children[0].alt === "yet") { 
                let i = 0; 
                while( i < GalleryDiv.children.length) {       
                    if(GalleryDiv.children[i].children[0].alt === "yet"){
                        reader.onload = function() {
                            GalleryDiv.children[i].children[0].src = reader.result;
                        };
                        GalleryDiv.children[i].children[0].alt = "changed";
                        break;
                    }
                    i++;
                }
            } 
            // 추가된 이미지가 3개 초과면 새 div를 추가한 후 img 추가
            else {
                var createdDiv = document.createElement("div");     // 새 div 생성
                var createdImg = document.createElement("img");     // 새 img 생성

                reader.onload = function() {
                    createdImg.src = reader.result;
                };
                
                createdDiv.classList.add("gallery_div");            // css 적용
                createdImg.alt = "changed";                         // 새 img alt 속성 추가

                createdDiv.appendChild(createdImg);                 // 갤러리 추가하기.          
                GalleryDiv.appendChild(createdDiv);
            }
            reader.readAsDataURL(event.target.files[0]);
            formData.append('galleryImg'+ num, GalleryImgUpload.files[0]); num++;    // 파일 저장
        },

        // 입력한 데이터 저장하기 TitleImgUpload
        save_data :function() {       
            var TitleImgUpload = document.getElementById("TitleImgUpload");       // 타이틀 input file
            var send_datas     = document.getElementsByClassName('send_datas');   // 입력 값들
             
            // 입력 값 formdata에 append 하기 
            for (let i=0; i < send_datas.length; i++){
                 formData.append(send_datas[i].getAttribute('name'), send_datas[i].value);
            }
            // 타이틀 이미지 append
            if(TitleImgUpload.files.length !== 0) { 
                formData.append( 'titleImg', TitleImgUpload.files[0] );
            }
            // 갤러리 이미지 숫자 보내기
            formData.append('num', num);

            // 콘솔창에 띄우기
            for(var pair of formData.entries()) {
                console.log(pair[0]+ ', '+ pair[1]); 
            }

            // 값 보내기
            axios.post('/owner/createRestaurant',formData)
            .then( (response) => {
                alert(response.data.msg);

                this.link = response.data.link;
                window.location.href = this.link;
            })
            .catch((ex)=>{
                console.lg('updatePhoto failed',ex);
            })

        }
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
.send_datas{}

</style>