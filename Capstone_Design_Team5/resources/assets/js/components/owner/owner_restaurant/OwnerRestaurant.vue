<!--[ 가게 정보 입력 페이지 ] 가게 사장이 가게 정보 입력하면 입력 받은 정보들을 서버 딴으로 보냄.-->
<template>
<div class="container" style="border:1px solid"><br>
<form id="upload_info" enctype="multipart/form-data" action="/test" method="post"> 
    <v-container style="width:98%; margin:auto">
        <v-layout style="overflow:hi">
            <v-flex xs10>
                <h1 style="font-size:60px;"> 가게 정보 입력 </h1>    
            </v-flex>
            <v-flex xs2>
                <v-btn dark class="submit_btn" @click="save_data">저장하기</v-btn> 
            </v-flex>
        </v-layout> <br>
 
<!--******************************************** 가게 기본 정보 *******************************************-->       
        
        <h1> 가게 기본 정보</h1> 
        <v-layout mt-1> 
            <v-flex xs12 mr-4> 
                <v-text-field label="가게명" 
                    v-model="ipt_data.name" :rules="nameRule" required 
                    prepend-icon="home"></v-text-field>
            </v-flex> 
        </v-layout> 

        <v-layout mt-1> 
            <v-flex xs12 mr-4>
                <v-text-field label="가게 설명" 
                    v-model="ipt_data.explanation" :rules="explanationRule" required
                    prepend-icon="assignment"></v-text-field>
            </v-flex> 
        </v-layout> 
         
        <v-layout mt-1> 
            <v-flex xs2 mr-4> 
                <v-select label="주소 : 도도부현" 
                    v-model="ipt_data.dodobuken" :items="ddbkList" single-line
                    prepend-icon="location_on"></v-select>
            </v-flex>   
            <v-flex xs5 mr-4> 
                <v-text-field label="상세주소1" 
                    v-model="ipt_data.cities" :rules="citiesRule" required></v-text-field> 
            </v-flex>                
            <v-flex xs5 mr-4> 
                <v-text-field label="상세주소2" 
                    v-model="ipt_data.address" :rules="addressRule" required></v-text-field> 
            </v-flex>
        </v-layout>

        <v-layout mt-1>
            <v-flex xs6 mr-4> 
                <v-text-field label="업종" 
                    v-model="ipt_data.type" :rules="typeRule" required
                    prepend-icon="local_dining"></v-text-field> 
            </v-flex>                
            <v-flex xs6 mr-4> 
                <v-text-field label="전화번호 ex) 000-000-0000" 
                    v-model="ipt_data.phone" :rules="phoneRule" required 
                    prepend-icon="phone"></v-text-field> 
            </v-flex>
        </v-layout>

        <v-layout mt-1>
            <v-flex xs6 mr-4>  
                <v-select label="결제방식"
                    v-model="ipt_data.payment" :items="paymentList" single-line
                    prepend-icon="attach_money"></v-select> 
            </v-flex>                
            <v-flex xs6 mr-4> 
                <v-text-field label="좌석 수" 
                    v-model="ipt_data.seat_num" :rules="seat_numRule" required
                    prepend-icon="airline_seat_recline_normal"></v-text-field> 
            </v-flex>
        </v-layout>

