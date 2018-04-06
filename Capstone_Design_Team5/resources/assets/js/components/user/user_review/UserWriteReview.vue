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
    <!-- fluid 속성(태그 폭 전체 적용) 적용 여부 생각해 보기 -->
    <b-container>
         <!-- 상단바 -->
        <b-row>
            <b-col class="writeReview-header">
                <b-navbar class="fontColor-White">
                    <b-row>
                        <b-col sm="10" md="10"><b-navbar-brand>리뷰 작성하기</b-navbar-brand></b-col>
                        <b-col sm="auto" md="auto">
                            <!-- 페이지 이동 태그 + 등록 버튼 -->
                            <router-link to="/review">
                                <button class="btn btn-outlined btn-white" @click= "sendReviewData">
                                등록
                                </button>
                            </router-link>
                        </b-col>
                    </b-row>
                </b-navbar>
            </b-col>
        </b-row>
        <b-row>
            <!-- 별점 -->
            <b-col>
                총점
                <UserReviewStarRating></UserReviewStarRating>
            </b-col>
        </b-row>
        <!-- 구분 -->
        <hr><br>
        <!-- 별점 상세평가 -->
        <b-row>
            <b-col>
                    <b-btn v-b-toggle.detailRate class="m-1">상세평가</b-btn>
                    <b-collapse visible id="detailRate">
                        <b-card>
                            <!-- 맛 -->
                            <b-row>
                                <b-col class="rating-category-position"><h3>맛</h3></b-col>
                                <b-col class="rating-star-position"><UserReviewStarRating></UserReviewStarRating></b-col>
                            </b-row>
                            <!-- 서비스 -->
                            <b-row>
                                <b-col class="rating-category-position"><h3>서비스</h3></b-col>
                                <b-col class="rating-star-position"><UserReviewStarRating></UserReviewStarRating></b-col>
                            </b-row>
                            <!-- 분위기 -->
                            <b-row>
                                <b-col class="rating-category-position"><h3>분위기</h3></b-col>
                                <b-col class="rating-star-position"><UserReviewStarRating></UserReviewStarRating></b-col>
                            </b-row>
                            <!-- 가격 -->
                            <b-row>
                                <b-col class="rating-category-position"><h3>가격</h3></b-col>
                                <b-col class="rating-star-position"><UserReviewStarRating></UserReviewStarRating></b-col>
                            </b-row>
                        </b-card>
                    </b-collapse>
            </b-col>
            <!-- 구분 -->
            <hr><br>
            <b-row>
                <b-col>
                    <!-- 리뷰 텍스트 -->
                    <b-form-textarea id="textarea" v-model= "reviewContents" placeholder="리뷰 작성" 
                    :rows="7" :max-rows="6">
                    </b-form-textarea>
                </b-col>
                <b-col>
                    <!-- 태그 -->
                    <InputTag 
                    v-bind:placeholder  = 'tagPlaceholder' 
                    v-bind:limit        = 'tagLimit' 
                    v-bind:tags.sync    = 'tagsArray'>
                    </InputTag>  

                </b-col>
            </b-row>
            <!-- 구분 -->
            <hr><br>
            <!-- 이미지 -->
            <b-row>
                <b-col class="image-position">
                    <PictureInput ref="firstImg" @change="onChange" 
                    width="250" height="165" margin="16" radius="10" 
                    accept="image/*" size="10" buttonClass="btn"
                    :customStrings="{upload: '기다려 주세요', drag: '사진 등록'}">
                    </PictureInput>
                </b-col>

                <b-col class="image-position">
                    <PictureInput ref="secondImg" @change="onChange" 
                    width="250" height="165" margin="16" radius="10" 
                    accept="image/*" size="10" buttonClass="btn"
                    :customStrings="{upload: '기다려 주세요', drag: '사진 등록'}">
                    </PictureInput>
                </b-col>

                <b-col class="image-position">
                    <PictureInput ref="thirdImg" @change="onChange" 
                    width="250" height="165" margin="16" radius="10" 
                    accept="image/*" size="10" buttonClass="btn"
                    :customStrings="{upload: '기다려 주세요', drag: '사진 등록'}">
                    </PictureInput>
                </b-col>
            </b-row>
        </b-row>
        <!-- 구분 -->
        <hr><br>
    </b-container>
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
        onChange (image) {
            console.log('New picture selected!')

            if (image) {
                console.log('Picture loaded.')
                this.image = image
            } else {
                console.log('FileReader API not supported: use the <form>, Luke!')
            }
        },

        // 리뷰 관련 데이터를 전송하는 함수
        sendReviewData (){
            // starRating를 class명으로 가지는 별점 항목 엘리먼트를 배열로 가지고옵니다.
            var starArr = document.getElementsByClassName("starRating");
            // 별점 항목의 점수값을 배열에 저장합니다.
            starArr = [starArr[0].innerHTML, starArr[1].innerHTML, starArr[2].innerHTML,starArr[3].innerHTML,starArr[4].innerHTML];

            var reviewImg = document.getElementsByClassName("picture-preview");

            let settings = { headers: {'content-type': 'multipart/form-data'}};

            // 첫번째 이미지 FormData 형식으로 변환
            let firstImgFile = this.$refs.firstImg.file;
            let firstImgData = new FormData();
            firstImgData.append('firstImgFile', firstImgFile, firstImgFile.name);
            firstImgData.append('firstTitle', this.title);

            // 두번째 이미지 FormData 형식으로 변환
            let secondImgFile = this.$refs.secondImg.file;
            let secondImgData = new FormData();
            secondImgData.append('secondImgFile', secondImgFile, secondImgFile.name);
            secondImgData.append('secondTitle', this.title);

            // 세번째 이미지 FormData 형식으로 변환
            let thirdImgFile = this.$refs.thirdImg.file;
            let thirdImgData = new FormData();
            thirdImgData.append('thirdImgFile', thirdImgFile, thirdImgFile.name);
            thirdImgData.append('thirdTitle', this.title);


            console.log('test1 : ' + firstImgData);
            console.log('test2 : ' + secondImgData);
            console.log('test3 : ' + thirdImgData);


            // axios http 라이브러리
            axios.post('/review/writeReview', {
                starArr        : starArr,                       // 별점값 배열 (인덱스번호0부터 총점, 맛, 서비스, 분위기, 가격 순)
                reviewContents :this.reviewContents,     // 리뷰 텍스트 값
                tagsArray      : this.tagsArray,             // 태그값 배열

                // 이미지의 경우 이미지가 등록되어 있지 않으면 전달 되지 않음, 등록되어 있는 경우에만 전달됨
                 image1        : firstImgData,
                 image2        : secondImgData,
                 image3        : thirdImgData
            }, settings).then(function (response) {
                alert(response.data.content);
            });
        }
    },
}
</script>

<style>
    .writeReview-header {
        background-color: #353535;    
        font-weight: bold;
        font-size: 1em;
    }
    .btn-outlined.btn-white {
        background: none;
        border: 3px solid #ffffff;
        color: #ffffff;
        
        border-radius: 1em
    }
    .btn-outlined.btn-white:hover,
    .btn-outlined.btn-white:active {
        color: #353535;
        background: #ffffff;
    }

    /************************************************************
        ↑는 버튼 관련 CSS
        ↓는 그 밖의 CSS     
    ************************************************************/

    /* 별점 평가 항목 배치위치 CSS */
    .rating-category-position {
        width: 20%;
        margin-left: 10%;
        float: left;
        /* margin-right: 5em; */
    }

    /* 별 배치위치 CSS */
    .rating-star-position {
        width: 30%;
        margin-left: 10%;
        float: left;
    }

    /* 사진등록 이미지 배치위치 CSS */
    .image-position {
        width: 30%;
        margin-left: 3%;
        float: left;
    }
</style>