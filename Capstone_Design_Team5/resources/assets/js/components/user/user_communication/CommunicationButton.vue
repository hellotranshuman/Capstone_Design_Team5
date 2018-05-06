<!-- 
※ 유저 커뮤니케이션 버튼

1. 

-->

<template>
  <v-app>
    <v-layout>
      <v-flex xs12 sm6 offset-sm3>
        <v-card>
          <v-card-actions>
            <v-spacer></v-spacer>
          </v-card-actions>
          <v-container fluid v-bind="{ [`grid-list-${'xl'}`]: true }">
            <v-layout row wrap>
              <!-- 이모티콘 -->
              <v-flex xs4 class="emoticon" v-for="(emoticon, index) in emoticonData" :key="index">
                <v-card flat tile @click.native.stop="dialog = true">
                  <img v-bind:src="emoticon['url']" v-on:click="changeDialogsData(emoticon['url'], emoticon['number'])" onmousedown="return false;">
                </v-card>
              </v-flex>
              <!-- 출력할 모달창 -->
              <v-flex>
                <v-dialog v-model="dialog" max-width="500px" full-width>
                  <v-card flat tile height="340px">
                    <v-layout>
                      <!-- 모달 이미지 -->
                      <v-flex xs9>
                        <br>
                        <v-layout>
                          <v-spacer></v-spacer>
                          <v-flex xs10>
                            <!-- 이미지를 클릭하면 최종 선택 이모티콘을 나타내는 모달창 출력 -->
                            <v-card flat tile height="315px"     
                            @click.native.stop="secondDialog = true"
                            @click.native="dialog = false">
                              <img v-bind:src=clickImgURL onmousedown="return false;" class="select-emoticon">
                            </v-card>
                          </v-flex>
                          <v-spacer></v-spacer>
                        </v-layout>
                      </v-flex>
                      <v-flex xs3>
                        <v-layout>
                          <v-flex>
                            <!-- 모달 닫기 버튼 -->
                            <v-layout>     
                              <v-spacer></v-spacer>                     
                              <v-flex xs10>
                                <v-btn icon color="blue darken-1" flat @click.native="dialog = false">
                                  <v-icon x-large>close</v-icon>
                                </v-btn>
                              </v-flex>
                            </v-layout>
                            <!-- 모달 즐겨찾기 등록버튼 -->
                            <v-layout>
                              <v-spacer></v-spacer>
                              <v-flex xs10>
                                <v-btn flat icon color="yellow accent-4" v-if="!(this.bookmarkCheck)" v-on:click="bookmarkClick">
                                  <v-icon x-large>star_border</v-icon>
                                </v-btn>
                                <v-btn flat icon color="yellow accent-4" v-if="(this.bookmarkCheck)" v-on:click="bookmarkClick">
                                  <v-icon x-large>star</v-icon>
                                </v-btn>
                              </v-flex>
                            </v-layout>
                          </v-flex>
                        </v-layout>
                      </v-flex>
                    </v-layout>
                  </v-card>
                  
                  <!--********** 최종 선택 이모티콘 출력 모달창 **********-->
                  <v-dialog v-model="secondDialog" fullscreen>
                    <v-card>
                      <!-- 상단바 -->
                      <v-card-title>
                        <v-toolbar dark color="grey darken-3">
                            <v-toolbar-title>Communication</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <!-- 이 버튼을 누르면 communicationDialog의 값을 false로 만들어 
                            출력된 모달창을 사라지도록 한다는 것 -->
                            <v-btn icon @click.native="secondDialog = false">
                                <v-icon>close</v-icon>
                            </v-btn>
                          </v-toolbar>
                      </v-card-title>
                      <!-- 이모티콘 -->
                      <br><br>
                      <v-card-media>
                        <v-layout>
                          <v-spacer></v-spacer>
                          <v-flex xs10 sm4>
                            <img v-bind:src=clickImgURL onmousedown="return false;">
                          </v-flex>
                          <v-spacer></v-spacer>
                        </v-layout>
                      </v-card-media>
                      <!-- 확인 버튼 -->
                      <br><br><br><br>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-flex xs10 sm4>
                          <v-btn dark block color="grey darken-3" @click.native="secondDialog = false" class="ok-but">
                            확인
                          </v-btn>
                        </v-flex>
                        <v-spacer></v-spacer>
                      </v-card-actions>
                    </v-card>
                  </v-dialog>
                  <!--********** ↑ 최종 선택 이모티콘 출력 모달창 끝 **********-->
                </v-dialog>
              </v-flex>
            </v-layout>
          </v-container>
        </v-card>
      </v-flex>
    </v-layout>

  </v-app>
</template>

<script>
// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

