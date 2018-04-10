<!-- 
※ 현재 페이지 참고사항

1. 현재 이 페이지에는 추가적인 api 2개 사용됨
    1-1. https://github.com/alessiomaffeis/vue-picture-input : 이미지 관련 api
    1-2. https://github.com/matiastucci/vue-input-tag : 태그 관련 api
    => 둘 다 npm 의존성 설치 했는지 확인하기

2. 고칠 부분
    2-1. 태그를 입력하면 자동으로 # 생기도록 하는것
        => 급한것이 아니므로 나중에, 까먹지 말자!!
-->

<template>
    <v-container>
        <v-layout>
            <v-flex>
                <!-- 상단바 -->
                <v-toolbar flat color="grey darken-3">
                    <v-toolbar-title class="white--text">리뷰 작성하기</v-toolbar-title>
                    <v-spacer></v-spacer>
                    <v-toolbar-items class="hidden-sm-and-down">
                        <!-- 등록 버튼 -->
                        <!-- <router-link to="/userRestaurantMain/review"> -->
                                <v-btn outline large color="grey darken-4" to="/userRestaurantMain/review" @click= "sendReviewData">
                                <span class="submit-btn">등록</span>
                                </v-btn>
                        <!-- </router-link> -->
                    </v-toolbar-items>
                </v-toolbar>
            </v-flex>
        </v-layout>
        <!-- 구분 -->
        <br>
        <v-layout>
            <!-- 별점 -->
            <v-flex>
                <v-card>
                    <v-card-title>총점</v-card-title>
                    <v-card-text>
                        <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <!-- 별점 상세평가 -->
        <v-layout>
            <v-flex>
                <v-card>
                    <v-card-title>상세평가</v-card-title>
                    <v-card-text>
                        맛 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-card>
                    <v-card-text>
                        서비스 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-card>
                    <v-card-text>
                        분위기 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-card>
                    <v-card-text>
                        가격 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>


        <!-- 구분 -->
        <hr><br>
        <!-- 리뷰 텍스트 -->
        <v-layout>
            <v-flex>
                <v-text-field multi-line rows="6" row-height="6" 
                v-model= "reviewContents" color="black" 
                label="리뷰 입력">
                </v-text-field>
            </v-flex>
        </v-layout>
        
        <!-- 태그 -->
        <v-layout>
            <v-flex>
                <InputTag 
                v-bind:placeholder  = 'tagPlaceholder' 
                v-bind:limit        = 'tagLimit' 
                v-bind:tags.sync    = 'tagsArray'>
                </InputTag>  
            </v-flex>
        </v-layout>
        <!-- 구분 -->
        <hr><br>
        <!-- 이미지 -->
        <v-layout>
            <v-flex>
                <PictureInput ref="image1" @change="onChange" 
                width="250" height="165" margin="16" radius="10" 
                accept="image/*" size="10" buttonClass="btn"
                :customStrings="{upload: '기다려 주세요', drag: '사진 등록'}">
                </PictureInput>
            </v-flex>
            <v-flex>
                <PictureInput ref="image2" @change="onChange" 
                width="250" height="165" margin="16" radius="10" 
                accept="image/*" size="10" buttonClass="btn"
                :customStrings="{upload: '기다려 주세요', drag: '사진 등록'}">
                </PictureInput> 
            </v-flex>
            <v-flex>
                <PictureInput ref="image3" @change="onChange" 
                width="250" height="165" margin="16" radius="10" 
                accept="image/*" size="10" buttonClass="btn"
                :customStrings="{upload: '기다려 주세요', drag: '사진 등록'}">
                </PictureInput>
            </v-flex>
        </v-layout>
        <!-- 구분 -->
        <br>
    </v-container>
</template>

<script>
// 유저 별점 컴포넌트 import
import UserReviewStarRating from './UserReviewStarRating.vue';
// 이미지 관련 API사용, 이미지 컴포넌트 import
import PictureInput from 'vue-picture-input';
// 해쉬태그 관련 API사용,
import InputTag from 'vue-input-tag';

// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios from 'axios';

