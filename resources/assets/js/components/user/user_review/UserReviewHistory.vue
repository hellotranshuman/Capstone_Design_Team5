<!-- 
리뷰내역 필요한 자료
(해당 유저가 작성한 모든 리뷰에 대해서)
- 리뷰 번호
- 별점 (총점 만)
- 식당명
- 식당 대표 이미지 1개
- 좋아요 받은 갯수
- 작성일
- 해당 식당 리뷰페이지 까지 이동할 주소

-->
<template>
    <v-app>
        <v-content>
            <v-list three-line>
                <template v-for="(review, index) in getReviewList">
                    <v-subheader v-if="index == 0" :key="index">{{listHeader}}</v-subheader>
                    <v-divider  :inset="true" :key="index + '_' + review['id']"></v-divider>
                    <v-list-tile avatar :key="review['id']" :to="review['reviewLink']">
                        <!-- 가게 이미지 -->
                        <v-list-tile-avatar>
                            <img v-bind:src="review['filename']" onmousedown="return false;">
                        </v-list-tile-avatar>
                        <v-list-tile-content>
                            <!-- 가게명 -->
                            <v-list-tile-title v-html="review['shop_name']"></v-list-tile-title>
                            <v-list-tile-sub-title>
                                <!-- 별점 -->
                                <v-layout>
                                    <v-flex xs4>
                                        <v-layout>
                                            <v-flex xs3 sm1 v-for="(count, index) in review['rating']" :key="index">
                                                <v-icon color="yellow accent-4">star</v-icon>
                                            </v-flex>
                                            <v-spacer></v-spacer>
                                        </v-layout>
                                    </v-flex>
                                    <v-spacer></v-spacer>
                                </v-layout>
                            </v-list-tile-sub-title>
                            <!-- 작성날짜 -->
                            <v-list-tile-sub-title v-html="review['reg_date']"></v-list-tile-sub-title>
                        </v-list-tile-content>
                    </v-list-tile>
                </template>
            </v-list>
        </v-content>
    </v-app>
</template>
<script>
import VueAxios from 'vue-axios';
import axios    from 'axios';

  export default {
    data() {
        return {
            listHeader      : "리뷰 목록",      // 리뷰 목록 헤더
            getReviewList   : [],               // 전달받은 리뷰 목록이 저장되는 배열
        }
    },

    methods: {
        // 리뷰평점 데이터의 자료형을 Number로 변경합니다.
        getReviewListDataTypeChange(){
            for(var iCount = 0; iCount < this.getReviewList.length; iCount++){
                this.getReviewList[iCount]['rating'] = Number(this.getReviewList[iCount]['rating']);
            }
        },
    },

    created(){
        // axios http 라이브러리 with Send shopData
        axios.post('/getUserReviewList').
        then((response)=>{       
            this.getReviewList = response.data['userReviewList'];

            // 전달 받은 자료형중 rating 값을 Number형으로 변환합니다.
            this.getReviewListDataTypeChange();

            // console.log('get review history list');
            // console.log(this.getReviewList);
        }).catch(console.log('review history Oh my god!!, Failed'));
    },
  }
</script>
<style scoped>
    /* 링크를 클릭하려고 마우스를 가져갔을 때 */
    a:hover { 
        color: rgb(102, 051, 000); 
        text-decoration: none;
    }
</style>