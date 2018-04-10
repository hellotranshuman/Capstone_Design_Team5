<!--
    [ 가게 정보 페이지 ]
    가게 주인이 입력한 정보, 업로드한 이미지를 바탕으로 가게 페이지를 동적으로 제작함.
--> 
<template>
    <div class="container">
        <!-- 타이틀 이미지와 가게 명이 들어갈 div -->
        <div id="title_img" class="title_frame">          
            <br>
            <div id="name_area">
                <b id="name" style="font-size:200%;"> </b>
            </div>         
         </div> <br>

        <!-- 가게 설명이 들어갈 div -->
        <div style="width:100%; ">
            <div style="width:40%; float:left; "> 
                <h2 style="font-size:200%;"> &nbsp 소개 </h2> 
            </div>
            <div style="width:40%; float:left; "> 
                <h2 id="rating" style="text-align: right;font-size:200%;">
                   방문객 평점 : &nbsp 
                </h2> 
            </div>
            <input type="button" id="reserve" value="예약하기" @click="reserve"/>
        </div> 
        
        <div id="explanation" class="frame" style="padding:2%;"> 
            가게 설명    
        </div>

        <!--                             
            갤러리 이미지가 들어갈 div 
            이미지가 6개 이하면 6개 출력, 6개 초과면 더보기 클릭 생성 border : 1px solid;
        -->
        <h2> &nbsp 갤러리 </h2> 
        <div id="gallery_div" class="frame" style="text-align:center;"> 
            <!--
            <div class="gallery"> <img src="" class="gallery_img"> </div>
            <div class="gallery"> <img src="" class="gallery_img"> </div>
            <div class="gallery"> <img src="" class="gallery_img"> </div>
            <div class="gallery"> <img src="" class="gallery_img"> </div>
            <div class="gallery"> <img src="" class="gallery_img"> </div>
            <div class="gallery"> <img src="" class="gallery_img"> </div>
            -->
        </div>

        <!-- 구글 맵스, 텍스트 주소가 출력 될 div -->
        <h2> &nbsp 주소 </h2>
        <div class="frame">        
            <div id="map"></div>

            <div id="address">
                <b class="address_values"> 상세 주소 : </b>
                <div id="dodobuken"class="address_values"></div>
                <div id="address1" class="address_values"></div>
                <div id="address2" class="address_values"></div>
            </div>
        </div>
 
        <!-- 요리 유형 출력 div -->
        <div class="frame_small">
            <div class="column"> <b>요리 유형</b> </div>
            <div id="type" class="column_value"> </div>
        </div>

        <!-- 좌석 수 출력 div -->
        <div class="frame_small"> 
            <div class="column"> <b>좌석 수</b> </div>
            <div id="seat_num" class="column_value"> </div>
        </div>

        <!-- 전화번호 출력 div -->
        <div class="frame_small">
            <div class="column"> <b>전화번호</b> </div>
            <div id="phone" class="column_value"> </div>
        </div>

        <!-- 이용 시간 출력 div -->
        <div class="frame_small">
            <div class="column"> <b>이용 시간</b> </div>
            <div class="column_value"> 
                <span> 런치 : </span> 
                <span id="lunch_open"> </span> 
                <span id="lunch_close"> ~ </span>
                <span id="lunch_lo"> ( last order : </span> <span> ) </span> <br> 
                <span> 디너 : </span> 
                <span id="dinner_open"> </span> 
                <span id="dinner_close"> ~ </span>
                <span id="dinner_lo"> ( last order : </span><span> ) </span> 
            </div>
        </div>

        <!-- 결제 방식 출력 div -->
        <div class="frame_small"> 
            <div class="column"> <b>결제 방식</b> </div>
            <div id="payment" class="column_value"> </div>
        </div>

        <!-- 기타 정보 출력 div -->
        <div class="frame_small"> 
            <div class="column"> <b>이용 안내</b> </div> 
            <div class="column_value">  
                <div id="children"   class="others"> 아이 동반 :&nbsp </div>
                <div id="pet"        class="others"> 애완 동물 동반 :&nbsp </div>
                <div id="parking"    class="others"> 주차 :&nbsp </div> <br>
                <div id="smoking"    class="others"> 흡연 :&nbsp </div>
                <div id="privateroom"class="others"> 개인실 :&nbsp </div>
            </div>
        </div> 
    </div> 
