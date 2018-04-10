<!-- 
※ 현재 페이지 참고사항

1. 가게 페이지 [정보, 메뉴, 리뷰] 선택 바
2. 네스티드 라우터 활용, [정보, 메뉴, 리뷰]를 선택할 경우 해당하는 하위 컴포넌트로 변경 됨
3. 하위컴포넌트의 import 및 라우터 설정은 app.js파일에 되어 있음
-->

<template>
    <v-container>
        <v-layout>
            <v-flex>
                <!-- 정보, 메뉴, 리뷰 중 선택합니다. -->
                <v-tabs centered color="red lighten-2" slot="extension" slider-color="yellow">
                    <v-tab to="/userRestaurantMain/restaurant"  class="select-font-style">정보</v-tab>
                    <v-tab to="/userRestaurantMain/menu"        class="select-font-style">메뉴</v-tab>
                    <v-tab to="/userRestaurantMain/review"      class="select-font-style">리뷰</v-tab>
                </v-tabs>
            </v-flex>
        </v-layout>
        <!-- 구분 -->
        <br><br>
        <v-layout>
            <v-flex>
                <!-- 내용을 출력합니다. -->
                <router-view></router-view>
            </v-flex>
        </v-layout>
    </v-container>
</template>

<script>

export default {

}
</script>

<style>
    /* 클릭하지 않은 링크 */
    a:link { 
        color: red; 
        text-decoration: none;
    }
    /* 한번 클릭했던 혹은 다녀갔던 링크 */
    a:visited { 
        color: black; 
        text-decoration: none;
    }
    /* 링크를 클릭하려고 마우스를 가져갔을 때 */
    a:hover { 
        color: white; 
        text-decoration: none;
    }

    .select-font-style {
        font-size: 2em;
        font-weight: bold;   
        width: 100%;
        height: 100;
        color: white;
    }


</style>