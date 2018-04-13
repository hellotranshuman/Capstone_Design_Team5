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
                <h2 style="font-size:200%;">  소개 </h2> 
            </div>
            <div style="width:40%; float:left; "> 
                <h2 id="rating" style="text-align: right;font-size:200%;">
                   방문객 평점 :  
                </h2> 
            </div>
            <!-- <input type="button" id="reserve" value="예약하기" @click="reserve"/> -->

            <router-link to="/userRestaurantMain/restaurant/CustomerAddReservation">예약하기</router-link>

        </div> 
        
        <div id="explanation" class="frame" style="padding:2%;"> 
                
        </div>

        <!-- 갤러리 이미지가 들어갈 div -->
        <h2> 갤러리 </h2> 
        <div id="gallery_div" class="frame" style="text-align:center;"> 
        </div>

        <!-- 구글 맵스, 텍스트 주소가 출력 될 div -->
        <h2> 주소 </h2>
        <div class="frame">        
            <div id="map"></div>

            <div id="address">
                <b class="address_values"> 상세 주소 : </b>
                <div id="dodobuken" class="address_values"></div>
                <div id="cities"    class="address_values"></div>
                <div id="address"   class="address_values"></div>
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
                <div id="children"    class="others"> 아이 동반 : </div>
                <div id="pet"         class="others"> 애완 동물 동반 : </div>
                <div id="parking"     class="others"> 주차 : </div> <br>
                <div id="smoking"     class="others"> 흡연 : </div>
                <div id="privateroom" class="others"> 개인실 : </div>
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

var restaurant_id = '';           // 유저(관광객)가 클릭한 식당의 아이디 값. 식당의 아이디 값으로 데이터를 요청함.
var get_datas  = null;           // 요청한 데이터들이 담길 변수 JSON으로 받을 예정
var url = '';

export default{
    created() {

        // 값 보내기
        this.shop_id = this.$route.params.shop_id;
        // url = '/restaurant/' + this.shop_id + '/getInfo';

        url = '/restaurant/1/getInfo';

        axios.get(url)
        .then( (response) => {
            get_datas = response.data.restaurant;
            console.log(get_datas);

            // 데이터 바인딩-기본정보
            this.enter_data(get_datas[0]);        

            // 데이터 바인딩-평점
            this.enter_data(get_datas[1]);      
            
            // 지도 생성
            this.geoCoder(get_datas[0]);          
            
            console.log("url('" + get_datas[2].path + get_datas[2].filename + "')");
            
            // 타이틀 이미지 삽입
            this.enter_title(get_datas[2]);                             
            
            // 갤러리 이미지 출력
            this.enter_galley();       
        })
        .catch((ex)=>{
            // alert('왜 안대');
        })
    },
    methods : {
        // 각 공간에 해당 값들을 삽입함.
        enter_data : function(argArray){
            var iterator = Object.keys(argArray);

            for (let key of iterator){ 

                if(document.getElementById(key) !== null){
                    var get_div = document.getElementById(key);

                    // 데이터 입력
                    if(argArray[key] === 1){
                        get_div.innerText += '가능';
                    } 
                    else if (argArray[key] === 0){
                        get_div.innerText += '불가';
                    } 
                    else if (argArray[key] === 'card'){
                        get_div.innerText += '카드 가능';
                    } 
                    else if (argArray[key] === 'cash'){
                        get_div.innerText += '현금 결제';
                    } 
                    else{ 
                        get_div.innerText += argArray[key];
                    }
                }  
            }
        },

        // 타이틀 이미지 삽입하기
        enter_title : function(argImgArray){
            var title_div = document.getElementById('title_img');
            title_div.style.backgroundImage = "url(" + argImgArray.path + argImgArray.filename + ")";
        },

        // 갤러리에 이미지 추가하기.
        enter_galley : function(){
            var gallery_div = document.getElementById('gallery_div');
            var argNum = get_datas.length; // 넘어온 데이터 배열 갯수 :  0은 기본 데이터 , 1은 평점, 2는 타이틀 이미지 
             
            // 등록된 이미지가 없으면 메세지 출력 
            if(argNum -3 == 0) {
                gallery_div.innerText = "등록된 이미지가 없습니다.";
            }
            else {
                for (let i=3; i < argNum; i++){
                    // div, img 생성
                    let createdDiv = document.createElement('div');
                    let createdImg = document.createElement('img');

                    // 생성한 div와 img에 css와 src를 추가함.
                    createdImg.src = get_datas[i].path + get_datas[i].filename;
                    createdImg.classList.add('gallery_img');
                    createdDiv.classList.add('gallery');

                    // 생성한 div와 img를 갤러리 div에 추가.
                    createdDiv.appendChild(createdImg);
                    gallery_div.appendChild(createdDiv);
                }
            }


            // // 등록된 이미지가 6개 이하인 경우 div와 img 생성 후 갤러리에 출력.
            // else if (argNum <= 6) {
            //     for (let i=0; i < argNum; i++){
            //         // div, img 생성
            //         let createdDiv = document.createElement('div');
            //         let createdImg = document.createElement('img');

            //         // 생성한 div와 img에 css와 src를 추가함.
            //         createdImg.src = get_datas.gallery_img + i;
            //         createdImg.classList.add('gallery_img');
            //         createdDiv.classList.add('gallery');

            //         // 생성한 div와 img를 갤러리 div에 추가.
            //         createdDiv.appendChild(createdImg);
            //         gallery_div.appendChild(createdDiv);
            //     }
            // }
            // // 등록된 이미지가 6개 초과인 경우 5개 div는 그대로 이미지 출력,
            // // 마지막 div를 더보기 클릭 창으로 만듬
            // else if (argNum > 6) {
            //     for (let i=0; i < 6; i++){
            //         let createdDiv = document.createElement('div');
            //         createdDiv.classList.add('gallery');

            //         // div 5개까지는 이미지 출력
            //         if(i !== 5){
            //             let createdImg = document.createElement('img');
            //             createdImg.classList.add('gallery_img');
            //             createdImg.src = get_datas.gallery_img + i;        
            //             createdDiv.appendChild(createdImg);
            //         } 
            //         // 6번째 div에 더보기 버튼 생성.
            //         else if (i === 5){
            //             createdDiv.id        = 'show_gallery';
            //             createdDiv.innerText = '더 보기';
            //             createdDiv.onclick   = this.show_gallery;
            //         }
            //         // 갤러리 div에 생성한 div 추가하기
            //         gallery_div.appendChild(createdDiv);
            //     }
            // }
        
            // show_gallery : function (){
            //     alert('아직 : 갤러리 보여주기');
            // },
        }, 



        // 예약하기
        // reserve : function (){
        //     alert('아직 : 예약하기');
        // },



        // 구글 맵스 설정하기.
        geoCoder : function (argAddress) { 
            var map      = new google.maps.Map(document.getElementById('map'), {zoom: 18}); // 구글 맵스 생성
            var address  = argAddress.dodobuken + 
                           argAddress.cities + 
                           argAddress.address;   // 사장이 입력한 주소 값 더하기
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
        border: 1px;
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
