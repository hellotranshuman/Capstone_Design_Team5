<!-- 
손님 통계 페이지

1. 통계 제공 종류 (전체, 국적, 연령, 성별), (당일, 일,주,월 단위)

-->

<template>
  <v-container>
    <v-layout>
      <v-flex>
        <!-- 날짜 선택 상단바 -->
        <v-toolbar
          :height=topDateBarSize
          floating
          fixed
          inverted-scroll
          scroll-off-screen
          :scroll-threshold="400"
          clipped-left
        >
          <v-layout>
            <v-flex xs2>
              <v-layout>
                <v-flex>
                  <v-btn dark v-on:click="setTopDateBarSize" color="amber darken-3">기간 선택</v-btn>
                </v-flex>
              </v-layout>
              <!-- 최상단 이동 버튼 -->
              <v-layout>
                <v-flex>
                  <v-btn dark v-if="!topDateBar" color="amber darken-3"
                  @click="$vuetify.goTo(nowUpPosition, {duration: nowDuration, offset: nowOffset, easing: nowEasing})">
                    <v-icon>arrow_upward</v-icon>
                  </v-btn>
                </v-flex>
              </v-layout>
              <!-- 최하단 이동 버튼 -->
              <v-layout>
                <v-flex>
                  <v-btn dark v-if="!topDateBar" color="amber darken-3"
                  @click="$vuetify.goTo(nowDownPosition, {duration: nowDuration, offset: nowOffset, easing: nowEasing})">
                    <v-icon>arrow_downward</v-icon>
                  </v-btn>
                </v-flex>
              </v-layout>
            </v-flex>
            <v-flex xs9>
              <v-card v-if="!topDateBar">
                <v-card-text>
                  <v-layout>
                    <!-- 기간 선택, 시작 날짜 -->
                    <v-flex xs8>
                      <v-menu 
                        ref="topBarstartMenu" 
                        v-model="topBarstartMenu"
                        transition="scale-transition"
                        offset-y full-width lazy
                        min-width="290px"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        :return-value.sync="topBarstartDate">

                        <v-text-field slot="activator"
                          label="시작 날짜" v-model="topBarstartDate" 
                          prepend-icon="event" readonly>
                        </v-text-field>
                        <v-date-picker v-model="topBarstartDate" no-title scrollable show-current>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="topBarstartMenu = false">Cancel</v-btn>
                          <v-btn flat color="primary" @click="$refs.topBarstartMenu.save(topBarstartDate)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-flex>
                    <!-- 기간 선택, 마지막 날짜 -->
                    <v-flex xs8>
                      <v-menu 
                        ref="topBarendMenu" 
                        v-model="topBarendMenu"
                        transition="scale-transition"
                        offset-y full-width lazy
                        min-width="290px"
                        :close-on-content-click="false"
                        :nudge-right="40"
                        :return-value.sync="topBarendDate">
                        <v-text-field slot="activator"
                          label="마지막 날짜" v-model="topBarendDate" 
                          prepend-icon="event" readonly>
                        </v-text-field>

                        <v-date-picker v-model="topBarendDate" no-title scrollable show-current>
                          <v-spacer></v-spacer>
                          <v-btn flat color="primary" @click="topBarendMenu = false">Cancel</v-btn>
                          <v-btn flat color="primary" @click="$refs.topBarendMenu.save(topBarendDate)">OK</v-btn>
                        </v-date-picker>
                      </v-menu>
                    </v-flex>
                    <v-flex>
                      <v-btn large color="error" v-on:click="dateSearch">
                        <b>조회</b>
                      </v-btn>
                    </v-flex>
                  </v-layout>
                </v-card-text>
                <!-- 기간 자동 선택 버튼 -->
                <v-card-actions>
                  <v-layout>
                    <v-flex xs2>
                      <v-btn flat color="orange" v-on:click="setToday">오늘</v-btn>
                    </v-flex>
                    <v-flex xs2>
                      <v-btn flat color="orange" v-on:click="setMonth">이번 달</v-btn>
                    </v-flex>
                    <v-flex xs2>
                      <v-btn flat color="orange" v-on:click="setYear">이번 년도</v-btn>
                    </v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>     
                </v-card-actions>
              </v-card>
            </v-flex>
          </v-layout>
        </v-toolbar>
      </v-flex>
    </v-layout>

    <v-layout>
      <v-flex>
        <br> 
        <h3><B>손님 통계</B></h3>
        손님 통계를 볼 수 있습니다.
        <hr><br>
      </v-flex>
    </v-layout>
    <!-- 날짜 선택 -->
    <v-layout>
      <v-spacer></v-spacer>
      <v-flex xs10>
        <v-card>
          <v-card-title>
            기간 선택
          </v-card-title>
          <v-card-text>
            <v-layout>
              <!-- 기간 선택, 시작 날짜 -->
              <v-flex xs8>
                <v-menu 
                  ref="startMenu" 
                  v-model="startMenu"
                  transition="scale-transition"
                  offset-y full-width lazy
                  min-width="290px"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="startDate">

                  <v-text-field slot="activator"
                    label="시작 날짜" v-model="startDate" 
                    prepend-icon="event" readonly>
                  </v-text-field>

                  <v-date-picker v-model="startDate" no-title scrollable show-current>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="startMenu = false">Cancel</v-btn>
                    <v-btn flat color="primary" @click="$refs.startMenu.save(startDate)">OK</v-btn>
                  </v-date-picker>
                </v-menu>
              </v-flex>
              <!-- 기간 선택, 마지막 날짜 -->
              <v-flex xs8>
                <v-menu 
                  ref="endMenu" 
                  v-model="endMenu"
                  transition="scale-transition"
                  offset-y full-width lazy
                  min-width="290px"
                  :close-on-content-click="false"
                  :nudge-right="40"
                  :return-value.sync="endDate">
                  <v-text-field slot="activator"
                    label="마지막 날짜" v-model="endDate" 
                    prepend-icon="event" readonly>
                  </v-text-field>
                  <v-date-picker v-model="endDate" no-title scrollable show-current>
                    <v-spacer></v-spacer>
                    <v-btn flat color="primary" @click="endMenu = false">Cancel</v-btn>
                    <v-btn flat color="primary" @click="$refs.endMenu.save(endDate)">OK</v-btn>
                  </v-date-picker>
                </v-menu>
              </v-flex>
              <v-flex>
                <v-btn large color="error" v-on:click="dateSearch">
                  <b>조회</b>
                </v-btn>
              </v-flex>
            </v-layout>
          </v-card-text>
          <!-- 기간 자동 선택 버튼 -->
          <v-card-actions>
            <v-layout>
              <v-flex xs1>
                <v-btn flat color="orange" v-on:click="setToday">오늘</v-btn>
              </v-flex>
              <v-flex xs1>
                <v-btn flat color="orange" v-on:click="setMonth">이번 달</v-btn>
              </v-flex>
              <v-flex xs1>
                <v-btn flat color="orange" v-on:click="setYear">이번 년도</v-btn>
              </v-flex>
              <v-spacer></v-spacer>
            </v-layout>     
          </v-card-actions>
        </v-card>
      </v-flex>
      <v-spacer></v-spacer>
    </v-layout>

    <!-- 구분 -->
    <br><br><hr class="date-picker-line"><br><br>
    <v-layout>
      <v-flex>
        <v-layout justify-space-around>
          <!-- 리뷰 평점 -->
          <v-flex xs2>
            <h2>손님 평점 (점)</h2>
          </v-flex>
        </v-layout>
        <v-layout justify-space-around>
          <v-spacer></v-spacer>
          <v-flex xs5>
            <CustomerRatingChart :height="300" :chart-data="ratingData" :options="customerRateOptions"></CustomerRatingChart>
          </v-flex>
          <v-flex xs3 class="card-text-style">
            <br><br>
            <v-card>
              <v-card-title>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-flex xs7><b>손님 평균 점수</b></v-flex>
                  <v-spacer></v-spacer>
                </v-layout>
              </v-card-title>
              <v-card-text>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-flex xs5>총점 : </v-flex>
                  <v-flex xs2> {{ this.getRatingScore[0]['totalRating'] }} </v-flex>
                  <v-spacer></v-spacer>
                </v-layout>
                <br>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-flex xs5>맛 : </v-flex>
                  <v-flex xs2> {{ this.getRatingScore[0]['taste'] }} </v-flex>
                  <v-spacer></v-spacer>
                </v-layout>
                <br>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-flex xs5>서비스 : </v-flex>
                  <v-flex xs2> {{ this.getRatingScore[0]['service'] }} </v-flex>
                  <v-spacer></v-spacer>
                </v-layout>
                <br>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-flex xs5>분위기 : </v-flex>
                  <v-flex xs2> {{ this.getRatingScore[0]['mood'] }} </v-flex>
                  <v-spacer></v-spacer>
                </v-layout>
                <br>
                <v-layout>
                  <v-spacer></v-spacer>
                  <v-flex xs5>가격 : </v-flex>
                  <v-flex xs2> {{ this.getRatingScore[0]['price'] }} </v-flex>
                  <v-spacer></v-spacer>
                </v-layout>
              </v-card-text>
            </v-card>
          </v-flex>
          <v-spacer></v-spacer>
        </v-layout>
      </v-flex>
    </v-layout>

    <!-- 구분 -->
    <br><br><hr><br><br>
    <!-- 방문 손님수 그래프 -->
    <v-layout justify-space-around>
      <v-spacer></v-spacer>
      <v-flex xs2>
        <h2>방문 손님 수 (명)</h2>
      </v-flex>
      <v-spacer></v-spacer>
    </v-layout>
    <!-- 지정한 기간 방문자수 -->
    <br><br>
    <v-layout>
      <v-spacer></v-spacer>
      <v-flex xs10>
        <v-card>
          <v-card-text>
            <v-layout>
              <v-spacer></v-spacer>
              <v-flex xs5>
                <h3>{{this.startDate}} ~ {{this.endDate}} 방문손님 :</h3>
              </v-flex>
              <v-flex xs3>
                <h2>
                  {{this.customerScore}}
                </h2>
              </v-flex>
              <v-spacer></v-spacer>
            </v-layout>
          </v-card-text>
        </v-card>  
      </v-flex>
      <v-spacer></v-spacer>
    </v-layout>
    <!-- 방문 손님 그래프 출력 -->
    <v-layout>
      <v-spacer></v-spacer>
      <v-flex xs8>
        <CustomerNumberChart :height="200" :startDay="startDate" :endDay="endDatePlusOne"></CustomerNumberChart>
      </v-flex>
      <v-spacer></v-spacer>
    </v-layout>

    <!-- 구분 -->
    <br><br><hr><br><br>
    <v-layout justify-space-around>
      <!-- 방문 손님 성비별 그래프 -->
      <v-flex xs4>
        <v-layout justify-space-around>
          <v-flex xs7>
            <h2>방문 손님 성비 (%)</h2>
          </v-flex>
        </v-layout>
        <v-layout justify-space-around>
          <v-flex>
            <CustomerGenderChart :height="330" :chart-data="customerGenderData"></CustomerGenderChart>
          </v-flex>
        </v-layout>
      </v-flex>
      <!-- 방문 손님 연령대별 그래프 -->
      <v-flex xs4>
        <v-layout justify-space-around>
          <v-flex xs7>
            <h2>방문 손님 연령대 (%)</h2>
          </v-flex>
        </v-layout>
        <v-layout justify-space-around>
          <v-flex>
            <CustomerAgeChart :height="330" :chart-data="customerAgeData"></CustomerAgeChart>
          </v-flex>
        </v-layout>
      </v-flex>
      <!-- 방문 손님 국적별 그래프 -->
      <v-flex xs4>
        <v-layout justify-space-around>
          <v-flex xs7>
            <h2>방문 손님 국적 (%)</h2>
          </v-flex>
        </v-layout>
        <v-layout justify-space-around>
          <v-flex>
            <CustomerCountryChart :height="330" :chart-data="customerCountryData"></CustomerCountryChart>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>

    <!-- 구분 -->
    <br><br><hr><br><br>
    <!-- 메뉴 필터링 (국적, 연령, 성별) -->
    <v-layout>
      <v-spacer></v-spacer>
      <v-flex xs10>
        <v-card>
          <v-card-title>
            인기 메뉴 필터링
          </v-card-title>
          <v-card-text>
            <!-- 전체,국적,성별,연령 필터링 -->
            <v-layout>
              <v-spacer></v-spacer>
              <v-flex xs2>
                <v-select 
                  :items      ="rankingCountryItems" 
                  v-model     ="rankingCountrySelect" 
                  label       ="국가 선택"  
                  item-text   ="country"
                  single-line
                  return-object
                  >
                </v-select>
              </v-flex>
              <v-flex xs2>
                <v-select 
                  :items      ="rankingGenderItems" 
                  v-model     ="rankingGenderSelect" 
                  label       ="성별 선택"  
                  item-text   ="gender"
                  single-line
                  return-object>
                </v-select>
              </v-flex>
              <v-flex xs5>
                <v-select 
                  :items      ="rankingAgeItems" 
                  v-model     ="rankingAgeSelect" 
                  label       ="연령 선택"  
                  item-text   ="age"
                  single-line
                  return-object>
                </v-select>
              </v-flex>
              <v-spacer></v-spacer>
            </v-layout>
          </v-card-text>
        </v-card>
      </v-flex>
      <v-spacer></v-spacer>
    </v-layout>
      <!-- 구분 -->
    <br>
    <v-layout>
      <v-flex>
        <v-layout justify-space-around>
          <!-- 인기 메뉴 순위 -->
          <v-flex xs3>
            <h2>인기 메뉴 순위 (그릇)</h2>
          </v-flex>
        </v-layout>
        <v-layout justify-space-around>
          <v-flex xs8>
            <MenuRankingChart :height="200" :chart-data="menuRankData"></MenuRankingChart>
          </v-flex>
        </v-layout>
      </v-flex>
    </v-layout>
  </v-container>
