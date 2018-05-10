<!-- 
※ 현재 페이지 참고사항

-->
<template>
    <transition name="fade">
        <v-content>
            <!-- 리뷰 내용 출력 -->
            <v-layout>
                <v-spacer></v-spacer>
                <v-flex xs4 sm2 offset-sm1>
                    <h1>평점 : {{this.totalRating}}</h1>
                </v-flex>
                <v-spacer></v-spacer>
            </v-layout>
            <v-layout>
                <v-spacer></v-spacer>
                <v-flex xs12 sm10>
                    <hr>
                </v-flex>
                <v-spacer></v-spacer>
            </v-layout>
            <v-layout>
                <v-spacer></v-spacer>
                <v-flex xs12 sm10>
                    <!-- 리뷰 갯수 만큼 반복 -->
                    <ul>
                        <li v-for= "reviewData in reviewDataList" :key="reviewData['id']" v-if="reviewData['id']">
                            <UserCreateReview :userID="reviewData['name']" :reviewID="reviewData['id']" 
                            :country="reviewData['country']" :writeDate="reviewData['reg_date']" 
                            :likeNum="reviewData['likeNum']" :reviewLike="reviewData['reviewLike']" 
                            :rating="reviewData['rating']" :taste="reviewData['taste']" :service="reviewData['service']" 
                            :mood="reviewData['mood']" :price="reviewData['price']" :image="reviewData['image']"
                            :content="reviewData['content']" :hashTag="reviewData['hashTag']" >
                            </UserCreateReview>
                        </li>
                    </ul>
                </v-flex>
                <v-spacer></v-spacer>
            </v-layout>
        </v-content>
    </transition>
</template>

<script>
// 유저 리뷰 출력 컴포넌트 import
import UserCreateReview from './UserCreateReview.vue';

// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

