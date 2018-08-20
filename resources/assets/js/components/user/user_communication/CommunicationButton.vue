<!-- ※ 유저 커뮤니케이션 버튼 -->

<template>
  <v-app>
    <v-layout id="communication-page-style">
      <v-flex xs12 sm6 offset-sm3>
        <v-card flat>
          <v-card-actions>
            <v-spacer></v-spacer>
          </v-card-actions>
          <v-container fluid v-bind="{ [`grid-list-${'xl'}`]: true }" class="py-0 my-0">
            <!-- 즐겨찾기가 등록되어 있지 않을 경우 출력 -->
            <v-layout v-if="(this.selectValue == 0 && this.getBookmarkList.length == 0)">
              <v-flex class="ma-2 pa-2 communication-bookmark-check">
                <v-card class="headline">
                  {{this.bookmarkCheckString}}
                </v-card>
              </v-flex>
            </v-layout>
            <v-layout row wrap>
              <!-- 이모티콘 -->
              <v-flex xs4 class="emoticon" v-for="(emoticon, index) in emoticonData" :key="index">
                <v-card flat tile @click.native.stop="dialog = true">
                  <img v-bind:src="emoticon['path']+emoticon['img_name']" 
                  v-on:click="changeDialogsData(emoticon['path']+emoticon['img_name'], emoticon)" 
                  onmousedown="return false;">
                </v-card>
              </v-flex>
              <!-- 출력할 모달창 -->
              <v-flex>
                <v-dialog v-model="dialog" :max-width="modalSize + 'px'" full-width>
                  <v-content class="ma-2 pa-2 modal-color">
                    <v-card flat tile>
                      <v-layout>
                        <!-- 모달 이미지 -->
                        <v-flex xs9>
                          <br>
                          <v-layout>
                            <v-spacer></v-spacer>
                            <v-flex xs10>
                              <!-- 이미지를 클릭하면 최종 선택 이모티콘을 나타내는 모달창 출력 -->
                              <v-card flat tile      
                              @click.native.stop="secondDialog = true"
                              @click.native="dialog = false">
                                <img v-bind:src=clickImgURL onmousedown="return false;" 
                                class="select-emoticon">
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
                                  <v-btn icon color="black" flat @click.native="dialog = false">
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
                  </v-content>
                  <!--********** 최종 선택 이모티콘 출력 모달창 **********-->
                  <v-dialog v-model="secondDialog" fullscreen>
                    <v-card>
                      <!-- 상단바 -->
                      <v-card-title>
                        <v-toolbar dark dense fixed id="final-modal-outer">
                            <v-toolbar-title id="final-title">{{this.finalTitle}}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <!-- 이 버튼을 누르면 communicationDialog의 값을 false로 만들어 
                            출력된 모달창을 사라지도록 한다는 것 -->
                            <v-btn icon @click.native="secondDialog = false">
                                <v-icon>close</v-icon>
                            </v-btn>
                          </v-toolbar>
                      </v-card-title>
                      <!-- 이모티콘 -->
                      <v-card-media class="pt-5">
                        <v-layout>
                          <v-spacer></v-spacer>
                          <v-flex xs10 sm4>
                            <img v-bind:src=clickImgURL onmousedown="return false;">
                          </v-flex>
                          <v-spacer></v-spacer>
                        </v-layout>
                      </v-card-media>
                      <!-- 확인 버튼 -->
                      <br><br><br>
                      <v-card-actions>
                        <v-spacer></v-spacer>
                        <v-flex xs10 sm4>
                          <v-btn dark block round flat color="brown lighten-1" @click.native="secondDialog = false" class="ok-but">
                            {{this.finalOkButton}}
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
            this.emoticonData = this.getBookmarkList            
            break;
            
          // 기본
          case 1:
            this.emoticonData = this.basicsList;
            break;
            
          // 주문
          case 2:
            this.emoticonData = this.getOrderList;
            break;

          // 계산 
          case 3:
            this.emoticonData = this.getPayList;
            break;
        }
      },
  },

  data() {
      return {
        emoticonInfo    : [],       // 모든 이모티콘의 정보가 들어있는 배열 
        modalSize       : 500,      // 첫번째 모달창 크기
        clickImgURL     : "",       // 모달창에 출력해야 하는 클릭한 이미지의 URL을 저장하는 변수
        clickImg        : null,     // 모달창에 출력해야 하는 이미지 객체
        dialog          : false,    // 작은 모달창의 출력 여부를 나타내는 값
        secondDialog    : false,    // 마지막 모달창의 출력 여부를 나타내는 값
        bookmarkCheck   : false,    // 이모티콘을 즐겨찾기를 등록했는지 여부가 저장되는 변수
        getBookmarkList : [],       // 전송받은 즐겨찾기 목록이 저장되는 배열         
        emoticonData    : [],       // 현재 선택한 카테고리의 즐겨찾기 목록이 저장되는 배열
        basicsList      : [],       // 기본 이모티콘 목록을 저장하는 배열
        getOrderList    : [],       // 주문 이모티콘 목록을 저장하는 배열
        getPayList      : [],       // 계산 이모티콘 목록을 저장하는 배열

        finalTitle          : 'Communication',
        finalOkButton       : '確認',
        bookmarkCheckString : 'ブックマークを登録してみましょ。',
      }
  },

  methods:{
    // 이모티콘 즐겨찾기 취소에 사용되는 필터 함수
    emoticonFilter(emoticonList, exceptEmoticon){
      return emoticonList.filter(function(emoticon){
        for(var iCount = 0; iCount < emoticonList.length; iCount++){
          return emoticon['id'] != exceptEmoticon['id'];
        };
      });
    },

    // 출력할 Dialogs 이미지의 URL 및 즐겨찾기 등록 여부를 변경합니다.
    changeDialogsData(imgName, imgObj){
      this.clickImgURL = imgName;
      this.clickImg    = imgObj;

      var includeCheck = null;

      // 현재 클릭한 이미지가 즐겨찾기에 추가되어 있는지 여부를 확인하는 함수
      for (var iCount = 0; iCount < this.getBookmarkList.length; iCount++){
        if(this.getBookmarkList[iCount]['id'] == this.clickImg['id']){
          includeCheck = true;
        }    
      }

      // 현재 클릭한 이모티콘이 즐겨찾기에 등록되어 있으면 bookmarkCheck의 값을 true를
      // 등록되어 있지 않으면 false를 대입합니다.
      if(includeCheck){
        this.bookmarkCheck = true
        // console.log('포함');
      } 
      else {
        this.bookmarkCheck = false
          // console.log('미포함');
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
      axios.post('/addUserBookmark', {
        "emoticon_num"    : this.clickImg['id'],  // 이모티콘 번호
        "bookmark_status" : this.bookmarkCheck,   // 즐겨찾기 등록 상태 (true : 누름, false : 안누름)
      }).
      then((response)=>{
        // alert(response.data['msg']);
        // 즐겨찾기에 추가한 이모티콘을 배열에 저장합니다.
        if(this.bookmarkCheck){
          this.getBookmarkList.push(this.clickImg);
        } 
        // 즐겨찾기에 등록된 이모티콘을 배열에서 제거합니다.
        else {
          // 즐겨찾기를 제외한 이모티콘 배열을 구하는 함수를 실행합니다.
          this.getBookmarkList  = this.emoticonFilter(this.getBookmarkList, this.clickImg);
          // 출력하는 이모티콘 배열을 가지는 변수의 값에 즐겨찾기 리스트를 대입합니다.
          this.emoticonData     = this.getBookmarkList;
        }
      }).catch(console.log('Oh my god!!, Failed'));
    },

    // 카테고리별로 이모티콘을 분류하는 함수 (1:기본, 2:주문, 3:계산)
    emoticonGrouping(){
      for(var iCount = 0; iCount < this.emoticonInfo.length; iCount++){
        if(this.emoticonInfo[iCount]["category"] == 1)
          this.basicsList.push(this.emoticonInfo[iCount]);
        else if(this.emoticonInfo[iCount]["category"] == 2)
          this.getOrderList.push(this.emoticonInfo[iCount]);
        else if(this.emoticonInfo[iCount]["category"] == 3)
          this.getPayList.push(this.emoticonInfo[iCount]);
      }
    },

    // 국적에 따라 UI의 언어를 바꾸는 함수
    languageChange() {
      if(this.$session.get('user_country') == 'Korea'){
        this.finalOkButton = '확인';
        this.this.getBookmarkList = '이모티콘을 즐겨찾기에 등록해 보세요.';
      } else if(this.$session.get('user_country') == 'China') {
        this.finalOkButton = '确认';
        this.this.getBookmarkList = '为你的表情符号添加书签。';
      } else if(this.$session.get('user_country') == 'USA') {
        this.finalOkButton = "Confirm";
        this.this.getBookmarkList = "Let's register a bookmark.";
      }
    }
  },

  created() {
    this.languageChange();

    // axios http 라이브러리.
    axios.post('/getEmoticonList').
    then((response)=>{
      // 즐겨찾기 목록을 배열에 저장합니다.
      this.getBookmarkList  = response.data['userBookmark'];
      // 이모티콘 목록을 배열에 저장합니다.
      this.emoticonInfo     = response.data['emoticonList'];

      console.log('즐겨찾기 리스트');
      console.log(this.getBookmarkList);
      console.log(this.getBookmarkList.length);
      // console.log('이모티콘 리스트');
      // console.log(this.emoticonInfo);

      // 이모티콘을 카테고리별로 분류합니다.
      this.emoticonGrouping();

      // 필터링한 즐겨찾기 목록의 정보를 emoticonData 배열에 저장합니다.
      // 처음 커뮤니케이션 버튼에 들어갔을때 보이는 페이지가 즐겨찾기 카테고리이기 때문.
      this.emoticonData = this.getBookmarkList;

    }).catch(console.log('emoticon Oh my god!!, Failed'));
  }
}
</script>

<style scoped>
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

  #final-title {
    color: #ff9800;
  }

  #final-modal-outer {
    background-color : #ffffff;
  }

  #communication-page-style {
        background-color: #ffffff;
    }

  .modal-color {
    background-color: #efe2bd;
  }

  .communication-bookmark-check {
      background-color: #efe2bd;
    }
</style>