<!-- 
※ 유저 커뮤니케이션 버튼 페이지 테두리
1. 유저 커뮤니케이션 페이지로 [즐겨찾기, 기본, 주문, 계산] 중 
선택한 카테고리를 나타내는 값을 CommunicationButton 컴포넌트로 전달합니다.

-->
<template>
  <v-app>
    <v-content class="ma-0 pa-0">
      <!-- 커뮤니케이션 버튼 상단바 -->
      <v-layout id="communication-topBar">
        <v-flex xs3>
          <v-btn color="amber darken-1" flat v-on:click="selectCategory(0)">
            <v-icon>bookmark</v-icon>
          </v-btn>
        </v-flex>
        <v-flex xs3>
          <v-btn color="black" flat v-on:click="selectCategory(1)">
            <v-icon>question_answer</v-icon>
          </v-btn>
        </v-flex>
        <v-flex xs3>
          <v-btn color="black" flat v-on:click="selectCategory(2)">
            <v-icon>room_service</v-icon>
          </v-btn>
        </v-flex>
        <v-flex xs3>
          <v-btn color="black" flat v-on:click="selectCategory(3)">
            <v-icon>payment</v-icon>
          </v-btn>
        </v-flex>
      </v-layout>
      <v-layout>
        <v-flex>
          <hr class="communication-hr-line">
        </v-flex>
      </v-layout>
      <!-- 이모티콘 목록 -->
      <v-layout>
        <v-flex>
            <CommunicationButton  :selectValue="this.selectValue"></CommunicationButton>
        </v-flex>
      </v-layout>
    </v-content>
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
            bookmarkSelect  : true,
            basicsSelect    : false,
            orderSelect     : false,
            paySelect       : false,
            selectValue     : 0,          // 이모티콘 카테고리를 나타내는 값         

            // 이모티콘 이미지 주소 배열
            emoticonList : [
                              '/images/emoticon/thankyou.svg',
                              '/images/emoticon/water.svg',
                              '/images/emoticon/toilet.svg',
                              '/images/emoticon/chopsticks.svg',
                              '/images/emoticon/spoon.svg',
                              '/images/emoticon/fork.svg',
                              '/images/emoticon/bowl.svg',
                              '/images/emoticon/menuAdd.svg',
                              '/images/emoticon/menuChange.svg',
                              '/images/emoticon/menuCancel.svg',
                              '/images/emoticon/menu.svg',
                              '/images/emoticon/howTime.svg',
                              '/images/emoticon/cashPay.svg',
                              '/images/emoticon/cardPay.svg'
                            ]
        }
    },

    methods:{
      selectCategory(selectNum){
        this.selectValue = selectNum;
      },

      // 이미지를 preloading 하는 함수
      preloading (imageArray){
        let n = imageArray.length; 
        
        for (let i = 0; i < n; i++){
          let img = new Image(); 
          img.src = imageArray[i]; 
        } 
      }
    },

    created() {
      // 이미지를 preloading 하는 함수
      this.preloading(this.emoticonList);
    }
}
</script>
<style>
  .emoticon:hover{
    background: gainsboro;
    cursor: pointer;
  }

  #communication-topBar {
    background-color : #ffffff;
    overflow-x: hidden;
    overflow-y: auto;
  }

  hr.communication-hr-line {
    width: 100%;
    height: 2px;
    margin-left: 0%;
    margin-right: auto;
    background-color:#d2b07d;
    color:#d2b07d;
    border: 0 none;
  }
</style>