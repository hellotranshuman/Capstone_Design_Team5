<!-- 
※ 현재 페이지 참고사항

1. 작성된 리뷰를 보는 페이지, 리뷰기능의 메인페이지에 해당
2. 작성일, 인기, 국가 3개로 정렬
-->

<template>
    <transition name="fade">
        <b-container fluid>
            <b-row align-h="start">
                <b-col>
                    <b-container>
                        <br><br>
                        <p>
                            <router-link to="/review/writeReview" class="btn btn-outlined btn-block btn-danger">리뷰 작성</router-link>
                        </p>    
                    </b-container>
                </b-col>
            </b-row>
            <!-- SNS 공유 -->
            <b-row>
                <b-col>
                    <social-sharing v-bind:url= "url" inline-template>
                        <b-row class="text-center">
                            <b-col>
                                <network network="facebook">
                                    <img src= "../../../../../../public/images/review/facebook.png" class="snsMark">
                                </network>
                            </b-col>
                            <b-col>
                                <network network="twitter">
                                    <img src= "../../../../../../public/images/review/twitter.png" class="snsMark">
                                </network>
                            </b-col>
                            <b-col>
                                <network network="weibo">
                                    <img src= "../../../../../../public/images/review/weibo.png" class="snsMark">
                                </network>
                            </b-col>
                        </b-row>
                    </social-sharing>
                </b-col>
            </b-row>
            <!-- 구분 -->
            <br><br>
            <b-row>
                <b-col>
                    <b-nav justified tabs class="review-arrayBar">
                        <b-nav-item>작성일 순</b-nav-item>
                        <b-nav-item>인기순</b-nav-item>
                        <b-nav-item>국가순</b-nav-item>
                    </b-nav>
                </b-col>
            </b-row>
            <br><br>
            <!-- 리뷰 내용 출력 -->
            <b-row>
                <b-col>
                    <!-- 리뷰 출력 -->
                    <ul>
                        <!-- 리뷰 갯수 만큼 반복 -->
                        <li v-for= "reviewData in reviewDataList" :key= "reviewDataList.reviewID">
                            <b-row>
                                <b-col>
                                    <UserCreateReview userID="reviewData.userID"  nationality="reviewData.nationality" 
                                    writeDate="reviewData.date" reviewLike="reviewData.reviewLike"
                                    rating="reviewData.rating" taste="reviewData.taste"
                                    service="reviewData.service" mood="reviewData.mood"
                                    price="reviewData.price" image1="reviewData.image1"
                                    image2="reviewData.image2" image3="reviewData.image3"
                                    content="reviewData.content" hashTag="" 
                                    ></UserCreateReview>
                                </b-col>   
                            </b-row>
                            <hr> 
                        </li>
                    </ul>
                </b-col>
            </b-row>
        </b-container>
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
        axios.post('/dataget',
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
    .review-arrayBar{
        font-size: 1.3em;
        font-weight: bold; 
    }

    /* ↓버튼 관련 CSS */
    .btn-outlined {
        border-radius: 0;
        -webkit-transition: all 0.3s;
        -moz-transition: all 0.3s;
                transition: all 0.3s;
    }

    .btn-outlined.btn-danger {
        background: none;
        border: 3px solid #d9534f;
        color: #d9534f;
    }
    .btn-outlined.btn-danger:hover,
    .btn-outlined.btn-danger:active {
        color: #FFF;
        background: #d2322d;
    }
    /* ↑버튼 관련 CSS */

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
</style>