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

-->

<template>
    <v-container fluid grid-list-md>
            <v-card>
                <v-card-title>
                    <!-- 아이디 이미지, 아이디, 사용자 국적, 공뷰 버튼 -->
                    <v-layout>
                        <v-flex xs3>사용자이미지</v-flex>
                        <v-flex xs2>{{this.userID}}</v-flex>
                        <v-flex>
                            <img src="flag">
                        </v-flex>
                    </v-layout>
                    <!-- 작성 날짜, 리뷰 좋아요 갯수 -->
                    <v-layout>
                        <v-flex>{{this.writeDate}}</v-flex>
                        <!-- 좋아요를 눌렀을 경우 하트 모양이 채워진 이미지를 출력 하도록 변경하기 -->
                        <v-flex>
                            <v-btn outline color="pink lighten-3">
                                리뷰 좋아요 갯수
                                <v-icon x-large>favorite_border</v-icon>
                            </v-btn>
                            <v-btn outline color="pink lighten-3" v-if="false">
                                <v-icon x-large>favorite</v-icon>
                            </v-btn>
                        </v-flex>
                    </v-layout>
                </v-card-title>
                <v-card-text>
                    <!-- 총점 -->
                    <v-layout align-start align-center>
                        <v-flex xs2>총점</v-flex>
                        <v-flex xs3 class="star-align">
                            <span v-for= "count in this.rating" :key="count">
                                <v-icon x-large color="yellow accent-4">star</v-icon>
                            </span>
                        </v-flex>
                    </v-layout><br>
                    <!-- 맛 -->
                    <v-layout align-start align-center>
                        <v-flex xs2>맛</v-flex>
                        <v-flex xs3 class="star-align">
                            <span v-for= "count in this.taste" :key="count">
                                <v-icon large color="yellow accent-4">star</v-icon>
                            </span>
                        </v-flex>
                    </v-layout>
                    <!-- 서비스 -->
                    <v-layout align-start align-center>
                        <v-flex xs2>서비스</v-flex>
                        <v-flex xs3 class="star-align">
                            <span v-for= "count in this.service" :key="count">
                                <v-icon large color="yellow accent-4">star</v-icon>
                            </span>
                        </v-flex>
                    </v-layout>
                    <!-- 분위기 -->
                    <v-layout align-start align-center>
                        <v-flex xs2>분위기</v-flex>
                        <v-flex xs3 class="star-align">
                            <span v-for= "count in this.mood" :key="count">
                                <v-icon large color="yellow accent-4">star</v-icon>
                            </span>
                        </v-flex>
                    </v-layout>
                    <!-- 가격 -->
                    <v-layout align-start align-center>
                        <v-flex xs2>가격</v-flex>
                        <v-flex xs3 class="star-align">
                            <span v-for= "count in this.price" :key="count">
                                <v-icon large color="yellow accent-4">star</v-icon>
                            </span>
                        </v-flex>
                    </v-layout>
                    <!-- 리뷰 내용 -->
                    <v-layout>
                        <v-flex>{{this.content}}</v-flex>
                    </v-layout>
                </v-card-text>
                <!-- 이미지 -->
                <v-card-media>
                    <v-layout justify-space-around wrap>
                        <v-flex xs4 v-if="this.image.length > 0">
                            <div class="image-div">
                                <vue-preview :slides="slide1" class="review-image"></vue-preview>
                            </div>
                        </v-flex>
                        <v-flex xs4 v-if="this.image.length > 1">
                            <div class="image-div">
                            <vue-preview :slides="slide2" class="review-image"></vue-preview>
                            </div>
                        </v-flex>
                        <v-flex xs4 v-if="this.image.length > 2">
                            <div class="image-div">
                            <vue-preview :slides="slide3" class="review-image"></vue-preview>
                            </div>
                        </v-flex>
                    </v-layout>
                </v-card-media>
            </v-card>
    </v-container>
</template>

<script>
import UserStar from './UserStar.vue';

export default {
    props : {
        // 리뷰 번호
        reviewID:{
            type: [String, Number],
            default: 0
        },
        // 사용자 아이디
        userID: {
            type: String,
            default: ""  
        },
        // 국적
        country: {
            type: String,
            default: ""
        },
        // 작성 날짜
        writeDate: {
            type: String,
            default: ""
        },
        //리뷰 좋아요
        reviewLike: {
            type: [String, Number],
            default: 0
        },
        // 총 평점
        rating: {
            type: [String, Number],
            default: 0
        },
        // 맛
        taste: {
            type: [String, Number],
            default: 0
        },
        // 서비스
        service: {
            type: [String, Number],
            default: 0
        },
        // 분위기
        mood: {
            type: [String, Number],
            default: 0
        },
        // 가격
        price: {
            type: [String, Number],
            default: 0
        },
        // 이미지배열
        image: {
            type: Array,
            default: []
        },
        // 리뷰 내용
        content: {
            type: String,
            default: ""
        },
        // 해시 태그
        hashTag: {
            type: String,
            default: ""
        },
    },
    // 컴포넌트 선언
        components: {
            'UserStar' : UserStar
        },

    data() {
        return { 
            slide1: [{
                src:  "../../images/review/" + this.image[0],
                msrc: "../../images/review/" + this.image[0],
                alt: 'picture1',
                title: 'Image1',
                w: 600,
                h: 400
                },
            ],
            slide2: [{
                src:  "../../images/review/" + this.image[1],
                msrc: "../../images/review/" + this.image[1],
                alt: 'picture2',
                title: 'Image2',
                w: 600,
                h: 400
                },
            ],

            slide3: [{
                src:  "../../images/review/" + this.image[2],
                msrc: "../../images/review/" + this.image[2],
                alt: 'picture3',
                title: 'Image3',
                w: 600,
                h: 400
                },
            ],

            starColor : "#ffd055",
            inactiveStarColor : "#ffd055",

            flag : "../../../../../../../../storage/app/public/img/flag/" + this.country + ".png",  // 국적에 맞는 깃발 이미지 주소
        }
    },

    created() {
        console.log(this.flag);
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