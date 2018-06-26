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
    <v-content>
        <!-- 경고창 -->
        <v-snackbar
        :timeout="snackbarTimeout"
        :top="snackbarY === 'top'"
        :bottom="snackbarY === 'bottom'"
        :right="snackbarX === 'right'"
        :left="snackbarX === 'left'"
        :multi-line="snackbarMode === 'multi-line'"
        :vertical="snackbarMode === 'vertical'"
        v-model="snackbarCheck"
        >
            {{this.alertErrorCode}}
            <v-btn flat color="pink" @click.native="snackbarCheck = false">Close</v-btn>
        </v-snackbar>
        <v-layout>
            <v-flex>
                <!-- 상단바 -->
                <v-toolbar dark id="review-write-topBar">
                    <v-layout justify-space-between align-center>
                        <v-flex xs10 sm10>
                            <v-toolbar-title class="review-write-font">
                                리뷰 작성
                            </v-toolbar-title>
                        </v-flex>
                        <v-spacer></v-spacer>
                    </v-layout>
                    <!-- 상단바 버튼 -->
                    <v-toolbar-items>
                        <v-btn flat to="review">
                            취소
                        </v-btn>
                        <!-- 활성 등록 버튼 -->
                            <v-btn flat @click= "sendReviewData" class="review-write-font" 
                            v-if="this.nowLoading" @click.native="snackbarCheck = alertCheck">
                                등록
                            </v-btn>
                            <!-- 비활성 등록 버튼 -->
                            <v-btn flat @click= "sendReviewData" class="review-write-font" disabled
                            v-if="!(this.nowLoading)" @click.native="snackbarCheck = alertCheck">
                                등록
                            </v-btn>
                    </v-toolbar-items>
                </v-toolbar>
            </v-flex>
        </v-layout>
        <!-- 별점 시작 -->
        <v-layout>
            <v-flex>
                <v-card flat>
                    <v-card-title class="review-write-font">총점</v-card-title>
                    <v-card-text>
                        <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <!-- 별점 상세평가 -->
        <v-layout>
            <v-flex>
                <v-card flat>
                    <v-card-title class="review-write-font">상세평가</v-card-title>
                    <v-card-text>
                        맛 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-card flat>
                    <v-card-text>
                        서비스 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-card flat>
                    <v-card-text>
                        분위기 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <v-layout>
            <v-flex>
                <v-card flat>
                    <v-card-text>
                        가격 <UserReviewStarRating></UserReviewStarRating>
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
        <!-- 리뷰 텍스트 -->
        <v-card flat>
            <v-card-text>
                <v-layout>
                    <v-flex>
                        <v-text-field multi-line rows="6" row-height="6" 
                        v-model= "reviewContents" color="black" 
                        label="리뷰 입력">
                        </v-text-field>
                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>
        <!-- 태그 -->
        <v-card flat>
            <v-card-text>
                <v-layout>
                    <v-flex>
                        <InputTag @change="change"
                        v-bind:placeholder  = 'tagPlaceholder' 
                        v-bind:limit        = 'tagLimit' 
                        v-bind:tags.sync    = 'tagsArray'>
                        </InputTag>  
                    </v-flex>
                </v-layout>
            </v-card-text>
        </v-card>

        <!-- 이미지 -->
        <v-card flat>
            <v-layout row wrap>
                <v-spacer></v-spacer>
                <v-flex xs4 sm3>
                    <PictureInput ref="image1" removable @change="onChange" 
                    margin="10" radius="10" height="200" width="300"
                    accept="image/*" size="10" buttonClass="btn" :z-index="0"
                    :customStrings="setPictureString">
                    </PictureInput> 
                </v-flex>
                <v-flex xs4 sm3>
                    <PictureInput ref="image2" removable @change="onChange" 
                    margin="10" radius="10" height="200" width="300"
                    accept="image/*" size="10" buttonClass="btn" :z-index="0"
                    :customStrings="setPictureString">
                    </PictureInput> 
                </v-flex>
                <v-flex xs4 sm3>
                    <PictureInput ref="image3" removable @change="onChange" 
                    margin="10" radius="10" height="200" width="300"
                    accept="image/*" size="10" buttonClass="btn" :z-index="0"
                    :customStrings="setPictureString">
                    </PictureInput> 
                </v-flex>
                <v-spacer></v-spacer>
            </v-layout>
        </v-card>
    </v-content>
</template>

<script>
// 유저 별점 컴포넌트 import
import UserReviewStarRating from './UserReviewStarRating.vue';
// 이미지 관련 API사용, 이미지 컴포넌트 import
import PictureInput         from 'vue-picture-input';
// 해쉬태그 관련 API사용,
import InputTag             from 'vue-input-tag';

// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

