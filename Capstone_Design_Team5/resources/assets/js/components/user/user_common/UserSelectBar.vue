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
                <b-nav justified tabs variant="outline-danger" class="w-100">
                    <b-nav-item active>
                        <router-link to="/restaurant">
                            <b-button variant="outline-danger" class="select-font-style">
                            정보
                            </b-button>
                        </router-link>
                    </b-nav-item>
                    <b-nav-item active>
                        <router-link to="/menu">
                            <b-button variant="outline-danger" class="select-font-style">
                            메뉴
                            </b-button>
                        </router-link>
                    </b-nav-item>
                    <b-nav-item active>
                        <router-link to="/review">
                            <b-button variant="outline-danger" class="select-font-style">
                            리뷰
                            </b-button>
                        </router-link>
                    </b-nav-item>
                </b-nav>
            </b-col>
        </b-row>
        <!-- 구분 -->
        <br><br>
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
    .select-font-style {
        font-size: 2em;
        font-weight: bold;   
        width: 100%;
        height: 100;
    }

    #selectBarWidth {
        width: 90%
    }

    /* .sticky {
        position: sticky;
    } */

</style>