export default {
    props : {
        // 이모티콘 카테고리를 나타내는 값
        selectValue:{
            type: Number,
            default: 0
        },
    },

    watch: {
        // selectValue 값을 감시합니다.
        selectValue: function(){

          switch(this.selectValue){
            // 즐겨찾기
            case 0:
              this.emoticonData = this.BookmarkList
                
              break;
            
            // 기본
            case 1:
              this.emoticonData = [
              {url : 'images/emoticon/confused.svg', number : 1},            // 혼란스러운
              {url : 'images/emoticon/desperate.svg', number : 2},           // 절망
              {url : 'images/emoticon/good.svg', number : 3},                // 좋아요
              {url : 'images/emoticon/sad.svg', number : 4},                 // 슬퍼요
              {url : 'images/emoticon/smiling.svg', number : 5},             // 기뻐요
              {url : 'images/emoticon/surprised.svg', number : 6},           // 놀라운
              {url : 'images/emoticon/suspicious.svg', number : 7},          // 의심스러운
              {url : 'images/emoticon/thinking.svg', number : 8},            // 생각해볼게요
              {url : 'images/emoticon/bathroom.svg', number : 9},            // 화장실
              {url : 'images/emoticon/water.svg', number : 10},               // 물
              {url : 'images/emoticon/chopsticks.svg', number : 11},          // 젓가락
              {url : 'images/emoticon/spoon.svg', number : 12},               // 숟가락
              {url : 'images/emoticon/fork.svg', number : 13},                // 포크
              {url : 'images/emoticon/cutlery.svg', number : 14},             // 식기 주세요
              {url : 'images/emoticon/bowl.svg', number : 15},                // 그릇 주세요
              {url : 'images/emoticon/dish.svg', number : 16},                // 접시 주세요
              {url : 'images/emoticon/seasoning.svg', number : 17},           // 소스 더 주세요. 
              ]
              break;
            
            // 주문
            case 2:
              this.emoticonData = [
              {url : 'images/emoticon/question.svg', number : 18},            // 질문이요
              {url : 'images/emoticon/menu.svg', number : 19},                // 메뉴판 주세요
              {url : 'images/emoticon/recommended.svg', number : 20},         // 추천해 주세요
              {url : 'images/emoticon/choices.svg', number : 21},             // 주문이요
              {url : 'images/emoticon/cancel.svg', number : 22},              // 취소 할 수 있나요
              {url : 'images/emoticon/change.svg', number : 23},              // 변경 할 수 있나요
              {url : 'images/emoticon/reserved.svg', number : 24},            // 예약했는데요.
              ]
              break;

            // 계산 
            case 3:
              this.emoticonData = [
              {url : 'images/emoticon/voucher.svg', number : 25},             // 쿠폰 사용 할 수 있나요
              {url : 'images/emoticon/cash.svg', number : 26},                // 현금 결제요
              {url : 'images/emoticon/debitCard.svg', number : 27},           // 카드 결제요
              {url : 'images/emoticon/visa.svg', number : 28},                // 비자 카드 결제요
              {url : 'images/emoticon/maestro.svg', number : 29},             // 마에스트로 카드 결제요
              {url : 'images/emoticon/unionPay.svg', number : 30},            // 유니온 페이 결제요
              {url : 'images/emoticon/jcb.svg', number : 31},                 // jcb 결제요
              {url : 'images/emoticon/invoice.svg', number : 32},             // 결제 할게요
              {url : 'images/emoticon/bill.svg', number : 33},                // 영수증 주세요
              ]
              break;
          }
        },
    },

    data() {
        return {
          // 모든 이모티콘의 정보가 들어있는 배열 (key : value), key값 : 이모티콘 번호, value : 이모티콘이 저장된 주소
          emoticonInfo : [
            {url : 'images/emoticon/confused.svg', number : 1},             // 혼란스러운
            {url : 'images/emoticon/desperate.svg', number : 2},            // 절망
            {url : 'images/emoticon/good.svg', number : 3},                 // 좋아요
            {url : 'images/emoticon/sad.svg', number : 4},                  // 슬퍼요
            {url : 'images/emoticon/smiling.svg', number : 5},              // 기뻐요
            {url : 'images/emoticon/surprised.svg', number : 6},            // 놀라운
            {url : 'images/emoticon/suspicious.svg', number : 7},           // 의심스러운
            {url : 'images/emoticon/thinking.svg', number : 8},             // 생각해볼게요
            {url : 'images/emoticon/bathroom.svg', number : 9},             // 화장실
            {url : 'images/emoticon/water.svg', number : 10},               // 물
            {url : 'images/emoticon/chopsticks.svg', number : 11},          // 젓가락
            {url : 'images/emoticon/spoon.svg', number : 12},               // 숟가락
            {url : 'images/emoticon/fork.svg', number : 13},                // 포크
            {url : '/images/emoticon/cutlery.svg', number : 14},             // 식기 주세요
            {url : 'images/emoticon/bowl.svg', number : 15},                // 그릇 주세요
            {url : 'images/emoticon/dish.svg', number : 16},                // 접시 주세요
            {url : 'images/emoticon/seasoning.svg', number : 17},           // 소스 더 주세요.

            {url : 'images/emoticon/question.svg', number : 18},            // 질문이요
            {url : 'images/emoticon/menu.svg', number : 19},                // 메뉴판 주세요
            {url : 'images/emoticon/recommended.svg', number : 20},         // 추천해 주세요
            {url : 'images/emoticon/choices.svg', number : 21},             // 주문이요
            {url : 'images/emoticon/cancel.svg', number : 22},              // 취소 할 수 있나요
            {url : 'images/emoticon/change.svg', number : 23},              // 변경 할 수 있나요
            {url : 'images/emoticon/reserved.svg', number : 24},            // 예약했는데요.

            {url : 'images/emoticon/voucher.svg', number : 25},             // 쿠폰 사용 할 수 있나요
            {url : 'images/emoticon/cash.svg', number : 26},                // 현금 결제요
            {url : 'images/emoticon/debitCard.svg', number : 27},           // 카드 결제요
            {url : 'images/emoticon/visa.svg', number : 28},                // 비자 카드 결제요
            {url : 'images/emoticon/maestro.svg', number : 29},             // 마에스트로 카드 결제요
            {url : 'images/emoticon/unionPay.svg', number : 30},            // 유니온 페이 결제요
            {url : 'images/emoticon/jcb.svg', number : 31},                 // jcb 결제요
            {url : 'images/emoticon/invoice.svg', number : 32},             // 결제 할게요
            {url : 'images/emoticon/bill.svg', number : 33},                // 영수증 주세요
          ],
           
            clickImgURL     : "",             // 모달창에 출력해야 하는 클릭한 이미지의 URL을 저장하는 변수
            clickImgNumber  : 0,              // 모달창에 출력해야 하는 클릭한 이미지의 번호를 저장하는 변수
            dialog          : false,          // 작은 모달창의 출력 여부를 나타내는 값
            secondDialog    : false,          // 마지막 모달창의 출력 여부를 나타내는 값
            bookmarkCheck   : false,          // 이모티콘을 즐겨찾기를 등록했는지 여부가 저장되는 변수
            getBookmarkList : [],             // 전송받은 즐겨찾기 목록이 저장되는 배열
            BookmarkList    : [],             // 전송받은 즐겨찾기 목록을 활용하여 해당하는 이모티콘의 정보를 저장시키는 배열          
            emoticonData    : [],             // 현재 선택한 카테고리의 즐겨찾기 목록이 저장되는 배열
        }
    },

    methods:{
        // 출력할 Dialogs 이미지의 URL 및 즐겨찾기 등록 여부를 변경합니다.
        changeDialogsData(imgName, imgNumber){
          this.clickImgURL    = imgName;
          this.clickImgNumber = imgNumber;
          
          // 현재 클릭한 이모티콘이 즐겨찾기에 등록되어 있으면 bookmarkCheck의 값을 true를
          // 등록되어 있지 않으면 false를 대입합니다.
          if(this.getBookmarkList.includes(imgNumber)){
            this.bookmarkCheck = true
          } 
          else {
            this.bookmarkCheck = false
          }

          // 세션에 저장된 사용자 id를 불러옵니다.
          // sessionStorage.getItem('userId');
          // console.log(sessionStorage.getItem('userId'));

        },    
        
        // 즐겨찾기 버튼을 클릭하면 실행되는 함수
        bookmarkClick(){
          // 즐겨찾기 등록 여부를 나타내는 값을 반대로 합니다.
          this.bookmarkCheck = !this.bookmarkCheck;

          // axios로 즐겨찾기 등록을 한 이모티콘의 번호를 전송합니다.
          axios.post('/?????', {
            "emoticon_num"    : this.clickImgNumber,  // 이모티콘 번호
            "bookmark_status" : this.bookmarkCheck,   // 즐겨찾기 등록 상태 (true : 누름, false : 안누름)
          }).
          then((response)=>{
          }).catch(console.log('Oh my god!!, Failed'));

          console.log('이모티콘 번호');
          console.log(this.clickImgNumber);
          console.log('즐겨찾기 등록 버튼 상태');
          console.log(this.bookmarkCheck);

        },

        // 전체 이모티콘 중에서 즐겨찾기를 등록한 이모티콘을 찾는 함수
        bookmarkFilter(emoticonInfoArr, getBookmarkList){
          return emoticonInfoArr.filter(function(emoticonInfo){
            return getBookmarkList.includes(emoticonInfo['number']);
          });
        },

    },

    created() { 
      // axios http 라이브러리.
      axios.post('/???').
      then((response)=>{
        // 즐겨찾기 목록을 배열에 저장합니다.
        this.getBookmarkList = response.data['???'];
      }).catch(console.log('Oh my god!!, Failed'));

      // 즐겨찾기 목록의 정보를 찾아서 저장합니다.
      this.BookmarkList = this.bookmarkFilter(this.emoticonInfo, this.getBookmarkList);

      // console.log(this.BookmarkList);

      // 필터링한 즐겨찾기 목록의 정보를 emoticonData 배열에 저장합니다.
      // 처음 커뮤니케이션 버튼에 들어갔을때 보이는 페이지가 즐겨찾기 카테고리이기 때문.
      this.emoticonData = this.BookmarkList;
    }
}
</script>

<style>
  /* 이모티콘 선택 여뷰 확인 스타일 */
  .select-emoticon:hover{
    cursor: pointer;
  }

  /* 최종 확인 버튼 스타일 */
  .ok-but{
    height: 100%;
    font-size: 3em;
    font-weight: bold;
  }
</style>