export default {
    // 컴포넌트 선언
    components: {
        'UserReviewStarRating'  : UserReviewStarRating,     // 별점
        'PictureInput'          : PictureInput,             // 이미지
        'InputTag'              : InputTag                  // 태그
    },

    data () {
        return {
            reviewContents      : '',                           // 리뷰 텍스트 값
            tagsArray           : ['#Smartさしすせそ'],         // 태그값 (태그를 입력하면 입력된 값이 배열에 저장됨)
            tagPlaceholder      : "#Tag",                       // 태그 입력 알림(무엇을 입력해야 하는지 알려주는 역할)
            tagLimit            : 10,                           // 태그 제한 개수,
            shop_id             :  this.$route.params.shop_id,  // 가게 아이디
            nowLoading          : true,                         // 리뷰 작성 버튼 클릭 여부를 확인하는 변수
            setPictureString    : {upload: '사진 업로드', drag: '사진 등록', tap: '사진 등록', change: '사진 변경', 
                                remove:'사진 제거', select:'사진 선택', selected:'사진 선택 완료', 
                                fileSize :'파일 사이즈가 큽니다.', fileType :'지원하지 않는 파일입니다.', aspect:'food'},    
                                
            alertCheck          : false,                        // 경고창을 띄울지 여부를 나타내는 변수
            alertErrorCode      : "",                           // 경고창에 띄울 문장이 저장되는 변수
            snackbarCheck       : false,                        // snackbar 출력여부 확인
            snackbarY           : 'top',                        // snackbar Y축 값
            snackbarX           : null,                         // snackbar X축 값
            snackbarMode        : '',                           // snackbar mode 값
            snackbarTimeout     : 6000,                         //snackbar 지속시간
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

        change(tag){
            
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

            reviewData.append('shop_id', this.shop_id);     // shop_id 전송
            reviewData.append('imgNum', imgNum);            // 전송한 이미지 개수를 FormData에 저장
            reviewData.append('RATING',  RATING);           // 총 평점을 FormData에 저장
            reviewData.append('TASTE',   TASTE);            // 맛 점수를 FormData에 저장
            reviewData.append('SERVICE', SERVICE);          // 서비스 점수를 FormData에 저장
            reviewData.append('MOOD',    MOOD);             // 분위기 점수를 FormData에 저장
            reviewData.append('PRICE',   PRICE);            // 가격 점수를 FormData에 저장

            reviewData.append('CONTENT', this.reviewContents);  // 리뷰 텍스트를 FormData에 저장
            
            // 태그를 배열로 FormData에 저장
            for(var iCount = 0; iCount < this.tagsArray.length; iCount++){
                reviewData.append('HASHTAG[]', this.tagsArray[iCount]);
            }

            // ***** console.log 테스트, 지워도 됨 *****
            // console.log(reviewData.get('shop_id'));
            // console.log('img : ');
            // console.log(reviewData.get('imgFile1'));
            // console.log(reviewData.get('imgFile2'));
            // console.log(reviewData.get('imgFile3'));
            // console.log(reviewData.get('imgNum'));
            // console.log('////////////////');

            // console.log('RATE: ');
            // console.log(reviewData.get('RATING'));
            // console.log(reviewData.get('TASTE'));
            // console.log(reviewData.get('SERVICE'));
            // console.log(reviewData.get('MOOD'));
            // console.log(reviewData.get('PRICE'));
            // console.log('////////////////');

            // console.log('etc: ');
            // console.log(typeof reviewData.get('CONTENT'));
            // console.log(reviewData.get('HASHTAG'));
            // console.log('////////////////');
            // ***** console 테스트 끝 *****

            // 총점을 작성했는지 여부를 확인
            if(reviewData.get('RATING') != 0){
                // 리뷰 글을 작성했는지 여부를 확인
                if(reviewData.get('CONTENT') != ""){
                    // 경고창이 출력되지 안도록 false를 대입합니다.
                    this.alertCheck = false;

                    // 리뷰 작성 버튼의 활성 상태를 변경하는 함수,
                    // 즉 리뷰 작성 버튼을 누르면 중복 클릭이 안되게 합니다.
                    this.nowLoading = !this.nowLoading;

                    // 데이터 전송시 headers 타입
                    var settings = { headers: { 'content-type': 'multipart/form-data' } }

                    // axios http 라이브러리
                    axios.post('/review/writeReview', 
                        // 리뷰 관련 데이터
                        reviewData
                    , settings).then(function (response) {
                        console.log('리뷰 작성 성공!!!!!!!!');

                        var link = response.data.link;
                        window.location.href = link;
                    }
                    ).catch(
                        console.log('send review is catch'),
                    );
                } else {
                    // 경고창이 출력하도록 true를 대입합니다.
                    this.alertCheck = true;
                    // 출력할 경고 문장을 대입합니다.
                    this.alertErrorCode = "리뷰를 작성해 주세요.";
                }
            } else {
                // 경고창이 출력하도록 true를 대입합니다.
                this.alertCheck = true;
                // 출력할 경고 문장을 대입합니다.
                this.alertErrorCode = "총점을 입력해 주세요.";
            }
        }
    },
}
</script>
<style>
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

    .review-write-font {
        font-weight: bold;
    }

    #review-write-topBar {
        background-color : #9d724b;
    }
</style>