<!--********************************************* 영업 시간 정보 ******************************************-->      
       
        <br><br><h1>  영업 시간 정보 </h1> 

        <v-layout>
            <v-flex xs4 mr-4> 
                <v-text-field label="런치 오픈 ex) 00:00" 
                    v-model="ipt_data.lunch_open" :rules="lunch_openRule" required
                    prepend-icon="schedule"></v-text-field> 
            </v-flex>               
            
            <v-flex xs4 mr-4> 
                <v-text-field label="런치 종료 ex) 00:00" 
                    v-model="ipt_data.lunch_close" :rules="lunch_closeRule" required
                    prepend-icon="schedule"></v-text-field> 
            </v-flex> 

            <v-flex xs4 mr-4> 
                <v-text-field label="런치 라스트 오더 ex) 00:00" 
                    v-model="ipt_data.lunch_lo" :rules="lunch_loRule" required
                    prepend-icon="schedule"></v-text-field> 
            </v-flex> 
        </v-layout>

        <v-layout>       
            <v-flex xs4 mr-4> 
                <v-text-field label="디너 오픈 ex) 00:00" 
                    v-model="ipt_data.dinner_open" :rules="dinner_openRule" required
                    prepend-icon="schedule"></v-text-field> 
            </v-flex>    
             
            <v-flex xs4 mr-4> 
                <v-text-field label="디너 종료 ex) 00:00" 
                    v-model="ipt_data.dinner_close" :rules="dinner_closeRule" required
                    prepend-icon="schedule"></v-text-field> 
            </v-flex>    

            <v-flex xs4 mr-4> 
                <v-text-field label="디너 라스트 오더 ex) 00:00" 
                    v-model="ipt_data.dinner_lo" :rules="dinner_loRule" required
                    prepend-icon="schedule"></v-text-field> 
            </v-flex>
        </v-layout> 

<!--************************************************ 기타 정보 ********************************************-->
      
        <br><br><h1> 기타 정보 </h1> 

        <v-layout>  
            <v-flex xs6 mr-4> 
                <v-select label="아이 동반 가능"
                    v-model="ipt_data.children" :items="YesOrNo" single-line
                    prepend-icon="child_care"></v-select>
            </v-flex>                
            <v-flex xs6 mr-4> 
                <v-select label="애완동물 동반"
                    v-model="ipt_data.pet" :items="YesOrNo" single-line
                    prepend-icon="pets"></v-select> 
            </v-flex>
        </v-layout>

        <v-layout>  
            <v-flex xs6 mr-4> 
                <v-select label="주차 공간"
                    v-model="ipt_data.parking" :items="YesOrNo" single-line
                    prepend-icon="directions_car"></v-select> 
            </v-flex>                
            <v-flex xs6 mr-4> 
                <v-select label="흡연석"
                    v-model="ipt_data.smoking" :items="YesOrNo" single-line
                    prepend-icon="smoking_rooms"></v-select> 
            </v-flex>
        </v-layout>
        
        <v-layout>  
            <v-flex xs6 mr-4> 
                <v-select label="개인실"
                    v-model="ipt_data.privateroom" :items="YesOrNo" single-line
                    prepend-icon="account_box"></v-select>
            </v-flex>   
            <v-flex xs6 mr-4></v-flex>  
        </v-layout>

<!--**************************************** 갤러리, 타이틀 이미지 등록 *************************************-->
        <br><br><h1> 가게 이미지 등록 </h1> <br>

        <v-layout mt-2>
            <v-icon x-large>image</v-icon>
            <label for="TitleImgUpload" class="upload_btn"> [타이틀 이미지 업로드] </label> 
            <input type="file" id="TitleImgUpload" accept=".png, .jpg, .jpeg" 
                class="upload_btn_hidden" @change="title_img_load"> 
        </v-layout>

        <v-layout mt-2>
            <v-flex xs12>
                <v-card class="title_div" style="background-color: lightgray;">
                    <img class="img_style" id="TitleImg" > 
                </v-card>
            </v-flex>
        </v-layout> <br>

        <v-layout mt-2>
            <v-icon x-large>image</v-icon>
            <label for="GalleryImgUpload" class="upload_btn"> [갤러리 이미지 업로드] </label> 
            <input type="file" id="GalleryImgUpload" accept=".png, .jpg, .jpeg" 
                class="upload_btn_hidden" @change="gallery_img_load"> 
        </v-layout>

        <div id="gallery_div" style="width:100%; margin:auto; overflow:hidden">
            <div class="gallery_div">
                <img class="img_style">
            </div>

            <div class="gallery_div">
                <img class="img_style">
            </div>

            <div class="gallery_div ">
                <img class="img_style">
            </div>
        </div>
        <br><br><br><br>
    </v-container>
</form>
</div> 
</template>

<script type="text/javascript"> 
import VueAxios from 'vue-axios';
import axios from 'axios';

