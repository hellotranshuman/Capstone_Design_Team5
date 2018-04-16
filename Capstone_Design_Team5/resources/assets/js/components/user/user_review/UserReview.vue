<!-- 
※ 현재 페이지 참고사항

1. 작성된 리뷰를 보는 페이지, 리뷰기능의 메인페이지에 해당
2. 작성일, 인기, 국가 3개로 정렬


문제점 
1. 국적, 사용자 이미지 데이터 현재 저장하는거 및 보내는거 미구현 상태
2. 해쉬태그, 이미지 저장은 되지만 보내지는거 미구현


-->

<template>
    <transition name="fade">
        <v-container grid-list-md text-xs-center>
            <v-layout>
                <!-- 리뷰 작성 버튼 -->
                <v-flex>
                    <v-btn outline color="red lighten-2" to="writeReview" block>리뷰 작성</v-btn>
                </v-flex>
            <!-- SNS 공유 -->
            </v-layout>
            <v-layout>
                <v-flex>
                    <social-sharing v-bind:url= "url" inline-template>
                        <v-layout>
                            <v-flex>
                                <network network="facebook">
                                    <img src= "../../../../../../storage/app/public/img/sns/facebook.png" class="snsMark">
                                </network>
                            </v-flex>
                            <v-flex>
                                <network network="twitter">
                                    <img src= "../../../../../../storage/app/public/img/sns/twitter.png" class="snsMark">
                                </network>                                
                            </v-flex>
                            <v-flex>
                                <network network="weibo">
                                    <img src= "../../../../../../storage/app/public/img/sns/weibo.png" class="snsMark">
                                </network>
                            </v-flex>
                        </v-layout>         
                    </social-sharing>
                </v-flex>
            </v-layout>
            <!-- 구분 -->
            <br><br>
            <v-layout>
                <v-flex justify-space-between>
                    <!-- 리뷰 정렬 -->
                    <v-tabs centered color="grey lighten-5" slider-color="pink lighten-1">
                        <v-tab class="review-arrayBar-font">작성일순</v-tab>
                        <v-tab class="review-arrayBar-font">인기순</v-tab>
                        <v-tab class="review-arrayBar-font">국가순</v-tab>
                    </v-tabs>
                </v-flex>
            </v-layout>
            <br><br>
            
            <!-- 리뷰 내용 출력 -->
            <v-layout>
                <v-flex>
                    <h1>평점 : {{this.totalRating}}</h1>
                <hr>
                </v-flex>
                
            </v-layout>
            <v-layout>
                <v-flex>
                    리뷰 출력
                    <!-- 리뷰 갯수 만큼 반복 -->
                    <!--  :image2="reviewData['image2']['filename']" :image3="reviewData['image3']['filename']" -->
                    <ul>
                        <li v-for= "reviewData in reviewDataList" :key="reviewData['id']" v-if="reviewData['id']">
                            <UserCreateReview :userID="reviewData['name']" :reviewID="reviewData['id']" 
                            :country="reviewData['country']" :writeDate="reviewData['reg_date']" 
                            :reviewLike="reviewData['reviewLike']" :rating="reviewData['rating']" 
                            :taste="reviewData['taste']" :service="reviewData['service']" :mood="reviewData['mood']"
                            :price="reviewData['price']" :image="reviewData['image']" 
                            :content="reviewData['content']" hashTag="" >
                            </UserCreateReview>
                        </li>
                    </ul>
                </v-flex>
            </v-layout>
        </v-container>
    </transition>
</template>

<script>
// 유저 리뷰 출력 컴포넌트 import
import UserCreateReview from './UserCreateReview.vue';

// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios from 'axios';

