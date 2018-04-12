<!-- 
※ 현재 페이지 참고사항

1. 작성된 리뷰를 보는 페이지, 리뷰기능의 메인페이지에 해당
2. 작성일, 인기, 국가 3개로 정렬
-->

<template>
    <transition name="fade">
        <v-container>
            <v-layout>
                <!-- 리뷰 작성 버튼 -->
                <v-flex>
                    <v-btn outline color="red lighten-2" to="/userRestaurantMain/review/writeReview" block>리뷰 작성</v-btn>
                </v-flex>
            <!-- SNS 공유 -->
            </v-layout>
            <v-layout>
                <v-flex>
                    <social-sharing v-bind:url= "url" inline-template>
                        <v-layout>
                            <v-flex>
                                <network network="facebook">
                                    <img src= "../../../../../../public/images/review/facebook.png" class="snsMark">
                                </network>
                            </v-flex>
                            <v-flex>
                                <network network="twitter">
                                    <img src= "../../../../../../public/images/review/twitter.png" class="snsMark">
                                </network>                                
                            </v-flex>
                            <v-flex>
                                <network network="weibo">
                                    <img src= "../../../../../../public/images/review/weibo.png" class="snsMark">
                                </network>
                            </v-flex>
                        </v-layout>         
                    </social-sharing>
                </v-flex>
            </v-layout>
            <!-- 구분 -->
            <br><br>
            <v-layout>
                <v-flex>
                    <!-- 리뷰 정렬 -->
                    <v-tabs centered color="white" hide-slider>
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
                    리뷰 출력
                    <!-- 리뷰 갯수 만큼 반복 -->
                    <!-- <ul>
                        <li v-for= "reviewData in reviewDataList" :key= "reviewDataList.reviewID">
                            <UserCreateReview userID="reviewData.userID"  nationality="reviewData.nationality" 
                            writeDate="reviewData.date" reviewLike="reviewData.reviewLike"
                            rating="reviewData.rating" taste="reviewData.taste"
                            service="reviewData.service" mood="reviewData.mood"
                            price="reviewData.price" image1="reviewData.image1"
                            image2="reviewData.image2" image3="reviewData.image3"
                            content="reviewData.content" hashTag="" >
                            </UserCreateReview> 
                        </li>
                    </ul> -->
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
            shopID          : 3,       // 식당 아이디를 저장하는 변수
            reviewDataList  : null,    // DB에서 가져온 리뷰 데이터목록이 저장되는 변수
            // reviewData      : null,    // 리뷰 데이터가 저장되는 변수
            url : "https://www.naver.com/", // 리뷰를 하는 페이지 URL
        }
    },

    // 라이프 사이클의 created 단계, DB에서 작성되어 있는 리뷰 데이터를 가지고 옵니다.
    created() {
        // axios http 라이브러리
        axios.post('/review',
        {
            // 식당 id를 전송
            shopID : this.shopID
        }
        ).then((response)=>{
            // reviewDataList변수에 리뷰 데이터목록을 저장합니다.
            this.reviewDataList = response.data,

            console.log('response.data: '),
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
        color: black;
    }
</style>