var num      = 0;                                                           // 갤러리 이미지 갯수 카운트
var formData = new FormData(document.getElementById("upload_info"));        // 입력 값들을 담아 전송함.

export default { 

    data(){
        return{
            ipt_data : [
                // 기본 정보            
                name        => null,         // 가게 명
                explanation => null,         // 가게 설명
                dodobuken   => null,         // 주소 - 도도부현
                cities      => null,         // 주소 - 상세주소1
                address     => null,         // 주소 - 상세주소2
                type        => null,         // 업종
                phone       => null,         // 전화번호
                payment     => null,         // 결제 방법
                seat_num    => null,         // 좌석 수
                
                // 영업 시간
                lunch_open   => null,        // 런치 오픈 시간
                lunch_close  => null,        // 런치 마감 시간
                lunch_lo     => null,        // 런치 라스터 오더 시간
                dinner_open  => null,        // 디너 오픈 시간
                dinner_close => null,        // 디너 마감 시간
                dinner_lo    => null,        // 디너 라스트 오더 시간

                // 기타 정보 yes or no
                children    => null,         // 아이 동반 가능 여부
                pet         => null,         // 애완 동물 동반 가능 여부
                parking     => null,         // 주차 공간 유무
                smoking     => null,         // 흡연실 유무
                privateroom => null,         // 개인실 유무
            ],  
            
            // 경고 메세지 출력
            nameRule         : [ v => !!v || '가게 명을 입력해주세요!' ],
            explanationRule  : [ v => !!v || '가게 설명을 입력해주세요!' ],
            citiesRule       : [ v => !!v || '상세주소1을 입력해주세요!' ],
            addressRule      : [ v => !!v || '상세주소2를 입력해주세요!' ],
            typeRule         : [ v => !!v || '업종을 입력해주세요!' ],
            phoneRule        : [ v => !!v || '전화번호를 입력해주세요!' ],
            seat_numRule     : [ v => !!v || '업종을 입력해주세요!' ],
            lunch_openRule   : [ v => !!v || '점심 오픈 시간을 입력해주세요!' ],
            lunch_closeRule  : [ v => !!v || '점심 종료 시간을 입력해주세요!' ],
            lunch_loRule     : [ v => !!v || '점심 라스트 오더 시간을 입력해주세요!' ],            
            dinner_openRule  : [ v => !!v || '점심 오픈 시간을 입력해주세요!' ],
            dinner_closeRule : [ v => !!v || '점심 종료 시간을 입력해주세요!' ],
            dinner_loRule    : [ v => !!v || '점심 라스트 오더 시간을 입력해주세요!' ],        
            
            // 도도부현 리스트 배열
            ddbkList : [
                { text: '東京'},    { text: '北海道'},  { text: '札幌'},    { text: '京都'},
                { text: '大阪'},    { text: '靑森'},    { text: '岩手'},    { text: '宮城'},
                { text: '秋田'},    { text: '山形'},    { text: '福島'},    { text: '茨城'},
                { text: '栃木'},    { text: '群馬'},    { text: '埼玉'},    { text: '千葉'},
                { text: '神奈川'},  { text: '新潟'},    { text: '富山'},    { text: '石川'},
                { text: '福井'},    { text: '山梨'},    { text: '長野'},    { text: '岐阜'},
                { text: '靜岡'},    { text: '愛知'},    { text: '三重'},    { text: '滋賀'},
                { text: '兵庫'},    { text: '奈良'},    { text: '和歌山'},  { text: '鳥取'}, 
                { text: '島根'},    { text: '岡山'},    { text: '廣島'},    { text: '山口'},     
                { text: '德島'},    { text: '香川'},    { text: '愛媛'},    { text: '高知'},     
                { text: '福岡'},    { text: '佐賀'},    { text: '長崎'},    { text: '熊本'},     
                { text: '大分'},    { text: '宮崎'},    { text: '鹿兒島'},  { text: '沖繩'},
            ],

            // 결제 방법
            paymentList : [{ text: '현금 결제'},{ text: '카드 결제'},{ text: '둘다 가능'}],
            
            // 기타 정보 선택 사항
            YesOrNo : [ { text: 'yes'},  { text: 'no'} ],
        }
    },

    methods : {
        // 타이틀 이미지 업로드 메서드
        title_img_load : function(evnet){ 
            let titleImg = document.getElementById("TitleImg");  // 타이틀 이미지
            let reader   = new FileReader();

            // 이미지 미리보기 띄우기
            reader.onload = function() {
                titleImg.src = reader.result; 
            };
            reader.readAsDataURL(event.target.files[0]);
        },

        // 갤러리 이미지 업로드 메서드
        gallery_img_load : function(event){
            let file        = event.target.files[0];
            let reader      = new FileReader();
            let gallery_div = document.getElementById('gallery_div');  

            // 업로드한 이미지가 3개 이하인 경우
            if(gallery_div.children[2].children[0].src == ''){ 
                for(let i=0; i < gallery_div.children.length; i++){
                    let img = gallery_div.children[i].children[0];

                    if(img.src == ''){ 
                        reader.onload = function(){
                            img.src = reader.result;
                        };
                        break;
                    }
                }
            }
            // 업로드한 이미지가 4개 이상인 경우
            else {
                let createdDiv = document.createElement("div");     // 새 div 생성
                let createdImg = document.createElement("img");     // 새 img 생성

                reader.onload = function() {
                    createdImg.src = reader.result;
                };
                
                createdDiv.classList.add("gallery_div");            // css 적용
                createdImg.classList.add("img_style");              // 새 img alt 속성 추가

                createdDiv.appendChild(createdImg);                 // 추가하기.          
                gallery_div.appendChild(createdDiv);
            }
            reader.readAsDataURL(file);
            formData.append('galleryImg'+ num, file); num++;    // 파일 저장
        }, 

        // 입력한 데이터 저장하기 TitleImgUpload
        save_data :function() {    
            let TitleImgUpload = document.getElementById("TitleImgUpload");       // 타이틀 input file 
            let iterator = Object.keys(this.ipt_data); 
 
            // 지정하지 않는 data 배열을 숫자 키값 제외시키기
            for(let key of iterator) {   
                if(isNaN(key) === true && typeof(this.ipt_data[key]) !== 'object'){ 
                    formData.append(key, this.ipt_data[key]);
                }
                else if (isNaN(key) === true && typeof(this.ipt_data[key]) === 'object'){
                    formData.append(key, this.ipt_data[key].text);
                }
            }
              
            // 타이틀 이미지 append
            if(TitleImgUpload.files.length !== 0) { 
                formData.append( 'titleImg', TitleImgUpload.files[0] );
            }
            // 갤러리 이미지 숫자 보내기
            formData.append('num', num);

            // 콘솔창에 띄우기
            for(var pair of formData.entries()) {
                console.log(pair[0]+ ': '+ pair[1]); 
            }

            // // 값 보내기
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
/* 이미지 업로드 버튼의 라벨 스타일 */
.upload_btn {
    width: 100%;
    font-size: 1.5rem;
    position: relative;  
    color:lightseagreen;
}
/* 이미지 업로드 버튼 스타일 */
.upload_btn_hidden {
    width: 0%;
    font-size: 0px;
    position: relative; 
    opacity: 0;
}
/* 타이틀 이미지 상위 card */
.title_div {
    position: relative;
    width: 100%;
    height: 0;
    overflow: hidden;
    padding-bottom: 35%;
}
/* 갤러리 이미지 상위 card */
.gallery_div {
    position: relative;
    float: left;
    margin: 1%; 
    background-color: lightgray;
    border: 1px solid lightgrey;
    width: 31%;
    height: 0;
    overflow: hidden; 
    padding-bottom: 22%; 
}
/* 타이틀, 갤러리 이미지 스타일 */
.img_style { 
    position: absolute;
    top: 0;
    left: 0;
    width: 105%;
    height: 105%; 
    object-fit: cover;
}   
/* 저장하기 버튼 스타일 */
.submit_btn{
    width:80%; height: 80%; font-size:1.5rem; 
}

</style>