export default {
    components : {
        'UserCreateReview' : UserCreateReview
    },

    data() {
        return {
            shop_id          : this.$route.params.shop_id,                            // 식당 아이디를 저장하는 변수
            reviewDataList  : [],                         // DB에서 가져온 리뷰 데이터목록이 저장되는 배열
            reviewImgList   : [],                         // 이미지명이 들어가는 배열
            url             : "https://www.naver.com/",     // 리뷰를 하는 페이지 URL
            totalRating     : 0,                            // 가게별 평균 평점
        }
    },

    methods: {
        // 반올림 함수
        round(number, precision) {
            var numArray = 0;

            if(number != null){
                var shift = function (number, precision, reverseShift) {
                if (reverseShift) {
                    precision = -precision;
                }  
                numArray = ("" + number).split("e");
                return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
                };
            return shift(Math.round(shift(number, precision, false)), precision, true);
            }

            return 0;
        },

        // 리뷰 데이터 값과 이미지 값을 분리하는 메서드
        arrayClassification(array){
            // 전달받은 전테 데이터배열의 길이만큼 반복
            for(var iCount = 0; iCount < array.length; iCount++){
                // filename을 key값으로 가지는 이미지값이 왔을때 
                // reviewImgList배열에 해당인덱스 이후부터 끝까지의 배열을 모두 저장합니다.
                if(array[iCount]['filename']){
                    this.reviewImgList = array.splice(iCount, array.length - iCount);
                }
            }
        },

        // 리뷰 데이터 값을 가지는 배열의 하나하나에 해당하는 이미지 값을 추가하는 메서드
        arrayPushImg(dataArr, ImgArr){
            var review_id = null;

            // [ _ ] 언더바를 기준으로 문자열을 분리합니다.
            for(var iCount = 0; iCount < ImgArr.length; iCount++){
                review_id = ImgArr[iCount]['filename'].split('_');

                // 이미지가 포함되는 리뷰 id를 이미지배열에 저장합니다.
                this.reviewImgList[iCount]['id'] = parseInt(review_id[0]);
                this.reviewImgList[iCount]['imgNum'] = parseInt(review_id[2]);
            }

            // 리뷰 데이터에 이미지 데이터를 저장
            for(var iCount = 0; iCount < this.reviewDataList.length; iCount++){
                var imageArr = [];  // 리뷰별로 이미지를 저장할 배열




                // 리뷰 데이터 배열의 id와 리뷰 이미지 배열의 id가 일치할때 리뷰 이미지 배열을 리뷰 데이터 배열안에 넣습니다.
                for(var jCount = 0; jCount < this.reviewImgList.length; jCount++){
                    this.reviewDataList[iCount]["image"] = []; // image를 key로 배는 배열 생성

                    if(this.reviewDataList[iCount]['id'] === this.reviewImgList[jCount]['id']){
                        imageArr.push(this.reviewImgList[jCount]["filename"]);
                    }
                     this.reviewDataList[iCount]["image"] = imageArr;
                }
            }
        }
    },

    // 라이프 사이클의 created 단계, DB에서 작성되어 있는 리뷰 데이터를 가지고 옵니다.
    created() {
        console.log("@@@@@@@@@@@@@@@@@@@@@@@@@");

        // Add shop_id in shopData
        var shopData = new FormData();
        shopData.append('shop_id', this.shop_id);

        // axios http 라이브러리 with Send shopData
        axios.post('/review', shopData).
        then((response)=>{

            console.log("-----review value get-----");
            console.log(response.data['review']);
            // 리뷰 좋아요 데이터
            console.log("-----review like get-----");
            console.log(response.data.reviewLike);
            // 해시태그
            console.log("-----hashtag get-----");
            console.log(response.data.hashTag);

            // reviewDataList변수에 리뷰 데이터목록을 저장합니다.    Object.keys(배열);
            this.reviewDataList = response.data['review'],

            // 리뷰 평점
            this.totalRating = this.reviewDataList.shift(),

            // 소수점 셋째자리에서 반올림 (둘째짜리까지 출력되도록)
            this.totalRating = this.round(this.totalRating['totalRating'], 2),

            // arrayClassification메서드를 호출하여 리뷰 데이터 값과 이미지 값을 분리
            this.arrayClassification(this.reviewDataList),

            // arrayPushImg메서드를 호출하여 리뷰 데이터 값을 가지는 배열에 해당하는 이미지 값을 추가
            this.arrayPushImg(this.reviewDataList, this.reviewImgList),

            // console.log 출력
            console.log("----- 최종 처리 배열 값  -----"),
            console.log(this.reviewDataList)
        }).catch(console.log('Oh my god!!, Failed'));
    }
    
}
</script>

<style>
    /* ul 태그 CSS */
    ul {
        list-style: none;
    }

    /* SNS 마크 이미지 CSS */
    .snsMark {
        width: 50px;
        height: 50px;
        cursor: pointer;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }

    /* 리뷰 정렬 바 CSS */
    .review-arrayBar-font {
        font-size: 2em;
        font-weight: bold;   
        width: 100%;
        height: 100;
    }

    /* 링크를 클릭하려고 마우스를 가져갔을 때 */
    a:hover { 
        color: #FF6666; 
        text-decoration: none;
    }


</style>