export default {
    // 컴포넌트 선언
    components: {
        'UserReviewStarRating'  : UserReviewStarRating,     // 별점
        'PictureInput'          : PictureInput,             // 이미지
        'InputTag'              : InputTag                  // 태그
    },

    data () {
        return {
            reviewContents  : '',                       // 리뷰 텍스트 값
            tagsArray       : ['#Smartさしすせそ'],     // 태그값 (태그를 입력하면 입력된 값이 배열에 저장됨)
            tagPlaceholder  : "#Tag",                   // 태그 입력 알림(무엇을 입력해야 하는지 알려주는 역할)
            tagLimit        : 10                        // 태그 제한 개수,
        }
    },

    methods: {
        //이미지 관련 메서드
        onChange(image) {
            console.log('New picture selected!')

            if (image) {
                console.log('Picture loaded.')
                this.image = image
            } else {
                console.log('FileReader API not supported: use the <form>, Luke!')
            }
        },

        // 리뷰 관련 데이터를 전송하는 함수

        sendReviewData() {
            // starRating를 class명으로 가지는 별점 항목 엘리먼트를 배열로 가지고옵니다.
            let starArr = document.getElementsByClassName("starRating");

            // 별점 항목의 점수값을 변수에 저장합니다.
            let RATING      = starArr[0].innerHTML;     // 총 평점
            let TASTE       = starArr[1].innerHTML;     // 맛
            let SERVICE     = starArr[2].innerHTML;     // 서비스
            let MOOD        = starArr[3].innerHTML;     // 분위기
            let PRICE       = starArr[4].innerHTML;     // 가격
            
            // 리뷰 관련 데이터들을 저장할 FormData를 생성합니다.
            let reviewData = new FormData();

            // 전송할 이미지 개수를 저장합니다.
            let imgNum = 0;

            // 첫번째 이미지 FormData에 저장   , (this.$refs.image1.file;, inputElements[2].files[0];)
            let imgFile1 = this.$refs.image1.file;

            // 첫번째 이미지가 등록 된 경우 FormData에 저장
            if(imgFile1 != undefined){
                reviewData.append('imgFile1', imgFile1);
                imgNum++;
            }

            // 두번째 이미지 FormData에 저장
            let imgFile2 = this.$refs.image2.file;

            // 두번째 이미지가 등록 된 경우 FormData에 저장
            if(imgFile2 != undefined){
                reviewData.append('imgFile2', imgFile2);
                imgNum++;
            }
            // 세번째 이미지 FormData에 저장
            let imgFile3 = this.$refs.image3.file;

            // 세번째 이미지가 등록 된 경우 FormData에 저장
            if(imgFile3 != undefined){
                reviewData.append('imgFile3', imgFile3);
                imgNum++;
            }

            reviewData.append('imgNum', imgNum);                // 전송한 이미지 개수를 FormData에 저장

            reviewData.append('RATING',  RATING);               // 총 평점을 FormData에 저장
            reviewData.append('TASTE',   TASTE);                // 맛 점수를 FormData에 저장
            reviewData.append('SERVICE', SERVICE);              // 서비스 점수를 FormData에 저장
            reviewData.append('MOOD',    MOOD);                 // 분위기 점수를 FormData에 저장
            reviewData.append('PRICE',   PRICE);                // 가격 점수를 FormData에 저장

            reviewData.append('CONTENT', this.reviewContents);  // 리뷰 텍스트를 FormData에 저장

            // 태그를 배열로 FormData에 저장
            for(var iCount = 0; iCount < this.tagsArray.length; iCount++){
                reviewData.append('HASHTAG[]', this.tagsArray[iCount]);
            }

            // ***** console.log 테스트, 지워도 됨 *****
            console.log('img : ');
            console.log(reviewData.get('imgFile1'));
            console.log(reviewData.get('imgFile2'));
            console.log(reviewData.get('imgFile3'));
            console.log(reviewData.get('imgNum'));
            console.log('////////////////');

            console.log('RATE: ');
            console.log(reviewData.get('RATING'));
            console.log(reviewData.get('TASTE'));
            console.log(reviewData.get('SERVICE'));
            console.log(reviewData.get('MOOD'));
            console.log(reviewData.get('PRICE'));
            console.log('////////////////');

            console.log('etc: ');
            console.log(reviewData.get('CONTENT'));
            console.log(typeof reviewData.get('HASHTAG'));
            console.log('////////////////');
            // ***** console 테스트 끝 *****
            
            // 데이터 전송시 headers 타입
            var settings = { headers: { 'content-type': 'multipart/form-data' } }

            // axios http 라이브러리
            axios.post('/dataget', 
                // 리뷰 관련 데이터
                reviewData
            , settings).then(console.log('is success')).catch(console.log('is catch'));
        }
    },
}
</script>
<style>
    /* 등록 버튼 CSS */
    .submit-btn {
        color: white;
        font: bold;
    }

     /* 별점 평가 항목 설정 CSS */
    .rating-category-text {
        font-size: 3em;
        margin-left: 10%;
    }

    /* 사진등록 이미지 배치위치 CSS */
    .image-position {
        width: 30%;
        margin-left: 3%;
        float: left;
    }
</style>