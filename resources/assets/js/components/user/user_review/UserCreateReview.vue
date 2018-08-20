<!-- 
※ 현재 페이지 참고사항

1. DB에 저장된 리뷰를 가지고 와서 저장된 리뷰별로 출력하는 페이지;

2. 받아야 하는 데이터
    2-1. 리뷰내용
    2-2. 해시 태그
    2-3. 작성날짜
    2-4. 총 평점
    2-5. 맛
    2-6. 서비스
    2-7. 분위기
    2-8. 가격
    2-9. 작성자 (작성자 이미지가 있을 경우 그것도)
    2-10. 작성자 국적 (필요시 국기 이미지)
    2-11. 리뷰 좋아요 갯수
    2-12. 리뷰 이미지

3. 남은 작업
    3-1. 리뷰 좋아요를 누른 리뷰인지 구분할 수 있는 값이 오면 그것에 맞게 처음 버튼 모양 출력시키기
    3-2. 리뷰 좋아요를 누르면 숫자 1증가, 리뷰 좋아요를 취소하면 1감소 
        이때 [증가 또는 감소 여부], [리뷰 번호]를 post로 전달

-->

<template>
    <v-container  grid-list-md class="ma-0 pt-1">
            <v-card class="pa-0 ma-0">  
                <v-container class="align-center content-bg">
                    <v-layout class="review-card-style">
                        <v-flex>
                            <!-- 아이디 이미지, 아이디, 사용자 국적, 공뷰 버튼 -->
                            <v-layout>
                                <v-flex xs7 sm6>
                                    <v-layout align-center class="pa-0 ma-0">
                                        <!-- 국기 -->
                                        <v-flex xs3 sm2 class="pa-0 ma-0">
                                            <img v-bind:src= "flag" onmousedown="return false;">
                                        </v-flex>
                                        <!-- 사용자명 -->
                                        <v-flex xs6 sm8 class="headline">{{this.userID}}</v-flex>
                                        <v-spacer></v-spacer>
                                    </v-layout>
                                    <hr class="review-hr-line">
                                </v-flex>
                                <!-- 작성 날짜 -->
                                <v-flex xs5 sm6>
                                    <v-layout align-center class="pa-0 ma-0">
                                        <v-flex>
                                            <v-layout>
                                                <v-flex class="subheading review-title-font">{{ this.registrationData }}</v-flex>
                                            </v-layout>
                                            <v-layout>
                                                <v-flex class="caption review-font-color">
                                                    {{this.writeDate}}
                                                </v-flex>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                    <hr class="review-hr-line">
                                </v-flex>
                            </v-layout>

                            <!-- 좋아요 -->
                            <v-layout>
                                <v-spacer></v-spacer>
                                <!-- 좋아요를 눌렀을 경우 하트 모양이 채워진 이미지를 출력 하도록 변경하기 -->
                                <v-flex xs5 sm4>
                                    <v-btn flat color="pink lighten-3" v-if="!(this.reviewLikeBut)" v-on:click="likeButClick">
                                        {{this.reviewLikeNum}}
                                        <v-icon large>favorite_border</v-icon>
                                    </v-btn>
                                    <v-btn flat color="pink lighten-3" v-if="(this.reviewLikeBut)" v-on:click="likeButClick">
                                            {{this.reviewLikeNum}}
                                        <v-icon large>favorite</v-icon>
                                    </v-btn>
                                </v-flex>
                            </v-layout>

                            <!-- 여기서 부터 점수  -->
                            <!-- 총점 -->
                            <v-layout align-center class="mt-3">
                                <v-flex xs3 class="display-1 review-title-font">{{ this.totalRate }}</v-flex>
                                <v-flex xs5 sm4>
                                    <v-layout>
                                        <v-flex xs2 sm2 class="star-align" 
                                        v-for= "count in this.rating" :key="count">
                                            <v-icon x-large color="orange lighten-1">star</v-icon>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>   
                            </v-layout>
                            <hr class="review-hr-line">

                            <!-- 맛, 서비스, 분위기, 가격 점수 -->
                            <v-layout class="mt-3">
                                <v-flex>
                                    <!-- 맛, 서비스 -->
                                    <v-layout>
                                        <v-flex xs5>
                                            <!-- 맛 -->
                                            <v-layout align-center v-if="(this.taste != 0)">
                                                <v-flex xs5 class="review-font-color">{{ this.tasteRate }}</v-flex>
                                                <v-flex xs6 sm5>
                                                    <v-layout>
                                                        <v-flex xs2 sm1 class="star-align" 
                                                        v-for= "count in this.taste" :key="count">
                                                            <v-icon small color="orange lighten-1">star</v-icon>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex> 
                                            </v-layout>
                                        </v-flex>
                                        <v-flex xs5>
                                            <!-- 서비스 -->
                                            <v-layout align-center v-if="(this.service != 0)">
                                                <v-flex xs6 class="review-font-color">{{ this.serviceRate }}</v-flex>
                                                <v-flex xs6 sm5>
                                                    <v-layout>
                                                        <v-flex xs2 sm1 class="star-align" 
                                                        v-for= "count in this.service" :key="count">
                                                            <v-icon small color="orange lighten-1">star</v-icon>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex> 
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>

                                    <!-- 분위기, 가격 -->
                                    <v-layout class="my-2">
                                        <v-flex xs5>
                                            <!-- 분위기 -->
                                            <v-layout align-center v-if="(this.mood != 0)">
                                                <v-flex xs5 class="review-font-color">{{ this.moodRate }}</v-flex>
                                                <v-flex xs6 sm5>
                                                    <v-layout>
                                                        <v-flex xs2 sm1 class="star-align" 
                                                        v-for= "count in this.mood" :key="count">
                                                            <v-icon small color="orange lighten-1">star</v-icon>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                            </v-layout>

                                        </v-flex>
                                        <v-flex xs6>
                                            <!-- 가격 -->
                                            <v-layout align-center v-if="(this.price != 0)">
                                                <v-flex xs5 class="review-font-color">{{ this.priceRate }}</v-flex>
                                                <v-flex xs6 sm5>
                                                    <v-layout>
                                                        <v-flex xs2 sm1 class="star-align" 
                                                        v-for= "count in this.price" :key="count">
                                                            <v-icon small color="orange lighten-1">star</v-icon>
                                                        </v-flex>
                                                    </v-layout>
                                                </v-flex>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>

                            <hr class="review-hr-line">

                            <!-- 해시 태그 -->
                            <v-layout>
                                <v-flex xs11 sm8>
                                    <a v-for="(tag, index) in this.hashTag" :key="index">
                                        {{"#" + tag}}&nbsp;
                                    </a>
                                </v-flex>
                            </v-layout>

                            <!-- 리뷰 -->
                            <v-layout class="mt-3">
                                <v-flex>
                                    <v-layout>
                                        <v-flex class="headline review-title-font">
                                            {{ this.reviewString }}
                                        </v-flex>
                                    </v-layout>
                                    <hr class="review-hr-line">

                                    <!-- 리뷰 내용 -->
                                    <v-layout>
                                        <v-flex>
                                            <v-layout>
                                                <v-flex xs11 sm8>
                                                    <v-text-field
                                                    :value="this.content"
                                                    flat
                                                    solo
                                                    multi-line
                                                    auto-grow
                                                    rows="1"
                                                    readonly>
                                                </v-text-field>
                                                </v-flex>
                                                <v-spacer></v-spacer>
                                            </v-layout>
                                        </v-flex>
                                    </v-layout>
                                </v-flex>
                            </v-layout>

                            <!-- 이미지 -->
                            <v-layout>
                                <v-flex>
                                    <v-card-media>
                                        <v-layout justify-start>
                                            <v-flex xs4 sm4 v-if="this.image.length > 0">
                                                <div class="image-div">
                                                    <vue-preview :slides="slide1" class="review-image"></vue-preview>
                                                </div>
                                            </v-flex>
                                            <v-flex xs4 sm4 v-if="this.image.length > 1">
                                                <div class="image-div">
                                                <vue-preview :slides="slide2" class="review-image"></vue-preview>
                                                </div>
                                            </v-flex>
                                            <v-flex xs4 sm4 v-if="this.image.length > 2">
                                                <div class="image-div">
                                                <vue-preview :slides="slide3" class="review-image"></vue-preview>
                                                </div>
                                            </v-flex>
                                        </v-layout>
                                    </v-card-media>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                </v-container>
            </v-card>
    </v-container>