</template> 
 
<script type="text/javascript"> 
import Vue      from 'vue';
import VueAxios from 'vue-axios';
import axios    from 'axios';
import * as VueGoogleMaps from 'vue2-google-maps';

// 구글 맵스 키 값
Vue.use(VueGoogleMaps, {
    load: { 
        key: 'AIzaSyDeu-HoB1RsF5Vf0xjEvBwwCKodP8mkgWQ',    
    }
});

var restaurant_id = '13';         // 유저(관광객)가 클릭한 식당의 아이디 값. 식당의 아이디 값으로 데이터를 요청함.
var get_datas = null;           // 요청한 데이터들이 담길 변수 JSON으로 받을 예정
 
export default{
     
    created() { 
        // 값 보내기
        axios.post('/restaurant/info',restaurant_id)
        .then( (response) => {
            get_datas = response.data.restaurant;
            console.log(response.data.msg);
            console.log(get_datas);

            this.enter_data(Object.keys(get_datas));        // 데이터 바인딩
            this.geoCoder();                               // 지도 생성
            // this.enter_title();                            // 타이틀 이미지 삽입
            // this.enter_galley(get_datas.gallery_num); */      // 갤러리 이미지 출력
        })
        .catch((ex)=>{ 
            alert('왜 안대');
        })
    },
    methods : {
        // 각 공간에 해당 값들을 삽입함.
        enter_data : function(argIterator){
            for (let key of argIterator){
                // 갤러리, 타이틀 값은 걸러냄. 
                if( key.substring(0,7) !== "gallery" && key.substring(0,5) !== "title"){
                    var get_div = document.getElementById(key);

                    // 데이터 입력
                    if(get_datas[key] === 'yes'){
                        get_div.innerText += '가능';
                    } 
                    else if (get_datas[key] === 'no'){
                        get_div.innerText += '불가';
                    } 
                    else{ 
                        get_div.innerText += get_datas[key];
                    }
                } 
            }
        },

        // 타이틀 이미지 삽입하기
        enter_title : function(){
            title_div = document.getElementById('title_img');
            title_div.style.backgroundImage = "url('" + get_datas.title_img + "')";
        },

        // 갤러리에 이미지 추가하기.
        enter_galley : function(argNum){
            var gallery_div = document.getElementById('gallery_div');
            
            // 등록된 이미지가 없으면 메세지 출력 
            if(argNum == 0) {
                gallery_div.innerText = "등록된 이미지가 없습니다.";
            }
            // 등록된 이미지가 6개 이하인 경우 div와 img 생성 후 갤러리에 출력.
            else if (argNum <= 6) {
                for (let i=0; i < argNum; i++){
                    // div, img 생성
                    let createdDiv = document.createElement('div');
                    let createdImg = document.createElement('img');

                    // 생성한 div와 img에 css와 src를 추가함.
                    createdImg.src = get_datas.gallery_img + i;
                    createdImg.classList.add('gallery_img');
                    createdDiv.classList.add('gallery');

                    // 생성한 div와 img를 갤러리 div에 추가.
                    createdDiv.appendChild(createdImg);
                    gallery_div.appendChild(createdDiv);
                }
            }
            // 등록된 이미지가 6개 초과인 경우 5개 div는 그대로 이미지 출력,
            // 마지막 div를 더보기 클릭 창으로 만듬
            else if (argNum > 6) {
                for (let i=0; i < 6; i++){
                    let createdDiv = document.createElement('div');
                    createdDiv.classList.add('gallery');

                    // div 5개까지는 이미지 출력
                    if(i !== 5){
                        let createdImg = document.createElement('img');
                        createdImg.classList.add('gallery_img');
                        createdImg.src = get_datas.gallery_img + i;        
                        createdDiv.appendChild(createdImg);
                    } 
                    // 6번째 div에 더보기 버튼 생성.
                    else if (i === 5){
                        createdDiv.id        = 'show_gallery';
                        createdDiv.innerText = '더 보기';
                        createdDiv.onclick   = this.show_gallery;
                    }
                    // 갤러리 div에 생성한 div 추가하기
                    gallery_div.appendChild(createdDiv);
                }
            }
        },
        // 데이터 불러오기 실패
        show_gallery : function (){
            alert('아직 : 갤러리 보여주기');
        },
        // 예약하기
        reserve : function (){
            alert('아직 : 예약하기');
        },
        geoCoder : function () { 
            var map      = new google.maps.Map(document.getElementById('map'), {zoom: 18}); // 구글 맵스 생성
            var address  = get_datas.dodobuken + get_datas.address1 + get_datas.address2;       // 사장이 입력한 주소 값 더하기
            var geocoder = new google.maps.Geocoder();                                      // 지오 코더 
            
            // 지오 코드 실행 : 텍스트 주소로 해당 주소 경위도 구하기.
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == 'OK') {
                    map.setCenter(results[0].geometry.location);    // 지도 중앙 값 설정
                    var marker = new google.maps.Marker({           // 마크 설정
                        map: map,
                        position: results[0].geometry.location
                    });
                } else {
                    alert('Geocode was not successful for the following reason: ' + status);
                }
            });
        }

    }
};
</script> 

