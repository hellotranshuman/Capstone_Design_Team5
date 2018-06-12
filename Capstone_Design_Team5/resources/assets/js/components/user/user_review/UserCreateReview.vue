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
    <v-container fluid grid-list-md>
            <v-card>  
                <v-container>
                    <!-- 아이디 이미지, 아이디, 사용자 국적, 공뷰 버튼 -->
                    <v-layout align-center>
                        <v-flex xs4 sm1>사용자이미지</v-flex>
                        <v-flex xs3 sm2>{{this.userID}}</v-flex>
                        <v-flex xs3 sm1>
                            <img v-bind:src= "flag" onmousedown="return false;">
                        </v-flex>
                    </v-layout>
                    <!-- 작성 날짜, 리뷰 좋아요 갯수 -->
                    <v-layout align-center>
                        <v-flex xs9 sm10>{{this.writeDate}}</v-flex>
                        <!-- 좋아요를 눌렀을 경우 하트 모양이 채워진 이미지를 출력 하도록 변경하기 -->
                        <v-flex xs3 sm2>
                            <v-btn flat color="pink lighten-3" v-if="!(this.reviewLikeBut)"
                            v-on:click="likeButClick">
                                <h2>{{this.reviewLikeNum}}</h2>
                                <v-icon x-large>favorite_border</v-icon>
                            </v-btn>
                            <v-btn flat color="pink lighten-3" v-if="(this.reviewLikeBut)"
                            v-on:click="likeButClick">
                                <h2>{{this.reviewLikeNum}}</h2>
                                <v-icon x-large>favorite</v-icon>
                            </v-btn>
                        </v-flex>
                    </v-layout>
                    <!-- 총점 -->
                    <v-layout align-start align-center>
                        <v-flex xs2>총점</v-flex>
                        <v-flex xs6 sm4>
                            <v-layout>
                                <v-flex xs2 sm1 class="star-align" 
                                v-for= "count in this.rating" :key="count">
                                    <v-icon x-large color="yellow accent-4">star</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-flex>                        
                        <v-spacer></v-spacer>
                    </v-layout><br>
                    <!-- 맛 -->
                    <v-layout align-start align-center v-if="(this.taste != 0)">
                        <v-flex xs2>맛</v-flex>
                        <v-flex xs6 sm4>
                            <v-layout>
                                <v-flex xs2 sm1 class="star-align" 
                                v-for= "count in this.taste" :key="count">
                                    <v-icon large color="yellow accent-4">star</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-flex> 
                    </v-layout>
                    <!-- 서비스 -->
                    <v-layout align-start align-center v-if="(this.service != 0)">
                        <v-flex xs2>서비스</v-flex>
                        <v-flex xs6 sm4>
                            <v-layout>
                                <v-flex xs2 sm1 class="star-align" 
                                v-for= "count in this.service" :key="count">
                                    <v-icon large color="yellow accent-4">star</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-flex> 
                    </v-layout>
                    <!-- 분위기 -->
                    <v-layout align-start align-center v-if="(this.mood != 0)">
                        <v-flex xs2>분위기</v-flex>
                        <v-flex xs6 sm4>
                            <v-layout>
                                <v-flex xs2 sm1 class="star-align" 
                                v-for= "count in this.mood" :key="count">
                                    <v-icon large color="yellow accent-4">star</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>
                    <!-- 가격 -->
                    <v-layout align-start align-center v-if="(this.price != 0)">
                        <v-flex xs2>가격</v-flex>
                        <v-flex xs6 sm4>
                            <v-layout>
                                <v-flex xs2 sm1 class="star-align" 
                                v-for= "count in this.price" :key="count">
                                    <v-icon large color="yellow accent-4">star</v-icon>
                                </v-flex>
                            </v-layout>
                        </v-flex>
                    </v-layout>

                    <!-- 리뷰 내용 -->
                    <v-layout>
                        <v-flex>
                            <v-layout>
                                <v-spacer></v-spacer>
                                <v-flex xs12 sm8>
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

                    <!-- 해시 태그 -->
                    <v-layout>
                        <v-flex xs6 sm6>
                            <a v-for="(tag, index) in this.hashTag" :key="index">
                                {{"#" + tag}}&nbsp;
                            </a>
                        </v-flex>
                    </v-layout>
                    <!-- 이미지 -->
                    <v-card-media>
                        <v-layout justify-space-around wrap>
                            <v-flex xs6 sm4 v-if="this.image.length > 0">
                                <div class="image-div">
                                    <vue-preview :slides="slide1" class="review-image"></vue-preview>
                                </div>
                            </v-flex>
                            <v-flex xs6 sm4 v-if="this.image.length > 1">
                                <div class="image-div">
                                <vue-preview :slides="slide2" class="review-image"></vue-preview>
                                </div>
                            </v-flex>
                            <v-flex xs12 sm4 v-if="this.image.length > 2">
                                <div class="image-div">
                                <vue-preview :slides="slide3" class="review-image"></vue-preview>
                                </div>
                            </v-flex>
                        </v-layout>
                    </v-card-media>
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
            type    : [String, Number],
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
        position: absolute;
        top: 0;
        left: 0;
        width: 130%;
        height: 130%; 
    }

    /* 별점 정렬 CSS */
    .star-align {
        text-align: left;
    }
</style>