</template>

<script>
import UserStar from './UserStar.vue';

// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

export default {
    props : {
        // 리뷰 번호
        reviewID:{
            type    : Number,
            default : 0
        },
        // 사용자 아이디
        userID: {
            type    : String,
            default : ""  
        },
        // 국적
        country: {
            type    : String,
            default : ""
        },
        // 작성 날짜
        writeDate: {
            type    : String,
            default : ""
        },
        //리뷰 좋아요 개수
        likeNum: {
            type    : Number,
            default : 0
        },
        // 리뷰 좋아요가 선택된 리뷰인지 여부
        reviewLike: {
            type    : Boolean,
            default : false
        },
        // 총 평점
        rating: {
            type    : Number,
            default : 0
        },
        // 맛
        taste: {
            type    : Number,
            default : 0
        },
        // 서비스
        service: {
            type    : Number,
            default : 0
        },
        // 분위기
        mood: {
            type    : Number,
            default : 0
        },
        // 가격
        price: {
            type    : Number,
            default : 0
        },
        // 이미지배열
        image: {
            type    : Array,
            default : []
        },
        // 리뷰 내용
        content: {
            type    : String,
            default : ""
        },
        // 해시 태그
        hashTag: {
            type    : Array,
            default : []
        },
    },
    // 컴포넌트 선언
        components: {
            'UserStar' : UserStar
        },

    data() {
        return { 
            slide1: [{
                src     :  "../../images/review/" + this.image[0],
                msrc    : "../../images/review/" + this.image[0],
                alt     : 'picture1',
                title   : 'Image1',
                w       : 600,
                h       : 400
                },
            ],
            slide2: [{
                src     :  "../../images/review/" + this.image[1],
                msrc    : "../../images/review/" + this.image[1],
                alt     : 'picture2',
                title   : 'Image2',
                w       : 600,
                h       : 400
                },
            ],

            slide3: [{
                src     :  "../../images/review/" + this.image[2],
                msrc    : "../../images/review/" + this.image[2],
                alt     : 'picture3',
                title   : 'Image3',
                w       : 600,
                h       : 400
                },
            ],

            registrationData    : '登録日',
            totalRate           : '総点',
            tasteRate           : '味',
            serviceRate         : 'サービス',
            moodRate            : '雰囲気',
            priceRate           : '値段',
            reviewString        : 'レビュー',
            reviewLikeBut : this.reviewLike,    // 리뷰 좋아요 버튼을 눌렸는지 아닌지 구분하는 값을 저장하는 변수
            reviewLikeNum : this.likeNum,       // 전달 받은 리뷰 좋아요를 받은 개수값을 변수에 저장합니다.
            starColor           : "#ffd055",
            inactiveStarColor   : "#ffd055",
            flag                : "../../images/flag/" + this.country + ".svg",  // 국적에 맞는 깃발 이미지 주소
        }
    },

    methods: {
        // 좋아요 버튼을 눌렸을 때 사용되는 함수
        likeButClick(){
            this.reviewLikeBut = !this.reviewLikeBut;
        },



        // 국적에 따라 UI의 언어를 바꾸는 함수
        languageChange() {

            if(this.$session.get('user_country') == 'Korea') {
                this.registrationData   = '작성날짜';
                this.totalRate          = '총점';
                this.tasteRate          = '맛';
                this.serviceRate        = '서비스';
                this.moodRate           = '분위기';
                this.priceRate          = '가격';
                this.reviewString       = '리뷰';
            } else if(this.$session.get('user_country') == 'China') {
                this.registrationData   = '创建日期';
                this.totalRate          = '总分';
                this.tasteRate          = '味';
                this.serviceRate        = '服务';
                this.moodRate           = '气氛';
                this.priceRate          = '价格';
                this.reviewString       = '回顾';
            } else if(this.$session.get('user_country') == 'USA') {
                this.registrationData   = 'Date';
                this.totalRate          = 'Score';
                this.tasteRate          = 'flavor';
                this.serviceRate        = 'service';
                this.moodRate           = 'mood';
                this.priceRate          = 'price';
                this.reviewString       = 'review';
            }
        }
    },

    // watch 속성은 데이터 변화를 감지해서 자동으로 특정 로직을 수행함
    watch: {
        // 리뷰 좋아요 버튼의 상태값을 나타내는 변수 reviewLikeBut의 값이 변경했을때 해당 정보를 post로 전송
        reviewLikeBut: function(){
            // this.reviewLikeBut = !this.reviewLikeBut;

            // 리뷰 좋아요 버튼을 눌려 상태값을 나타내는 변수의 값이 값이 true가 되면 
            // 리뷰 좋아요 받은 수를 1증가합니다, 반대로 취소하면 1 감소 시킵니다.
            if(this.reviewLikeBut == true)
                this.reviewLikeNum++;
            else
                this.reviewLikeNum--;

            // console.log("리뷰 좋아요버튼 상태 : ");
            // console.log(this.reviewLikeBut);
            // console.log(typeof this.reviewLikeBut);
            // console.log("리뷰 좋아요 값 : ");
            // console.log(this.reviewLikeNum);
            // console.log(typeof this.reviewLikeNum);
            // console.log("리뷰 글 번호 : ");
            // console.log(this.reviewID);

            // 리뷰id값, 리뷰 좋아요 상태를 post로 전송합니다.
            axios.post('/review/like',{
                "review_id"     : this.reviewID,        // 리뷰 id값
                "review_status" : this.reviewLikeBut    // 리뷰 좋아요 상태 (true : 누름, false : 안누름)
            }).then(function (response) {
                // alert(response.data.msg);
            }).catch(console.log('is catch'));
        }
    },

    created() {
        this.languageChange();
        // console.log('좋아요 수');
        // console.log(this.likeNum);
        // console.log(typeof this.likeNum);
        // console.log('점수');
        // console.log(this.rating);
        // console.log('맛');
        // console.log(this.taste);
        // console.log('서비스');
        // console.log(this.mood);
        // console.log('분위기');
        // console.log(this.likeNum);
        // console.log('값');
        // console.log(this.price);
    }
}
</script>

<style>
    .image-div {
        position: relative;
        width: 100%;
        height: 0;
        overflow: hidden;
        padding-bottom: 70%;            /* 가로에 맞춰서 세로 비율을 맞춤 */ 
        object-fit: contain;
        margin-bottom: 5%;

        /* border: 3px solid gray; */
    }
    .review-image { 
        position: relative;
        top: 0;
        left: 0;
        width: 125%;
        height: 125%; 
    }

    /* 별점 정렬 CSS */
    .star-align {
        text-align: left;
    }

    #user-name {
        /* font-size:  */
    }

    hr.review-hr-line {
        width: 90%;
        height: 2px;
        margin-left: 0%;
        margin-right: auto;
        background-color:#d2b07d;
        color:#d2b07d;
        border: 0 none;
    }

    .content-bg {
        background-color: #efe2bd;
        padding: 2%;
        margin: 0%;
    }

    .review-card-style {
        background-color: #fff;
    }

    .review-font-color {
        color: #9d724b;
    }

    .review-title-font {
        color : #6d4d35;
        font-weight: bold;
    }
</style>