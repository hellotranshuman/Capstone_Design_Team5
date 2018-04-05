<!-- 
※ 현재 페이지 참고사항

1. 작성된 리뷰를 보는 페이지, 리뷰기능의 메인페이지에 해당
2. 작성일, 인기, 국가 3개로 정렬
-->

<template>
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
        <b-row>
            <b-col>
                <b-nav justified tabs class="review-arrayBar">
                    <b-nav-item>작성일 순</b-nav-item>
                    <b-nav-item>인기순</b-nav-item>
                    <b-nav-item>국가순</b-nav-item>
                </b-nav>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
export default {

}
</script>

<style>
.review-arrayBar{
    font-size: 1.3em;
    font-weight: bold;
}

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
</style>