</template>

<script>
// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

import CustomerNumberChart    from './CustomerNumberChart.vue';   // 월별 손님수 그래프
import CustomerGenderChart    from './CustomerGenderChart.vue';   // 손님 성별 그래프
import CustomerAgeChart       from './CustomerAgeChart.vue';      // 손님 연령대 그래프
import CustomerCountryChart   from './CustomerCountryChart.vue';  // 손님 국적 그래프
import CustomerRatingChart    from './CustomerRatingChart.vue';   // 손님 평점 그래프
import MenuRankingChart       from './MenuRankingChart.vue';      // 메뉴 주문수 순위 그래프

  export default {
    components:{
      'CustomerNumberChart'  : CustomerNumberChart,
      'CustomerGenderChart'  : CustomerGenderChart,
      'CustomerAgeChart'     : CustomerAgeChart,
      'CustomerCountryChart' : CustomerCountryChart,
      'CustomerRatingChart'  : CustomerRatingChart,
      'MenuRankingChart'     : MenuRankingChart,
    },

    data(){
      return {
        shop_id               : this.$route.params.shop_id,  // 식당 아이디를 저장하는 변수
        topBarstartDate       : null,
        topBarstartMenu       : false,
        topBarendDate         : null,
        topBarendDatePlusOne  : null,    // 마지막 날짜 + 1일 값이 저장되는 변수 (날짜까지만 있으면 00시00분00초가 기준이 되기 떄문에, 해당날의 모든 데이터를 포함하기 위해서는 다음날짜가 필요)
        topBarendMenu         : false,

        startDate       : null,
        startMenu       : false,
        endDate         : null,
        endDatePlusOne  : null,    // 마지막 날짜 + 1일 값이 저장되는 변수 (날짜까지만 있으면 00시00분00초가 기준이 되기 떄문에, 해당날의 모든 데이터를 포함하기 위해서는 다음날짜가 필요)
        endMenu         : false,

        rankingCountrySelect    : { country: '국가 선택', countryNum: 0 },  // 선택된 국가 필터링 기준
        rankingCountryItems     : [                                         // 국가 필터링 기준들
          { country: 'all',   countryNum: 0 },
          { country: 'china', countryNum: 1 },
          { country: 'japan', countryNum: 2 },
          { country: 'korea', countryNum: 3 },
          { country: 'usa',   countryNum: 4 },
        ],

        rankingGenderSelect    : { gender: '성별 선택', genderNum: 0 }, // 선택된 국가 필터링 기준
        rankingGenderItems     : [                                      // 국가 필터링 기준들
          { gender: 'all',    genderNum: 0 },
          { gender: 'male',   genderNum: 1 },
          { gender: 'female', genderNum: 2 },
        ],

        rankingAgeSelect    : { age: '연령 선택', ageNum: 0 },    // 선택된 국가 필터링 기준
        rankingAgeItems     : [                                   // 국가 필터링 기준들
          { age: 'all',       ageNum: 0 },
          { age: '0~9세',     ageNum: 1 },
          { age: '10대',      ageNum: 2 },
          { age: '20대',      ageNum: 3 },
          { age: '30대',      ageNum: 4 },
          { age: '40대',      ageNum: 5 },
          { age: '50대',      ageNum: 6 },
          { age: '60세 이상', ageNum: 7 },
        ],

        customerScore   : null,     // 지정된 기간동안 판매량 대비 방문 손님수
        menuRankData    : null,     // 그래프를 그리기 위한 메뉴 판매수 데이터가 저장될 변수
        ratingData          : [],   // 가게평점 5종류의 값을 전달 받을 변수
        customerGenderData  : [],   // 그래프를 그리기 위한 판매량 대비 방문 손님 성비 데이터가 저장될 변수
        customerAgeData     : [],   // 그래프를 그리기 위한 판매량 대비 방문 손님 연령대 데이터가 저장될 변수
        customerCountryData : [],   // 그래프를 그리기 위한 판매량 대비 방문 손님 국적 데이터가 저장될 변수
        customerRateOptions : {},   // CustomerRatingChar 그래프에 사용될 option이 저장될 변수

        getRatingScore  : [         // 그래프를 그리기 위한 평점 배열을 저장할 배열, 값을 초기화 해둡니다.
          {'totalRating'  : 0},
          {'taste'        : 0},
          {'service'      : 0},
          {'mood'         : 0},
          {'price'        : 0}
        ],

        topDateBar      : true,  // 날짜 상단바의 현재 상태를 저장하는 변수
        topDateBarSize  : 83,    // 날짜 상단바의 크기를 저장하는 변수
        nowEasing       : 'easeInQuad', // 페이지 이동 방식
        nowOffset       : 0,            // 페이지 offset 설정 (이동 위치에서 남길만큼의 위치값)
        nowUpPosition   : 0,            // 최상단 페이지 이동 위치
        nowDownPosition : 9999,         // 최하단 페이지 이동 위치
        nowDuration     : 700,          // 페이지 이동 시간
      }
    },

    watch: {
      // 시작날짜
      startDate : function(){
        this.topBarstartDate = this.startDate;  
        // console.log('시작날짜 대입');
        // console.log(this.topBarstartDate);
      },

      // 상단바 시작날짜
      topBarstartDate : function(){
        this.startDate = this.topBarstartDate;  
        // console.log('top시작날짜 대입');
        // console.log(this.startDate);
      },

      // 마자막 날짜
      endDate : function(){
        this.topBarendDate = this.endDate;  
        // console.log('마지막 날짜 대입');
        // console.log(this.topBarendDate);
      },

      // 상단바 마지막 날짜
      topBarendDate : function(){
        this.endDate = this.topBarendDate;  
        // console.log('top마지막 날짜 대입');
        // console.log(this.topBarendDate);
      },

      // 판매량 대비 메뉴 필터링에서 선택된 국가
      rankingCountrySelect : function(){
        this.getMenuRankData();
      },

      // 판매량 대비 메뉴 필터링에서 선택된 성별
      rankingGenderSelect : function(){
        this.getMenuRankData();
      },
      // 판매량 대비 메뉴 필터링에서 선택된 연령
      rankingAgeSelect : function(){
        this.getMenuRankData();
      },

    },

    methods : {
      //************************* 상태에 따른 날짜 상단바의 크기를 조절하는 함수 *************************
      setTopDateBarSize(){
        if(this.topDateBar){
          this.topDateBarSize = 205;
        }
        else {
          this.topDateBarSize = 50;
        }

        // console.log('topDateBarSize');
        // console.log(this.topDateBar);
        // console.log(this.topDateBarSize);

        this.topDateBar = !this.topDateBar;
      },


      //************************* 그래프 조회 날짜를 갱신하는 함수 *************************
      dateSearch(){
        // console.log('---------- startDate ----------');
        // console.log(this.startDate);
        // console.log('---------- endDate ----------');
        // console.log(this.endDate);
        // console.log('---------- endDatePlusOne ----------');
        // console.log(this.endDatePlusOne);

        // 마지막 날짜의 + 1일 값을 구하는 함수
        this.endDatePlusOneDate();

        // 지정된 기간동안 판매량 대비 방문 손님수를 갱신하는 함수
        this.getCustomerScore();

        // 유저평점 데이터를 받아 그래프를 그리는 함수를 실행합니다.
        this.getCustomerRating();

        // 메뉴 주문 그래프 생성 함수를 실행합니다.
        this.getMenuRankData();

        // 판매량 대비 방문 손님 성비를 갱신하는 함수를 실행합니다.
        this.getCustomerGenderData();

        // 판매량 대비 방문 손님 연령을 갱신하는 함수
        this.getCustomerAgeData();

        // 판매량 대비 방문 손님 국적을 갱신하는 함수
        this.getCustomerCountryData();
      },

      //************************* 반올림 함수 (반올림 대상값, 반올림 자릿수) *************************
      round(number, precision) {
        var numArray = 0;

        if(number != null){
          var shift = function (number, precision, reverseShift) {
            if (reverseShift) {
              precision = -precision;
            }  
            numArray = ("" + number).split("e");
            return +(numArray[0] + "e" + (numArray[1] ? (+numArray[1] + precision) : precision));
          };
          return shift(Math.round(shift(number, precision, false)), precision, true);
        }

        return 0;
      },

      //*************** 데이터를 정렬해주는 함수 (계산할 숫자값(퍼센트로 가공), 카테고리명, 그래프색상) ***************
      getDataSort(percentData, nameData, colorData){
        var setData = [];

        // 계산할 총합이 저장되는 변수
        var totalNumber = 0;

        // 전체 국적별 매출금액 총합을 구합니다.
        for(var iCount = 0; iCount < percentData.length; iCount++){
          totalNumber += Number(percentData[iCount]);
        }

        // 비율 데이터를 가공합니다.
        for (var iCount = 0; iCount < percentData.length; iCount++){
          setData.push(
            {
              'percent' : this.round(percentData[iCount] / totalNumber * 100, 2), // 전체 연령별 방문 손님 비율을 구하여 저장합니다.
              'name'    : nameData[iCount],
              'color'   : colorData[iCount]
            }
          );
        }

        // 전달받은 주문횟수를 비율로 계산한 값을 저장하는 배열
        var ratioData  = [];
        // 배열을 초기화 합니다.
        nameData  = [];
        colorData = [];

        // 퍼센트를 기준으로 내림차순으로 정렬 (큰거 -> 작은 순)
        setData.sort(function(a,b){
          return b['percent'] - a['percent'];
        });

        // 정렬된 국적별 주문 비율 데이터를 종류별로 변수에 저장합니다.
        for(var iCount = 0; iCount < percentData.length; iCount++){
          ratioData.push(setData[iCount]['percent']);
          nameData.push(setData[iCount]['name']);
          colorData.push(setData[iCount]['color']);
        }

        return {'ratio' : ratioData, 'name' : nameData, 'color' : colorData};
      },

      //***** 메뉴 데이터 값을 가공하는 함수 (매개변수는 메뉴 데이터 값), (menuGraphNum -> 1:메뉴순위 2:매출순위) *****
      setMenuData(menuData, menuGraphNum){
        var menuNameList     = [];  // 메뉴 이름 목록이 저장되는 배열
        var menuValueList    = [];  // 메뉴 값 목록이 저장되는 배열
        var menuBarColorList = [];  // 메뉴 그래프 색상

        // 메뉴이름 및 메뉴별 주문 개수 값을 각각 배열에 저장합니다.
        for(var iCount = 0; iCount < menuData.length; iCount++){
          menuNameList.push(menuData[iCount]['menuName']);
          if(menuGraphNum == 1){
            menuValueList.push(menuData[iCount]['menuCount']);
          } 
          else if(menuGraphNum == 2){
            menuValueList.push(menuData[iCount]['menuTotal']);
          }
        }

        // 그래프 색상 설정
        var firstBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
        var secondBar = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
        var thirdBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
        var fourthBar = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
        var fifthBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);

        firstBar.addColorStop(0, 'rgba(255, 0,0, 0.9)');
        firstBar.addColorStop(0.5, 'rgba(255, 0, 0, 0.7)');
        firstBar.addColorStop(1, 'rgba(255, 0, 0, 0.5)');
            
        secondBar.addColorStop(0, 'rgba(000, 051, 255, 0.9)')
        secondBar.addColorStop(0.5, 'rgba(000, 051, 255, 0.7)');
        secondBar.addColorStop(1, 'rgba(000, 051, 255, 0.5)');

        thirdBar.addColorStop(0, 'rgba(000, 153, 102, 0.9)')
        thirdBar.addColorStop(0.5, 'rgba(000, 153, 102, 0.7)');
        thirdBar.addColorStop(1, 'rgba(000, 153, 102, 0.5)');

        fourthBar.addColorStop(0, 'rgba(102, 000, 204, 0.9)')
        fourthBar.addColorStop(0.5, 'rgba(102, 000, 204, 0.7)');
        fourthBar.addColorStop(1, 'rgba(102, 000, 204, 0.5)');

        fifthBar.addColorStop(0, 'rgba(255, 102, 000, 0.9)')
        fifthBar.addColorStop(0.5, 'rgba(255, 102, 000, 0.7)');
        fifthBar.addColorStop(1, 'rgba(255, 102, 000, 0.5)');  

        menuBarColorList = [firstBar, secondBar, thirdBar, fourthBar, fifthBar]

        return {
          'menuNameList'      : menuNameList, 
          'menuValueList'     : menuValueList, 
          'menuBarColorList'  : menuBarColorList
        }
      },

      //************************* 마지막 날짜의 + 1일 값을 구하는 함수 *************************
      endDatePlusOneDate(){
        var dateArr = this.endDate.split("-");      // 마지막 날짜 문자열을 -를 기준으로 구분합니다.
        var date    = Number(dateArr[2]) + 1;       // 마지막 날짜값에서 1 값을 더합니다.

        this.endDatePlusOne = dateArr[0] + '-' + dateArr[1] + '-' + date; // 마지막 날짜 +1일 에해당하는 날짜를 대입합니다.
      },

      //************************* 통계 기간 선택을 자동으로 오늘로 지정해주는 함수 *************************
      setToday(){
        var today = new Date().toISOString().substr(0, 10).replace('T', ' ');

        this.startDate  = today;
        this.endDate    = today;
      },

      //************************* 현재 달의 값을 구하는 함수 *************************
      setMonth(){
        // 올해
        var year  = new Date().getFullYear();
        // 이번달, 1월 : 0 부터 순서대로 받으므로 값을 +1 합니다.
        var month = new Date().getMonth();
        month += 1;

        // 월 값이 10보다 작을때 앞에 숫자 0을 붙이도록 합니다.
        if(month < 10){
          month = "0" + month;
        }

        // 이번년도 이번달 1일을 변수 startDate에 저장합니다.
        this.startDate = year + "-" + month + "-01";

        // 오늘 날짜
        var today = new Date().toISOString().substr(0, 10).replace('T', ' ');
        this.endDate = today;        
      },

      //************************* 현재 연도의 값을 구하는 함수 *************************
      setYear(){
        // 올해
        var year  = new Date().getFullYear();

        // 이번년도 1월 1일을 변수 startDate에 저장합니다.
        this.startDate = year + "-01-01";

        // 오늘 날짜
        var today = new Date().toISOString().substr(0, 10).replace('T', ' ');
        this.endDate = today;
      },

      //************************* 지정된 기간동안 판매량 대비 방문 손님수를 갱신하는 함수 *************************
      getCustomerScore(){
        // axios http 라이브러리 
        axios.post('/owner/getCustomerScore', {
          'shop_id'     : this.shop_id,       // 가게 id
          'start_date'  : this.startDate,     // 처음 날짜
          'end_date'    : this.endDatePlusOne // 마지막 날짜
        }).
        then((response)=>{
          var getCustomerScore = response.data['customerData'];  // 방문 손님수를 대입합니다.

          // console.log('방문 손님 수');
          // console.log(getCustomerScore);

          this.customerScore = getCustomerScore[0]['customer'];
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 유저평점 데이터를 받아 그래프를 그리는 함수 *************************
      getCustomerRating(){
        // axios http 라이브러리 
        axios.post('/owner/getRatingScore', {
          'shop_id'     : this.shop_id,       // 가게 id
          'start_date'  : this.startDate,      // 처음 날짜
          'end_date'    : this.endDatePlusOne // 마지막 날짜
        }).
        then((response)=>{
          this.getRatingScore = response.data['ratingData'];  // 가게평점 5종류를 대입합니다.

          // console.log('가게 평점 배열');
          // console.log(this.getRatingScore);

          // Overwriting base render method with actual data.
          this.ratingData = {
            labels: ['총점', '맛', '서비스', '분위기', '가격'],
            datasets: [
              {
                label: '평점',
                backgroundColor: ['rgba(54, 162, 235, 0.5)'],
                borderColor: ['#0099FF'],
                fill: true,
                // borderWidth: 1,
                data                  : [this.getRatingScore[0]['totalRating'], this.getRatingScore[0]['taste'],
                this.getRatingScore[0]['service'],this.getRatingScore[0]['mood'],this.getRatingScore[0]['price']],
                pointRadius           : 7,                          // 포인터의 반지름 크기 값
                pointHoverRadius      : 20,                         // 가리킨 포인터의 반지름
                pointBorderColor      : '#3366CC  ',                // 포인터의 색깔
                pointBackgroundColor  : 'rgba(000,102,255,0.7)',    // 포인터의 배경색깔
              },
            ]
          }

          // option을 저장합니다.
          this.customerRateOptions = {
            scale: {
              ticks: {
                beginAtZero: true,
                min: 0,
                max: 5,
                stepSize:0.5,
              }
            }
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 판매량 대비 방문 손님 성비를 갱신하는 함수 *************************
      getCustomerGenderData(){
        // axios http 라이브러리 
        axios.post('/owner/getGenderScore', {
          'shop_id'     : this.shop_id,         // 가게 id
          'start_date'  : this.startDate,       // 처음 날짜
          'end_date'    : this.endDatePlusOne   // 마지막 날짜
        }).
        then((response)=>{
          var getGenderData = response.data['genderData'];  // 전달받은 월별 손님수를 대입합니다.

          // 전달받은 성별값을 대입합니다. (퍼센트가 아니라 성별 주문횟수)
          var genderValueArray = Object.values(getGenderData[0]);
          // 연령대별 이름
          var genderNameData   = ['남자 손님', '여자 손님'];
          // 연령대별 그래프 색상
          var genderGraphColor = ['#3399FF', '#FF6666'];

          // 데이터를 정렬해주는 함수 (계산할 숫자값(퍼센트로 가공), 카테고리명, 그래프색상)
          var getGraphData = this.getDataSort(genderValueArray, genderNameData, genderGraphColor);

          // Overwriting base render method with actual data.
          this.customerGenderData = {
            labels: getGraphData['name'],
            datasets: [
              {
                label: '손님 성비',
                backgroundColor: getGraphData['color'],
                data: getGraphData['ratio']
              }
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 판매량 대비 방문 손님 연령을 갱신하는 함수 *************************
      getCustomerAgeData(){
        // axios http 라이브러리 
        axios.post('/owner/getAgeScore', {
          'shop_id'     : this.shop_id,         // 가게 id
          'start_date'  : this.startDate,       // 처음 날짜
          'end_date'    : this.endDatePlusOne   // 마지막 날짜
        }).
        then((response)=>{
          var getAgeData = response.data['ageData'];  // 전달받은 월별 손님수를 대입합니다.

          // console.log('연령비 ');
          // console.log(getAgeData);

          // 전달받은 연령대 값을 대입합니다. (퍼센트가 아니라 연령대별 주문횟수)
          var ageValueArray = Object.values(getAgeData[0]);

          // 연령대별 이름
          var ageNameData   = ['0~9세', '10대', '20대', '30대', '40대', '50대', '60세 이상'];
          // 연령대별 그래프 색상
          var ageGraphColor = ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300'];

          // 데이터를 정렬해주는 함수 (계산할 숫자값(퍼센트로 가공), 카테고리명, 그래프색상)
          var getGraphData = this.getDataSort(ageValueArray, ageNameData, ageGraphColor);

          // Overwriting base render method with actual data.
          this.customerAgeData = {
            labels: getGraphData['name'],
            datasets: [
              {
                label: '매출 연령대',
                backgroundColor: getGraphData['color'],
                data: getGraphData['ratio']
              },
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 판매량 대비 방문 손님 국적을 갱신하는 함수 *************************
      getCustomerCountryData(){
        // axios http 라이브러리 
        axios.post('/owner/getCountryScore', {
          'shop_id'     : this.shop_id,         // 가게 id
          'start_date'  : this.startDate,       // 처음 날짜
          'end_date'    : this.endDatePlusOne   // 마지막 날짜
        }).
        then((response)=>{
          var getCountryData = response.data['countryData'];  // 전달받은 월별 손님수를 대입합니다.

          // console.log('국적값');
          // console.log(getCountryData); 

          // 전달받은 국적 값을 대입합니다. (퍼센트가 아니라 국적별 주문횟수)
          var countryValueArray = Object.values(JSON.parse(JSON.stringify(getCountryData[0])));

          // 국적명
          var countryNameData   = ['한국', '일본', '중국', '미국'];
          // 국적별 그래프 색상
          var countryGraphColor = ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300','#FF6666', '#66FFFF'];

          // 데이터를 정렬해주는 함수 (계산할 숫자값(퍼센트로 가공), 카테고리명, 그래프색상)
          var getGraphData = this.getDataSort(countryValueArray, countryNameData, countryGraphColor);

          // Overwriting base render method with actual data.
          this.customerCountryData = {
            labels: getGraphData['name'],
            datasets: [
              {
                label: '방문 손님 국적',
                backgroundColor: getGraphData['color'],
                data: getGraphData['ratio']
              }
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 판매량 대비 메뉴 데이터를 받아 그래프를 그리는 함수 *************************
       getMenuRankData(){
        console.log('국가');
        console.log(this.rankingCountrySelect['countryNum']);
        console.log('성별');
        console.log(this.rankingGenderSelect['genderNum']);
        console.log('연령');
        console.log(this.rankingAgeSelect['ageNum']);
        console.log('시작 날짜');
        console.log(this.startDate);
        console.log('마지막 날짜');
        console.log(this.endDatePlusOne);

        // axios http 라이브러리 
        axios.post('/owner/getMenuData', {
          'shop_id'         : this.shop_id,   // 가게 id
          'start_date'      : this.startDate,  // 처음 날짜
          'end_date'        : this.endDatePlusOne,    // 마지막 날짜
          'ranking_country' : this.rankingCountrySelect['countryNum'],   // 국적
          'ranking_age'     : this.rankingAgeSelect['ageNum'],       // 나이
          'ranking_gender'  : this.rankingGenderSelect['genderNum'],    // 성별
        }).
        then((response)=>{
          var getMenuData = response.data['menuData'];  // 전달받은 메뉴 데이터를 대입합니다.

          // console.log('메뉴 데이터');
          // console.log(getMenuData);

          var menuData = this.setMenuData(getMenuData, 1);

          console.log('정리된 메뉴 데이터');
          console.log(menuData);

          // 그래프 데이터
          this.menuRankData = {
            labels: menuData['menuNameList'],
            datasets: [
              {
                label: '그릇',
                backgroundColor: menuData['menuBarColorList'],
                hoverBackgroundColor:[
                  'rgba(255,051,051,0.8)',
                  'rgba(000,102,255,0.8)',
                  'rgba(051,204,153,0.8)',
                  'rgba(102,000,153,0.8)',
                  'rgba(255,051,000,0.8)'
                ],
                data: menuData['menuValueList'],
              },
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },
    },

    mounted () {
      // 상태에 따른 날짜 상단바의 크기를 조절하는 함수
      this.setTopDateBarSize();

      // 지정된 기간동안 판매량 대비 방문 손님수를 갱신하는 함수
      this.getCustomerScore();

      // 유저평점 데이터를 받아 그래프를 그리는 함수
      this.getCustomerRating();

      // 메뉴 주문 그래프 생성 함수
      this.getMenuRankData();

      // 판매량 대비 방문 손님 성비를 갱신하는 함수
      this.getCustomerGenderData();

      // 판매량 대비 방문 손님 연령을 갱신하는 함수
      this.getCustomerAgeData();

      // 판매량 대비 방문 손님 국적을 갱신하는 함수
      this.getCustomerCountryData();
    },

    created() {
      // 통계 기간을 이번달로 초기화합니다.
      this.setMonth();

      // 마지막 날짜의 + 1일 값을 구하는 함수를 실행합니다.
      this.endDatePlusOneDate();
      console.log('마지막 날 짜르기 : ' + this.endDatePlusOne);
    }
  }
</script>

<style>
    /* 기간 선택 구분 hr태그 CSS */
    .date-picker-line {
      border : dashed 0.1em rgba(105, 105, 105, 0.3);
    }

    .card-text-style {
      font-size: 1.5em;
    }
</style>