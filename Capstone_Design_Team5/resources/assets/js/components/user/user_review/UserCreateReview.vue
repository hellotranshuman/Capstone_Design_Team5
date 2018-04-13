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
    <v-container>
        <!-- 아이디 이미지, 아이디, 사용자 국적, 공뷰 버튼 -->
        <v-layout>
            <!-- <v-card>
                <v-card-title>
                
                </v-card-title>
            </v-card> -->

            <v-flex>사용자 이미지</v-flex>
            <v-flex>{{this.userID}}</v-flex>
            <v-flex>사용자 국기(국적)</v-flex>
        </v-layout>
        <!-- 작성 날짜, 리뷰 좋아요 갯수 -->
        <v-layout>
            <v-flex>
                {{this.writeDate}}
            </v-flex>
            <v-flex>리뷰 좋아요 갯수</v-flex>
        </v-layout>
        <!-- 총점 -->
        <v-layout>
            <v-flex>총점</v-flex>
            <v-flex>{{this.rating}}</v-flex>
        </v-layout>
        <!-- 맛 -->
        <v-layout>
            <v-flex>맛</v-flex>
            <v-flex>{{this.taste}}</v-flex>
        </v-layout>
        <!-- 서비스 -->
        <v-layout>
            <v-flex>서비스</v-flex>
            <v-flex>{{this.service}}</v-flex>
        </v-layout>
        <!-- 분위기 -->
        <v-layout>
            <v-flex>분위기</v-flex>
            <v-flex>{{this.mood}}</v-flex>
        </v-layout>
        <!-- 가격 -->
        <v-layout>
            <v-flex>가격</v-flex>
            <v-flex>{{this.price}}</v-flex>
        </v-layout>
        <!-- 이미지 -->
        <!-- 이미지 개수에 따라 반복문으로 출력 -->
        <v-layout>
            <v-flex>이미지1</v-flex>
            <v-flex>이미지2</v-flex>
            <v-flex>이미지3</v-flex>
        </v-layout>
        <!-- 리뷰 내용 -->
        <v-layout>
            <v-flex>{{this.content}}</v-flex>
        </v-layout>
    </v-container>
</template>

<script>


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
        nationality: {
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
        // 이미지1
        image1: {
            type: String,
            default: ""
        },
        // 이미지2
        image2: {
            type: String,
            default: ""
        },
        // 이미지3
        image3: {
            type: String,
            default: ""
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

    data() {
        return {

        }
    },

    methods: {

    },

    // mounted() {
    //     alert(this.userID);
    //     alert(this.writeDate);
    // }
}
</script>

<style>

</style>