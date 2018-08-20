<!-- 
※참고
식당 페이지 틀
-->
<template>
    <v-content class="mt-0 pt-3">
        <v-layout>
            <!-- 정보, 메뉴, 리뷰 중 선택합니다. -->
            <v-spacer></v-spacer>
            <v-flex xs4 sm3>
                <v-btn large to="info" id="info-button" class="select-font-style">{{this.infoButton}}</v-btn>
            </v-flex>
            <v-flex xs4 sm3>
                <v-btn large to="menu" id="menu-button" class="select-font-style">{{this.menuButton}}</v-btn>
            </v-flex>
            <v-flex xs4 sm3>                    
                <v-layout>
                    <v-flex xs11>
                        <v-btn large to="review" id="review-button" class="select-font-style">{{this.reviewButton}}</v-btn>
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
        data() {
            return {
                infoButton      : "情報",
                menuButton      : "メニュー",
                reviewButton    : "レビュー"
            }
        },

        methods:{
            // 국적에 따라 UI의 언어를 바꾸는 함수
            languageChange() {
                if(this.$session.get('user_country') == 'Korea'){
                    this.infoButton     = '정보';
                    this.menuButton     = '메뉴';
                    this.reviewButton   = '리뷰';
                } else if(this.$session.get('user_country') == 'China') {
                    this.infoButton     = '信息';
                    this.menuButton     = '菜单';
                    this.reviewButton   = '回顾';
                } else if(this.$session.get('user_country') == 'USA') {
                    this.infoButton     = 'Info';
                    this.menuButton     = 'menu';
                    this.reviewButton   = 'review';
                }
            }
        },

        created() {
            this.languageChange();
        }
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
        font-size: 1.5em;
        font-weight: bold;   
        width: 95%;
        height: 100;
    }

    #info-button {
        background-color: #6d4d35;
        color: #ffffff;
    }

    #menu-button {
        background-color: #6d4d35;
        color: #ffffff;
    }

    #review-button {
        background-color: #6d4d35;
        color: #ffffff;
    }
</style>