<!-- 
※ 현재 페이지 참고사항

1. 작성된 리뷰를 보는 페이지, 리뷰기능의 메인페이지에 해당
2. 작성일, 좋아요 정렬
3. 국가별 필터링

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
                <v-flex xs3>
                    <!-- 정렬 기준 선택 -->
                    <v-select 
                    :items      ="sortItems" 
                    v-model     ="sortSelect" 
                    label       ="정렬" 
                    item-text   ="sort" 
                    item-value  ="sortNum" 
                    single-line 
                    return-object>
                    </v-select> 
                </v-flex>
                <v-flex xs3>
                    <!-- 국가 필터링 기준 선택 -->
                    <v-select 
                    :items      ="filterItems" 
                    v-model     ="filterSelect" 
                    label       ="국가 선택"  
                    item-text   ="country"
                    single-line
                    return-object>
                    </v-select> 
                </v-flex>
                <v-spacer></v-spacer>
            </v-layout>
            <br><br>
            <v-layout>
                <v-flex>
                    <!-- 리뷰 내용 출력 -->
                    <UserReviewData 
                    :countryNum     ="this.filterSelect.countryNum" 
                    :countryName    ="this.filterSelect.country" 
                    :sortNum        ="this.sortSelect.sortNum">
                    </UserReviewData>
                </v-flex>
            </v-layout>
        </v-container>
    </transition>
</template>

<script>
// 리뷰 데이터를 전달받아 생성하고 정렬하는 컴퍼넌트 import
import UserReviewData from './UserReviewData';

// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

export default {
    components : {
        'UserReviewData' : UserReviewData,
    },

    data() {
        return {
            url         : "https://www.naver.com/",             // 리뷰를 하는 페이지 URL
            sortSelect  : { sort: '작성일순', sortNum: 1 },     // 선택된 정렬 기준
            sortItems   : [                                     // 정렬 기준들
                { sort: '작성일순', sortNum: 1 },
                { sort: '좋아요순',   sortNum: 2 },
            ],

            filterSelect    : { country: '국가 선택', countryNum: 0 },          // 선택된 국가 필터링 기준
            filterItems     : [                                 // 국가 필터링 기준들
                { country: 'all',   countryNum: 0 },
                { country: 'china', countryNum: 1 },
                { country: 'japan', countryNum: 2 },
                { country: 'korea', countryNum: 3 },
            ]
        }
    },
}
</script>

<style>
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