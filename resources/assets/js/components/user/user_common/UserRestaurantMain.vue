<!-- 
※참고
식당 페이지 틀
-->
<template>
    <v-content>
        <v-layout>
            <!-- 정보, 메뉴, 리뷰 중 선택합니다. -->
            <v-spacer></v-spacer>
            <v-flex xs4 sm3>
                <v-btn large color="error" to="info" class="select-font-style">정보</v-btn>
            </v-flex>
            <v-flex xs4 sm3>
                <v-btn large color="error" to="menu" class="select-font-style">메뉴</v-btn>
            </v-flex>
            <v-flex xs4 sm3>                    
                <v-layout>
                    <v-flex xs11>
                        <v-btn large color="error" to="review" class="select-font-style">리뷰</v-btn>
                    </v-flex>
                </v-layout>
            </v-flex>
            <v-spacer></v-spacer>
        </v-layout>
        <v-layout>
            <v-flex>
                <!-- 내용을 출력합니다. -->
                <router-view></router-view>
            </v-flex>
        </v-layout>
    </v-content>
</template>

<script> 
    export default{

    }
</script>

<style>
    /* 클릭하지 않은 링크 */
    a:link { 
        color: black; 
        text-decoration: none;
    }
    /* 한번 클릭했던 혹은 다녀갔던 링크 */
    a:visited { 
        color: black; 
        text-decoration: none;
    }
    /* 링크를 클릭하려고 마우스를 가져갔을 때 */
    a:hover { 
        color: crimson; 
        text-decoration: none;
    }

    .select-font-style {
        font-size: 2em;
        font-weight: bold;   
        width: 95%;
        height: 100;
        color: white;
    }
</style>