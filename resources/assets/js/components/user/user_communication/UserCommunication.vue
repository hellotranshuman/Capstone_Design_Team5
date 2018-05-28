<!-- 
※ 유저 커뮤니케이션 버튼 페이지 테두리
1. 유저 커뮤니케이션 페이지로 [즐겨찾기, 기본, 주문, 계산] 중 
선택한 카테고리를 나타내는 값을 CommunicationButton 컴포넌트로 전달합니다.

-->
<template>
  <v-app>
    <!-- 커뮤니케이션 버튼 상단바 -->
    <v-layout>
      <v-flex>
        <v-toolbar color="grey darken-3">
          <v-spacer></v-spacer>
          <v-toolbar-items>
            <v-btn flat small color="white" class="toolbar-style" v-on:click="selectCategory(0)">즐겨찾기</v-btn>
            <v-btn flat small color="white" class="toolbar-style" v-on:click="selectCategory(1)">기본</v-btn>
            <v-btn flat small color="white" class="toolbar-style" v-on:click="selectCategory(2)">주문</v-btn>
            <v-btn flat small color="white" class="toolbar-style" v-on:click="selectCategory(3)">계산</v-btn>
          </v-toolbar-items>
          <v-spacer></v-spacer>
        </v-toolbar>
      </v-flex>
    </v-layout>
    <!-- 이모티콘 목록 -->
    <v-layout>
      <v-flex>
        <CommunicationButton  :selectValue="this.selectValue"></CommunicationButton>
      </v-flex>
    </v-layout>
  </v-app>
</template>

<script>
// 이모티콘을 출력하는 컴포넌트
import CommunicationButton from './CommunicationButton.vue';

export default {
    components : {
       'CommunicationButton'  : CommunicationButton,
    },

    data() {
        return {
            size: 'xs',
            items: [
              { text: 'Extra small (2px)', value: 'xs' },
              { text: 'Small (4px)', value: 'sm' },
              { text: 'Medium (8px)', value: 'md' },
              { text: 'Large (16px)', value: 'lg' },
              { text: 'Extra large (24px)', value: 'xl' }
            ],

            bookmarkSelect  : true,
            basicsSelect    : false,
            orderSelect     : false,
            paySelect       : false,
            selectValue     : 0,          // 이모티콘 카테고리를 나타내는 값            
        }
    },

    methods:{
      selectCategory(selectNum){
        this.selectValue = selectNum;
      },
    },
}
</script>
<style>
  .emoticon:hover{
    background: gainsboro;
    cursor: pointer;
  }
  
  .toolbar-style{
    font-size: 1.2em;
    font-weight: bold;
  }
</style>