<!-- 
※ 현재 페이지 참고사항

1. 가게 페이지 [정보, 메뉴, 리뷰] 선택 바
2. 네스티드 라우터 활용, [정보, 메뉴, 리뷰]를 선택할 경우 해당하는 하위 컴포넌트로 변경 됨
3. 하위컴포넌트의 import 및 라우터 설정은 app.js파일에 되어 있음
-->

<template>
    <b-container fluid>
        <b-row>
            <b-col>  
                <!-- 정보, 메뉴, 리뷰 중 선택합니다. -->
                <b-nav justified tabs>
                    <b-nav-item>
                        <router-link to="info" class="btn btn-block selectFontStyle">정보</router-link>
                    </b-nav-item>
                    <b-nav-item>
                        <router-link to="menu" class="btn btn-block selectFontStyle">메뉴</router-link>
                    </b-nav-item>
                    <b-nav-item>
                        <router-link to="review" class="btn btn-block selectFontStyle">리뷰</router-link>
                    </b-nav-item>
                </b-nav>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <!-- 내용을 출력합니다. -->
                <router-view></router-view>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>

export default {

}
</script>

<style>
    .selectFontStyle {
        font-size: 1.3em;
        font-weight: bold;
        background-color: rgba(255, 127, 127, 0.404);        
    }

    #selectBarWidth {
        width: 90%
    }

    /* .sticky {
        position: sticky;
    } */

</style>