<style> 
    .frame {
        width: 100%; 
        border-top: 1px solid;
        font-size: 180%;
        color: #6E6E6E;
        display:inline-block;       /* 안에 들어올 요소의 크기에 div를 맞춤.*/
        margin-bottom: 5%; 
    }   
    .frame_small {
        width: 100%;  
        height: auto;
        border-top: 1px solid;    
        font-size: 180%; 
        padding-top: 1%;
        color: #6E6E6E;
        margin-bottom: 3%; 
        display:inline-block;       /* 안에 들어올 요소의 크기에 div를 맞춤.*/
    } 
    .title_frame {
        width: 100%;   
        font-size: 180%;
        display:inline-block;       /* 안에 들어올 요소의 크기에 div를 맞춤. */
        margin-bottom: 5%; 
    }   
    #title_img{
        background-size: 100% 100%;
        padding-top: 5%;
        padding-bottom: 5%;
        padding-left: 30%;
        padding-right: 5%;         
    }
    #name_area { 
        background: black;
        color: white; 
        text-align: center;
        opacity: 0.6;
        display:inline-block;       /* 안에 들어올 요소의 크기에 div를 맞춤.*/
    }
    #reserve {
        width: 15%;
        height: 50px;
        float: left;
        margin-left: 3%;
        font-size: 200%;
    }
    .gallery{
        width: 31%; 
        min-height: 250px;
        float: left;
        margin: 1%;   
    }
    .gallery_img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        position: relative; 
        border: 1px solid;
    }
    #show_gallery {
        text-align: center;
        padding: 5%;
        font-size: 200%;
        border: 1px solid;
    }
    .column{
        width: 20%;
        text-align: center;
        float: left;  
        font-size: 120%; 
        position: relative;
    }
    .column_value{
        width: 80%;
        float: left;  
        padding: 3px; 
        position: relative;
    }
    #map {
        width: 100%;
        height: 400px;
        border: 1px solid;
        margin-top: 1%;
    }
    #address { 
        display:inline-block;      /*  안에 들어올 요소의 크기에 div를 맞춤. */
        margin-top: 1%; 
        margin-left: 3%;
    } 
    .address_values{ 
        display:inline-block;       /* 안에 들어올 요소의 크기에 div를 맞춤.*/
        margin-right: 3px; 
        
    }
    .others{
        display:inline-block;       /* 안에 들어올 요소의 크기에 div를 맞춤.*/
        margin-right: 3%; 
    } 
    #pop_up {

    }
</style>
