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
    <b-container fluid>
        <!-- 아이디 이미지, 아이디, 사용자 국적, 공뷰 버튼 -->
        <b-row>
            <b-col>아이디 이미지</b-col>
            <b-col>{{ userID }}</b-col>
            <b-col>사용자 국기(국적)</b-col>
            <b-col>
            </b-col>
        </b-row>
        <!-- 작성 날짜, 리뷰 좋아요 갯수 -->
        <b-row>
            <b-col>{{ writeDate }}</b-col>
            <b-col>리뷰 좋아요 갯수</b-col>
        </b-row>
        <!-- 총점 -->
        <b-row>
            <b-col>총점</b-col>
            <b-col>별점 개수</b-col>
        </b-row>
        <!-- 맛 -->
        <b-row>
            <b-col>맛</b-col>
            <b-col>별점 개수</b-col>
        </b-row>
        <!-- 서비스 -->
        <b-row>
            <b-col>서비스</b-col>
            <b-col>별점 개수</b-col>
        </b-row>
        <!-- 분위기 -->
        <b-row>
            <b-col>분위기</b-col>
            <b-col>별점 개수</b-col>
        </b-row>
        <!-- 가격 -->
        <b-row>
            <b-col>가격</b-col>
            <b-col>별점 개수</b-col>
        </b-row>
        <!-- 이미지 -->
        <!-- 이미지 개수에 따라 반복문으로 출력 -->
        <b-row>
            <b-col>이미지1</b-col>
            <b-col>이미지2</b-col>
            <b-col>이미지3</b-col>
        </b-row>
        <!-- 리뷰 내용 -->
        <b-row>
            <b-col>{{ content }}</b-col>
        </b-row>
    </b-container>
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

    }
}
</script>

<style>

</style>