export default {
    props : {
        // 국적을 나타내는 숫자 (0:all, 1:china, 2:japan 3:korea, 3:USA)
        countryNum:{
            type: Number,
            default: 0
        },
        // 국적을 나타내는 문자열 (all:모든 국가)
        countryName:{
            type: String,
            default: "all"
        },
        // 정렬 기준을 나타내는 숫자 (1:작성일 순, 2:좋아요순)
        sortNum:{
            type: Number,
            default: 1
        },
    },

    components : {
        'UserCreateReview' : UserCreateReview
    },

    data() {
        return {
            shop_id             : this.$route.params.shop_id,  // 식당 아이디를 저장하는 변수
            reviewDataList      : [],                           // DB에서 가져온 리뷰 데이터목록이 저장되는 배열
            reviewDataListCopy  : [],                           // reviewDataList[] 배열의 값을 복사하여 가지는 배열
            reviewImgList       : [],                           // 이미지명이 들어가는 배열
            reviewLikeList      : [],                           // 리뷰 좋아요 목록이 저장되는 배열
            hashTagList         : [],                           // 해시태그 목록이 저장되는 배열
            totalRating         : 0,                            // 가게별 평균 평점
        }
    },

    watch: {
        // 전달 받는 국적 값을 감시합니다.
        countryNum: function(){
            // 처음 컴포넌트를 생성했을 때 구한 리뷰 값을 reviewDataList[]배열에 깊은 복사(Deep Copy)합니다.
            // 즉 배열이지만 참조를 하지 않고 배열 값을 그대로 복사합니다.
            this.reviewDataList = this.reviewDataListCopy.slice();

            if(this.sortNum != 1){
                // 좋아요를 많이 받은 순으로 정렬, 좋아요를 받은 값이 같은 경우 최근 작성일 순으로 정렬
                this.reviewDataList.sort(function(a, b){
                    // 좋아요를 받은 값이 같은 경우 최근 작성일 순으로 정렬
                    if(a['likeNum'] === b['likeNum']){
                        var x = b['reg_date'];
                        var y = a['reg_date'];

                        return x < y ? -1 : x > y ? 1 : 0;
                    }
                    
                    return b['likeNum'] - a['likeNum'];
                });
            }

            // 전달 받은 국적의 값이 all 일 경우 국적 필터링을 실행하지 않습니다.
            // 기존의 배열에서 정해진 조건에 따른 필터링이 이루어진 새로운 배열을 생성합니다.
            if(this.countryNum != 0)
                this.reviewDataList = this.countryFilter(this.reviewDataList, this.countryName);
        },

        // 전달 받은 기준에 따라 정렬
        sortNum: function(){
            // 처음 컴포넌트를 생성했을 때 구한 리뷰 값을 reviewDataList[]배열에 깊은 복사(Deep Copy)합니다.
            // 즉 배열이지만 참조를 하지 않고 배열 값을 그대로 복사합니다.
            this.reviewDataList = this.reviewDataListCopy.slice();

            if(this.sortNum != 1){
                // 좋아요를 많이 받은 순으로 정렬, 좋아요를 받은 값이 같은 경우 최근 작성일 순으로 정렬
                this.reviewDataList.sort(function(a, b){
                    // 좋아요를 받은 값이 같은 경우 최근 작성일 순으로 정렬
                    if(a['likeNum'] === b['likeNum']){
                        var x = b['reg_date'];
                        var y = a['reg_date'];

                        return x < y ? -1 : x > y ? 1 : 0;
                    }
                    
                    return b['likeNum'] - a['likeNum'];
                });
            }

            // 전달 받은 국적의 값이 all 일 경우 국적 필터링을 실행하지 않습니다.
            // 기존의 배열에서 정해진 조건에 따른 필터링이 이루어진 새로운 배열을 생성합니다.
            if(this.countryNum != 0)
                this.reviewDataList = this.countryFilter(this.reviewDataList, this.countryName);
        },

    },

    methods: {
        // 국적 필터링을 하는 함수, 매개변수로 (전체 배열, 전달 받은 국적)를 전달합니다.
        countryFilter(reviewArr, counrty){
            return reviewArr.filter(function(reviewData){
                for(var iCount = 0; iCount < reviewArr.length; iCount++){
                    return reviewData['country'] == counrty;
                };
            });
        },

        // 반올림 함수
        round(number, precision) {
            var numArray = 0;

            if(number != null){
                var shift = function (number, precision, reverseShift) {
                if (reverseShift) {
                    precision = -precision;
                }  
                numArray = ("" + number).split("e");
                return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
                };
            return shift(Math.round(shift(number, precision, false)), precision, true);
            }

            return 0;
        },

        // 리뷰 데이터 값과 이미지 값을 분리하는 메서드
        arrayClassification(array){
            // 전달받은 전테 데이터배열의 길이만큼 반복
            for(var iCount = 0; iCount < array.length; iCount++){
                // filename을 key값으로 가지는 이미지값이 왔을때 
                // reviewImgList배열에 해당인덱스 이후부터 끝까지의 배열을 모두 저장합니다.
                if(array[iCount]['filename']){
                    this.reviewImgList = array.splice(iCount, array.length - iCount);
                }
            }
        },

        // 리뷰 데이터 값을 가지는 배열의 하나하나에 해당하는 이미지 값을 추가하는 메서드
        arrayPushImg(){
            var review_id = null;

            // [ _ ] 언더바를 기준으로 문자열을 분리합니다.
            for(var iCount = 0; iCount < this.reviewImgList.length; iCount++){
                review_id = this.reviewImgList[iCount]['filename'].split('_');

                // 이미지가 포함되는 리뷰 id를 이미지배열에 저장합니다.
                this.reviewImgList[iCount]['id'] = parseInt(review_id[0]);
                this.reviewImgList[iCount]['imgNum'] = parseInt(review_id[2]);
            }

            // 리뷰 데이터에 이미지 데이터를 저장
            for(var iCount = 0; iCount < this.reviewDataList.length; iCount++){
                var imageArr = [];  // 리뷰별로 이미지를 저장할 배열

                // 리뷰 데이터 배열의 id와 리뷰 이미지 배열의 id가 일치할때 리뷰 이미지 배열을 리뷰 데이터 배열안에 넣습니다.
                for(var jCount = 0; jCount < this.reviewImgList.length; jCount++){
                    this.reviewDataList[iCount]["image"] = []; // image를 key로 배는 배열 생성

                    if(this.reviewDataList[iCount]['id'] === this.reviewImgList[jCount]['id']){
                        imageArr.push(this.reviewImgList[jCount]["filename"]);
                    }
                     this.reviewDataList[iCount]["image"] = imageArr;
                }
            }
        },

        // 리뷰 데이터 값을 가지는 배열에 해시태그를 추가하는 함수
        arrayPushHashTag(){
            // 리뷰 데이터에 이미지 데이터를 저장
            for(var iCount = 0; iCount < this.reviewDataList.length; iCount++){
                var hashTagArr = [];  // 리뷰별로 이미지를 저장할 배열

                // 리뷰 데이터 배열의 id와 해시태그 배열의 id가 일치할때 해시태그 배열을 리뷰 데이터 배열안에 넣습니다.
                for(var jCount = 0; jCount < this.hashTagList.length; jCount++){
                    this.reviewDataList[iCount]["hashTag"] = []; // image를 key로 배는 배열 생성

                    if(this.reviewDataList[iCount]['id'] === this.hashTagList[jCount]['review_id']){
                        hashTagArr.push(this.hashTagList[jCount]['tag']);
                    }
                     this.reviewDataList[iCount]["hashTag"] = hashTagArr;
                }
            }
        },

        // 좋아요 버튼이 눌려져 있는지 여부를 가지는 값을 리뷰 데이터 배열에 저장합니다.
        addReviewLike(){
            for(var iCount = 0; iCount < this.reviewDataList.length; iCount++){
                // reviewLike를 key값으로 하여 fasle를 값을 등록합니다.
                this.reviewDataList[iCount]['reviewLike'] = false

                for(var jCount = 0; jCount < this.reviewLikeList.length; jCount++){
                    if(this.reviewDataList[iCount]['id'] === this.reviewLikeList[jCount]['review_id']){
                        // 좋아요버튼이 눌러져 있는 리뷰의 경우 위에서 등록된 reviewLike에 true값을 저장합니다.
                        this.reviewDataList[iCount]['reviewLike'] = true
                    }
                }
            }
        },

        // 해시태그값 중 review_id, tag_num 에 해당하는 값의 타입을 String에서 Number로 변경하는 함수
        hashTagDataTypeChange(){
            for(var iCount = 0; iCount < this.hashTagList.length; iCount++){
                this.hashTagList[iCount]['review_id']   = Number(this.hashTagList[iCount]['review_id']);
                this.hashTagList[iCount]['tag_num']     = Number(this.hashTagList[iCount]['tag_num ']);
            }

        },

        // 리뷰좋아요 값 중 review_id 에 해당하는 값의 타입을 String에서 Number로 변경하는 함수
        reviewLikeDataTypeChange(){
            for(var iCount = 0; iCount < this.reviewLikeList.length; iCount++){
                this.reviewLikeList[iCount]['review_id'] = Number(this.reviewLikeList[iCount]['review_id']);
            }
        },

        // 리뷰데이터 값 중 9가지 값의 타입을 String에서 Number로 변경하는 함수
        reviewDataTypeChange(){
            for(var iCount = 0; iCount < this.reviewDataList.length; iCount++){
                this.reviewDataList[iCount]['img_num']  = Number(this.reviewDataList[iCount]['img_num']);
                this.reviewDataList[iCount]['likeNum'] = Number(this.reviewDataList[iCount]['likeNum']);
                this.reviewDataList[iCount]['mood']    = Number(this.reviewDataList[iCount]['mood']);
                this.reviewDataList[iCount]['price']   = Number(this.reviewDataList[iCount]['price']);
                this.reviewDataList[iCount]['rating']  = Number(this.reviewDataList[iCount]['rating']);
                this.reviewDataList[iCount]['service'] = Number(this.reviewDataList[iCount]['service']);
                this.reviewDataList[iCount]['shop_id'] = Number(this.reviewDataList[iCount]['shop_id']);
                this.reviewDataList[iCount]['taste']   = Number(this.reviewDataList[iCount]['taste']);
                this.reviewDataList[iCount]['writer']  = Number(this.reviewDataList[iCount]['writer']);
            }

        },
    },

    // 라이프 사이클의 created 단계, DB에서 작성되어 있는 리뷰 데이터를 가지고 옵니다.
    created() {
        // Add shop_id in shopData
        var shopData = new FormData();
        shopData.append('shop_id', this.shop_id);

        // axios http 라이브러리 with Send shopData
        axios.post('/review', shopData).
        then((response)=>{

            console.log("-----review value get-----");
            console.log(response.data['review']);
            // 리뷰 좋아요 데이터
            console.log("-----review like get-----");
            console.log(response.data['reviewLike']);
            // 해시태그
            console.log("-----hashtag get-----");
            console.log(response.data['hashTag']);

            // ********************   리뷰목록 사용 데이터 get 및 자료형 변경   ********************
            // hashTagList배열에 해쉬태그 목록이 저장됩니다.
            this.hashTagList = response.data['hashTag'];
            // hashTagList배열 값 타입 변경
            this.hashTagDataTypeChange();

            // reviewLikeList배열에 리뷰 좋아요 목록이 저장됩니다.
            this.reviewLikeList = response.data['reviewLike'],
            // reviewLikeList배열 값 타입 변경
            this.reviewLikeDataTypeChange();

            // reviewDataList배열에 리뷰 데이터목록을 저장합니다.    Object.keys(배열);
            this.reviewDataList = response.data['review'],
            // 리뷰 평점의 값을 reviewDataList배열에서 shift하여 대입합니다.
            this.totalRating = this.reviewDataList.shift(),
            // 소수점 셋째자리에서 반올림 (둘째짜리까지 출력되도록)
            this.totalRating = this.round(this.totalRating['totalRating'], 2),
            // reviewDataList배열 값 타입 변경
            this.reviewDataTypeChange();
            // ********************   리뷰목록 사용 데이터 get 및 자료형 변경 끝   ********************

            // arrayClassification메서드를 호출하여 리뷰 데이터 값과 이미지 값을 분리
            this.arrayClassification(this.reviewDataList),
            // arrayPushImg메서드를 호출하여 리뷰 데이터 값을 가지는 배열에 해당하는 이미지 값을 추가
            this.arrayPushImg(),
            // 좋아요 버튼이 눌려져 있는지 여부를 가지는 값을 리뷰 데이터 배열에 저장하는 함수를 호출합니다.
            this.addReviewLike();
            // 리뷰 데이터 값을 가지는 배열에 해시태그를 추가하는 함수
            this.arrayPushHashTag();

            // reviewDataListCopy[] 배열에 전달 받은 배열 값을 대입합니다.
            // 배열을 대입할 경우 참조로 대입된다.
            this.reviewDataListCopy = this.reviewDataList;
            // console.log 출력
            console.log("----- 최종 처리 배열 값  -----"),
            console.log(this.reviewDataList)

        }).catch(console.log('Oh my god!!, Failed'));
    },
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
        transition: all 1s;
    }
    .fade-enter, .fade-leave-active {
        opacity: 0;
        transform: translateY(30px);
    }

    /* 링크를 클릭하려고 마우스를 가져갔을 때 */
    a:hover { 
        color: #FF6666; 
        text-decoration: none;
    }
</style>