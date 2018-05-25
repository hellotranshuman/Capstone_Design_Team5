<!-- 
※ 현재 페이지 참고사항

1. 작성된 리뷰를 보는 페이지, 리뷰기능의 메인페이지에 해당
2. 작성일, 좋아요 정렬
3. 국가별 필터링

-->

<template>
    <transition name="fade">
        <v-content grid-list-md text-xs-center>
            <v-layout>
                <v-spacer></v-spacer>
                <!-- 리뷰 작성 버튼 -->
                <v-flex xs10 sm10>
                    <v-btn outline color="red lighten-2" v-on:click="checkLogin" :to="writeCheck" block>리뷰 작성</v-btn>
                </v-flex>
                <v-spacer></v-spacer>
            </v-layout>
            <v-layout>
                <v-flex xs4 sm2 offset-sm1 offset-xs1>
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
                <v-flex xs4 sm2>
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

            <!-- 최상단 이동 버튼 -->
            <v-btn class="up-button" color="grey lighten-2" outline small fixed bottom left fab
            @click="$vuetify.goTo(0, {duration:250, offset:0, easing:'easeInQuad'})">
                <v-icon>arrow_upward</v-icon>
            </v-btn>

            <!-- SNS 공유 -->
            <v-speed-dial fixed bottom right direction="top"
            transition="slide-y-reverse-transition" v-model="fab">
                <v-btn slot="activator" color="blue darken-2" dark v-model="fab" fab>
                    <v-icon>share</v-icon>
                    <v-icon>close</v-icon>
                </v-btn>
                <social-sharing v-bind:url= "url" inline-template>
                    <network network="facebook">
                        <!-- facebook svg태그 -->
                        <img src= "/images/review/facebook.svg" height="60" onmousedown="return false;">
                    </network>
                </social-sharing>
                <social-sharing v-bind:url= "url" inline-template>
                    <network network="twitter">
                        <!-- twitter svg태그 -->
                        <img src= "/images/review/twitter.svg" height="60" onmousedown="return false;">
                    </network>
                </social-sharing>
                <social-sharing v-bind:url= "url" inline-template>
                    <network network="weibo">
                        <!-- weibo svg태그 -->
                        <img src= "/images/review/weibo.svg" height="60" onmousedown="return false;" class="logo-img">
                    </network>
                </social-sharing>     
            </v-speed-dial> 
        </v-content>
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
            url         : "",             // 리뷰를 하는 페이지 URL
            sortSelect  : { sort: '작성일순', sortNum: 1 },     // 선택된 정렬 기준
            sortItems   : [                                     // 정렬 기준들
                { sort: '작성일순', sortNum: 1 },
                { sort: '좋아요순',   sortNum: 2 },
            ],

            filterSelect    : { country: '국가 선택', countryNum: 0 },  // 선택된 국가 필터링 기준
            filterItems     : [                                         // 국가 필터링 기준들
                { country: 'all',   countryNum: 0 },
                { country: 'China', countryNum: 1 },
                { country: 'Japan', countryNum: 2 },
                { country: 'Korea', countryNum: 3 },
                { country: 'USA',   countryNum: 4 },
            ],
            fab         : false,    
            writeCheck  : "",       // 리뷰 작성페이지 주소가 저장 되는 변수

        }
    },

    methods:{
        // 리뷰 작성시 로그인 여부 체크 함수
        checkLogin() {
            if(!(this.$session.get('loginStatus'))){
                alert('로그인 한 뒤 리뷰를 작성해주세요.');
            }
        }
    },

    created() {
        // url 주소를 현재 페이지로 url로 변경합니다.
        this.url = window.location.href;

        // 로그인 여부를 확인합니다.
        // 로그인을 한 경우 리뷰 작성이 가능하도록 리뷰작성페이지 주소를 해당 변수에 대입합니다.
        if(this.$session.get('loginStatus')){
            this.writeCheck = "writeReview";
        }
    }
}
</script>

<style scoped>
    /* svg태그의 cursor를 설정합니다. */
    svg {
        cursor: pointer;
    }
    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s
    }
    .fade-enter, .fade-leave-active {
        opacity: 0
    }
    /* 최상단 버튼 관련 CSS */
    .up-button {
        z-index: 10000;
    }
</style>