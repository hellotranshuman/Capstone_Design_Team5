<!-- 
종합 통계 페이지

1. 통계 제공 종류
  1-1. 종합 통계 
    1-1-1. 손님수, 손님 성비, 손님 연령대, 손님 국적, 손님 평점, 인기 메뉴(전체,국적,연령,성별 필터링)
    1-1-2. 전체 매출, 매출 성비, 매출 연령대, 매출 국적, 매출 메뉴 순위(전체,국적,연령,성별 필터링)

  1-2. 손님 통계 
    (손님수, 손님 성비, 손님 연령대, 손님 국적, 손님 평점, 인기 메뉴(전체,국적,연령,성별 필터링))

  1-3. 매출 통계 
    (전체 매출, 매출 성비, 매출 연령대, 매출 국적, 매출 메뉴 순위(전체,국적,연령,성별 필터링))

  1-2. 통계 조회 기간
    1-2-1. 당일
    1-2-2. 일
    1-2-3. 주
    1-2-4. 월

-->
<template>
  <v-container>
      <v-layout>
        <v-flex>
          <br> 
          <h3><B>종합 통계</B></h3>
          종합적인 통계를 볼 수 있습니다.
          <hr><br>
        </v-flex>
      </v-layout>
      <!-- 기간 선택 -->
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
            <v-flex xs7>
              <CustomerRatingChart :height="300" :chart-data="ratingData"></CustomerRatingChart>
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
        <v-flex xs2>
          <h2>방문 손님 수 (명)</h2>
        </v-flex>
      </v-layout>
      <v-layout>
        <v-flex xs9>
          <CustomerNumberChart :height="200" :startDay="startDate" :endDay="endDatePlusOne"></CustomerNumberChart>
        </v-flex>


        <v-flex xs3 class="card-text-style">
              <br><br>
              <v-card>
                <v-card-title>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7><b>방문 손님 수</b></v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                </v-card-title>
                <v-card-text>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7>전체 손님수 : </v-flex>
                    <v-flex xs4> 000명</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7>최고 방문객수 : </v-flex>
                    <v-flex xs3> 00월</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7>최저 방문객수  : </v-flex>
                    <v-flex xs3> 00월</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                </v-card-text>
              </v-card>
            </v-flex>




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
              <CustomerGenderChart :height="350" :chart-data="customerGenderData"></CustomerGenderChart>
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
              <CustomerAgeChart :height="350" :chart-data="customerAgeData"></CustomerAgeChart>
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
              <CustomerCountryChart :height="350" :chart-data="customerCountryData"></CustomerCountryChart>
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
            <v-flex>
              <MenuRankingChart :height="200" :chart-data="menuRankData"></MenuRankingChart>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>

      <!-- 구분 -->
      <br><br><hr><br><br>



      <!-- 여기서 부터는 매출 차트 -->


      <v-layout>
        <v-flex>
          <v-layout justify-space-around>
            <!-- 전체 매출 -->
            <v-flex xs2>
                  <h2>매출액 (￥)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <SalesProfitChart :height="200" :startDay="startDate" :endDay="endDatePlusOne"></SalesProfitChart>
            </v-flex>
            <v-flex xs3 class="card-text-style">
              <br><br>
              <v-card>
                <v-card-title>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7><b>매출액</b></v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                </v-card-title>
                <v-card-text>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7>전체 매출액 : </v-flex>
                    <v-flex xs4> 000000￥</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7>최고 매출액 : </v-flex>
                    <v-flex xs3> 00월</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs7>최저 매출액  : </v-flex>
                    <v-flex xs3> 00월</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                </v-card-text>
              </v-card>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>


      <!-- 구분 -->
      <br><br><hr><br><br>
      <v-layout justify-space-around>
        <!-- 매출 성비를 그래프 -->
        <v-flex xs4>
          <v-layout justify-space-around>
            <v-flex xs4>
              <h2>매출 성비 (%)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <SalesGenderChart :height="350" :chart-data="salesGenderData"></SalesGenderChart>
            </v-flex>
          </v-layout>
        </v-flex>
        <!-- 매출 연령대별 그래프 -->
        <v-flex xs4>
          <v-layout justify-space-around>
            <v-flex xs5>
              <h2>매출 연령대 (%)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <SalesAgeChart :height="350" :chart-data="salesAgeData"></SalesAgeChart>
            </v-flex>
          </v-layout>
        </v-flex>
        <!-- 매출 국적별 그래프 -->
        <v-flex xs4>
          <v-layout justify-space-around>
            <v-flex xs7>
              <h2>매출 국적 (%)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <SalesNationalityChart :height="350" :startDay="startDate" :endDay="endDatePlusOne"></SalesNationalityChart>
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
              메뉴 필터링
            </v-card-title>
            <v-card-text>
              <!-- 전체,국적,성별,연령 필터링 -->
              <v-layout>
                <v-spacer></v-spacer>
                <v-flex xs2>
                  <v-select 
                    :items      ="salesCountryItems" 
                    v-model     ="salesCountrySelect" 
                    label       ="국가 선택"  
                    item-text   ="country"
                    single-line
                    return-object>
                  </v-select>
                </v-flex>
                <v-flex xs2>
                  <v-select 
                    :items      ="salesGenderItems" 
                    v-model     ="salesGenderSelect" 
                    label       ="성별 선택"  
                    item-text   ="gender"
                    single-line
                    return-object>
                  </v-select>
                </v-flex>
                <v-flex xs5>
                  <v-select 
                    :items      ="salesAgeItems" 
                    v-model     ="salesAgeSelect" 
                    label       ="연령 선택"  
                    item-text   ="age"
                    multiple
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
                  <h2>매출 메뉴 순위 (￥)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <MenuSalesChart :height="200" :chart-data="menuSalesData"></MenuSalesChart>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
  </v-container>
</template>

<script>
// LineChart.js
// import { Line } from 'vue-chartjs';
// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';

import CustomerNumberChart      from './CustomerNumberChart.vue';       // 월별 손님수 그래프
import CustomerGenderChart      from './CustomerGenderChart.vue';       //
import CustomerAgeChart         from './CustomerAgeChart.vue';          //
import CustomerCountryChart     from './CustomerCountryChart.vue';      // 손님 국적 그래프
import CustomerRatingChart      from './CustomerRatingChart.vue';       // 손님 평점 그래프
import MenuRankingChart         from './MenuRankingChart.vue';          //
import MenuSalesChart           from './MenuSalesChart.vue';            //

// 전체 매출을 그리는 그래프
import SalesProfitChart         from './SalesProfitChart.vue';
// 매출에서 성비를 그리는 그래프
import SalesGenderChart         from './SalesGenderChart.vue';
// 매출 연령대를 그리는 차트
import SalesAgeChart            from './SalesAgeChart.vue';
// 매출 국적을 그리는 차트
import SalesNationalityChart    from './SalesNationalityChart.vue';

  export default {
    components:{
      'CustomerNumberChart'     : CustomerNumberChart,
      'CustomerGenderChart'     : CustomerGenderChart,
      'CustomerAgeChart'        : CustomerAgeChart,
      'CustomerCountryChart'    : CustomerCountryChart,
      'CustomerRatingChart'     : CustomerRatingChart,
      'MenuRankingChart'        : MenuRankingChart,
      'SalesProfitChart'        : SalesProfitChart,
      'SalesGenderChart'        : SalesGenderChart,
      'SalesAgeChart'           : SalesAgeChart,
      'SalesNationalityChart'   : SalesNationalityChart,
      'MenuSalesChart'          : MenuSalesChart
    },

    data(){
      return {
        shop_id         : this.$route.params.shop_id,  // 식당 아이디를 저장하는 변수
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

        rankingAgeSelect    : { age: '연령 선택', ageNum: 0 },  // 선택된 국가 필터링 기준
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

        // 매출 필터링
        salesCountrySelect    : { country: '국가 선택', countryNum: 0 },  // 선택된 국가 필터링 기준
        salesCountryItems     : [                                         // 국가 필터링 기준들
          { country: 'all',   countryNum: 0 },
          { country: 'china', countryNum: 1 },
          { country: 'japan', countryNum: 2 },
          { country: 'korea', countryNum: 3 },
          { country: 'usa',   countryNum: 4 },
        ],


        salesGenderSelect    : { gender: '성별 선택', genderNum: 0 }, // 선택된 국가 필터링 기준
        salesGenderItems     : [                                      // 국가 필터링 기준들
          { gender: 'all',    genderNum: 0 },
          { gender: 'male',   genderNum: 1 },
          { gender: 'female', genderNum: 2 },
        ],

        salesAgeSelect    : [{ age: '연령 선택', ageNum: 0 }],  // 선택된 국가 필터링 기준
        salesAgeItems     : [                                   // 국가 필터링 기준들
          { age: 'all',       ageNum: 0 },
          { age: '0~9세',     ageNum: 1 },
          { age: '10대',      ageNum: 2 },
          { age: '20대',      ageNum: 3 },
          { age: '30대',      ageNum: 4 },
          { age: '40대',      ageNum: 5 },
          { age: '50대',      ageNum: 6 },
          { age: '60세 이상', ageNum: 7 },
        ],

        menuRankData    : null,     // 그래프를 그리기 위한 메뉴 판매수 데이터가 저장될 변수
        menuSalesData   : null,     // 그래프를 그리기 위한 메뉴 판매금액 데이터가 저장될 변수  
        ratingData   : [],       // 가게평점 5종류의 값을 전달 받을 변수
        customerGenderData : [], // 그래프를 그리기 위한 판매량 대비 방문 손님 성비 데이터가 저장될 변수
        customerAgeData : [], // 그래프를 그리기 위한 판매량 대비 방문 손님 연령대 데이터가 저장될 변수
        customerCountryData : [], // 그래프를 그리기 위한 판매량 대비 방문 손님 국적 데이터가 저장될 변수
        salesGenderData : [], // 그래프를 그리기 위한 매출 대비 방문 손님 성비 데이터가 저장될 변수
        salesAgeData : [],        // 그래프를 그리기 위한 매출 대비 방문 손님 연령대 데이터가 저장될 변수


        getRatingScore  : [         // 그래프를 그리기 위한 평점 배열을 저장할 배열, 값을 초기화 해둡니다.
          {'totalRating'  : 0},
          {'taste'        : 0},
          {'service'      : 0},
          {'mood'         : 0},
          {'price'        : 0}
        ],
      }
    },

    watch: {
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

      // 판매금액 대비 메뉴 필터링에서 선택된 국가
      salesCountrySelect : function(){
        this.getMenuSalesData();
      },
      // 판매금액 대비 메뉴 필터링에서 선택된 성별
      salesGenderSelect : function(){
        this.getMenuSalesData();
      },
      // 판매금액 대비 메뉴 필터링에서 선택된 연령
      salesAgeSelect : function(){
        this.getMenuSalesData();
      },
    },

    methods : {
      //************************* 그래프 조회 날짜를 갱신하는 함수 *************************
      dateSearch(){
        console.log('---------- startDate ----------');
        console.log(this.startDate);
        console.log('---------- endDate ----------');
        console.log(this.endDate);
        console.log('---------- endDatePlusOne ----------');
        console.log(this.endDatePlusOne);

        // 마지막 날짜의 + 1일 값을 구하는 함수
        this.endDatePlusOneDate();

        // 유저평점 데이터를 받아 그래프를 그리는 함수를 실행합니다.
        this.getCustomerRating();

        // 메뉴 주문 그래프 생성 함수를 실행합니다.
        this.getMenuRankData();

        // 메뉴 매출대비 주문 그래프 생성 함수를 실행합니다.
        this.getMenuSalesData();

        // 판매량 대비 방문 손님 성비를 갱신하는 함수를 실행합니다.
        this.getCustomerGenderData();

        // 판매량 대비 방문 손님 연령을 갱신하는 함수
        this.getCustomerAgeData();

        // 판매량 대비 방문 손님 국적을 갱신하는 함수
        this.getCustomerCountryData();

        // 매출 대비 방문 손님 성비를 갱신하는 함수
        this.getSalesGenderData();

        // 매출 대비 방문 손님 연령을 갱신하는 함수
        this.getSalesAgeData();
      },

      // 반올림 함수 (반올림 대상값, 반올림 자릿수)
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


      // 마지막 날짜의 + 1일 값을 구하는 함수
      endDatePlusOneDate(){
        var dateArr = this.endDate.split("-");      // 마지막 날짜 문자열을 -를 기준으로 구분합니다.
        var date    = Number(dateArr[2]) + 1;       // 마지막 날짜값에서 1 값을 더합니다.

        this.endDatePlusOne = dateArr[0] + '-' + dateArr[1] + '-' + date; // 마지막 날짜 +1일 에해당하는 날짜를 대입합니다.
      },

      // 통계 기간 선택을 자동으로 오늘로 지정해주는 함수
      setToday(){
        var today = new Date().toISOString().substr(0, 10).replace('T', ' ');

        this.startDate  = today;
        this.endDate    = today;
      },

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

      setYear(){
        // 올해
        var year  = new Date().getFullYear();

        // 이번년도 1월 1일을 변수 startDate에 저장합니다.
        this.startDate = year + "-01-01";

        // 오늘 날짜
        var today = new Date().toISOString().substr(0, 10).replace('T', ' ');
        this.endDate = today;
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
          // console.log('????? 맞나???????');
          // console.log(this.startDate);

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

          // console.log('성비');
          // console.log(getGenderData);

          var maleNumber   = Number(getGenderData[0]['male']);
          var femaleNumber = Number(getGenderData[0]['female']);

          // 손님 성비를 계산합니다.
          // (퍼센트 구하는 공식 : 일부값 / 전체값 * 100)
          var maleRatio   = this.round(maleNumber / (maleNumber + femaleNumber) * 100, 2);
          var femaleRatio = this.round(femaleNumber / (maleNumber + femaleNumber) * 100, 2);

          var genderRatioData = [];
          genderRatioData.push(maleRatio);
          genderRatioData.push(femaleRatio);

          // console.log('성비값 변경');
          // console.log(genderRatioData);

          // Overwriting base render method with actual data.
          this.customerGenderData = {
            labels: ['남성 손님', '여성 손님'],
            datasets: [
              {
                label: '손님 성비',
                backgroundColor: ['#3399FF','#FF6666'],
                data: genderRatioData
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
          var ageArray      = getAgeData[0];
          // 전달받은 연령대 값의 value값 배열을 대입합니다.
          var ageValueArray = Object.values(ageArray);

          // 전체 연령의 주문횟수의 총합이 저장되는 변수
          var totalNumber = 0;

          // 전체 연령별 주문횟수 총합을 구합니다.
          for(var iCount = 0; iCount < ageValueArray.length; iCount++){
            totalNumber += Number(ageValueArray[iCount]);
          }

          // 전달받은 연령대별 주문횟수를 비율로 계산한 값을 저장하는 배열
          var ageRatioData = [];

          // 전체 연령별 방문 손님 비율을 구합니다.
          for (var iCount = 0; iCount < ageValueArray.length; iCount++){
            ageRatioData.push(this.round(ageValueArray[iCount] / totalNumber * 100, 2));
          }   

          // console.log('연령대별 ~~ 개꿀 ~~');
          // console.log(ageRatioData);

          // Overwriting base render method with actual data.
          this.customerAgeData = {
            labels: ['0~9세', '10대', '20대', '30대', '40대', '50대', '60세 이상'],
            datasets: [
              {
                label: '매출 연령대',
                backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300'],
                data: ageRatioData
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
          var getnationalityData = response.data['countryData'];  // 전달받은 월별 손님수를 대입합니다.

          // console.log('국적값');
          // console.log(getnationalityData); 

          // 전달받은 국적 값을 대입합니다. (퍼센트가 아니라 연령대별 주문횟수)
          var nationalityArray      = JSON.parse(JSON.stringify(getnationalityData[0]));
          // 전달받은 국적 값의 value값 배열을 대입합니다.
          var nationalityValueArray = Object.values(nationalityArray);

          // 전체 국적별 주문횟수의 총합이 저장되는 변수
          var totalNumber = 0;
          
          // console.log('전달받은 값');
          // console.log(nationalityArray);
          // console.log('전달받은 값의 values');
          // console.log(nationalityValueArray);
          // console.log('전달받은 값의 keys');
          // console.log(nationalityKeysArray);
          
          // 전체 국적별 주문횟수 총합을 구합니다.
          for(var iCount = 0; iCount < nationalityValueArray.length; iCount++){
            totalNumber += Number(nationalityValueArray[iCount]);
          }

          // 전달받은 국적별 주문횟수를 비율로 계산한 값을 저장하는 배열
          var nationalityRatioData = [];

          // 전체 국적별 방문 손님 비율을 구합니다.
          for (var iCount = 0; iCount < nationalityValueArray.length; iCount++){
            nationalityRatioData.push(this.round(nationalityValueArray[iCount] / totalNumber * 100, 2));
          }

          // Overwriting base render method with actual data.
          this.customerCountryData = {
            labels: ['한국', '일본', '중국', '미국'],
            datasets: [
              {
                label: '방문 손님 국적',
                backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300','#FF6666', '#66FFFF'],
                data: nationalityRatioData
              }
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));

      },

      //************************* 매출 대비 방문 손님 성비를 갱신하는 함수 *************************
      getSalesGenderData(){
        // axios http 라이브러리 
        axios.post('/owner/getGenderSalesData', {
          'shop_id'    : this.shop_id,         // 가게 id
          'start_date' : this.startDate,       // 처음 날짜
          'end_date'   : this.endDatePlusOne   // 마지막 날짜
        }).
        then((response)=>{
          var getSalesGenderData = response.data['genderData'];  // 전달받은 월별 손님수를 대입합니다.

          // console.log('매출 성비');
          // console.log(getSalesGenderData);

          var maleNumber   = Number(getSalesGenderData[0]['maleSales']);
          var femaleNumber = Number(getSalesGenderData[0]['femaleSales']);

          // 손님 성비를 계산 (퍼센트 구하는 공식 : 일부값 / 전체값 * 100)
          var maleRatio   = this.round(maleNumber / (maleNumber + femaleNumber) * 100, 2);
          var femaleRatio = this.round(femaleNumber / (maleNumber + femaleNumber) * 100, 2);

          // 전달받은 성별 주문횟수를 성비로 계산한 값을 저장하는 배열
          var genderSalesRatioData = [];

          genderSalesRatioData.push(maleRatio);
          genderSalesRatioData.push(femaleRatio);

          console.log('성비값 변경');
          console.log(genderSalesRatioData);

          // Overwriting base render method with actual data.
          this.salesGenderData = {
            labels: ['남성 손님', '여성 손님'],
            datasets: [
              {
                label: '손님 성비',
                backgroundColor: ['#3399FF','#FF6666'],
                data: genderSalesRatioData
              }
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 매출 대비 방문 손님 연령을 갱신하는 함수 *************************
      getSalesAgeData(){
        // axios http 라이브러리 
        axios.post('/owner/getAgesSalesData', {
          'shop_id'     : this.shop_id,         // 가게 id
          'start_date'  : this.startDate,       // 처음 날짜
          'end_date'    : this.endDatePlusOne   // 마지막 날짜
        }).
        then((response)=>{
          var getSalesAgeData = response.data['ageData'];  // 전달받은 월별 손님수를 대입합니다.

          // console.log('매출별 연령비');
          // console.log(getSalesAgeData);

          // 전달받은 연령대 값을 대입합니다. (퍼센트가 아니라 연령대별 매출금액)
          var ageArray      = getSalesAgeData[0];
          // 전달받은 연령대 값의 value값 배열을 대입합니다.
          var ageValueArray = Object.values(ageArray);

          // console.log('매출별 연령대 ~~ 개꿀 ~~');
          // console.log(ageArray);

          // 전체 연령의 매출금액의 총합이 저장되는 변수
          var totalNumber = 0;

          // 전체 연령별 주문금액 총합을 구합니다.
          for(var iCount = 0; iCount < ageValueArray.length; iCount++){
            totalNumber += Number(ageValueArray[iCount]);
          }

          var ageSalesRatioData = [];

          // 전체 연령별 매출대비 방문 손님 비율을 구합니다. (퍼센트 구하는 공식 : 일부값 / 전체값 * 100)
          for (var iCount = 0; iCount < ageValueArray.length; iCount++){
            ageSalesRatioData.push(this.round(ageValueArray[iCount] / totalNumber * 100, 2));
          }    

          // Overwriting base render method with actual data.
          this.salesAgeData = {
            labels: ['0~9세', '10대', '20대', '30대', '40대', '50대', '60세 이상'],
            datasets: [
              {
                label: '매출 연령대',
                backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300'],
                data: ageSalesRatioData
              }
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 매출 대비 방문 손님 국적을 갱신하는 함수 *************************
      getSalesCountryData(){

      },

      //************************* 판매량 대비 메뉴 데이터를 받아 그래프를 그리는 함수 *************************
       getMenuRankData(){
        // console.log('국가');
        // console.log(this.rankingCountrySelect['countryNum']);
        // console.log('성별');
        // console.log(this.rankingGenderSelect['genderNum']);
        // console.log('연령');
        // console.log(this.rankingAgeSelect['ageNum']);

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
            console.log(response.data.test);
            console.log(response.data.gender);
            console.log(response.data.country);
            console.log(response.data.age);

          // console.log('메뉴 데이터');
          // console.log(getMenuData);

          var menuNameList   = [];  // 메뉴 이름 목록이 저장되는 배열
          var menuValueList  = [];  // 메뉴 값 목록이 저장되는 배열

          // 메뉴이름 및 메뉴별 주문 개수 값을 각각 배열에 저장합니다.
          for(var iCount = 0; iCount < getMenuData.length; iCount++){
            menuNameList.push(getMenuData[iCount]['menuName']);
            menuValueList.push(getMenuData[iCount]['menuCount']);
          }

          // console.log(menuNameList);
          // console.log(menuValueList);

          // 그래프 색상 설정
          this.firstBar   = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.secondBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.thirdBar   = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.fourthBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.fifthBar   = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);

          this.firstBar.addColorStop(0, 'rgba(255, 0,0, 0.9)');
          this.firstBar.addColorStop(0.5, 'rgba(255, 0, 0, 0.7)');
          this.firstBar.addColorStop(1, 'rgba(255, 0, 0, 0.5)');
            
          this.secondBar.addColorStop(0, 'rgba(000, 051, 255, 0.9)')
          this.secondBar.addColorStop(0.5, 'rgba(000, 051, 255, 0.7)');
          this.secondBar.addColorStop(1, 'rgba(000, 051, 255, 0.5)');

          this.thirdBar.addColorStop(0, 'rgba(000, 153, 102, 0.9)')
          this.thirdBar.addColorStop(0.5, 'rgba(000, 153, 102, 0.7)');
          this.thirdBar.addColorStop(1, 'rgba(000, 153, 102, 0.5)');

          this.fourthBar.addColorStop(0, 'rgba(102, 000, 204, 0.9)')
          this.fourthBar.addColorStop(0.5, 'rgba(102, 000, 204, 0.7)');
          this.fourthBar.addColorStop(1, 'rgba(102, 000, 204, 0.5)');

          this.fifthBar.addColorStop(0, 'rgba(255, 102, 000, 0.9)')
          this.fifthBar.addColorStop(0.5, 'rgba(255, 102, 000, 0.7)');
          this.fifthBar.addColorStop(1, 'rgba(255, 102, 000, 0.5)');

          // 그래프 데이터
          this.menuRankData = {
            labels: menuNameList,
            datasets: [
              {
                label: '그릇',
                backgroundColor: [this.firstBar, this.secondBar, this.thirdBar, this.fourthBar, this.fifthBar],
                hoverBackgroundColor:[
                  'rgba(255,051,051,0.8)',
                  'rgba(000,102,255,0.8)',
                  'rgba(051,204,153,0.8)',
                  'rgba(102,000,153,0.8)',
                  'rgba(255,051,000,0.8)'
                ],
                data: menuValueList,
              },
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

      //************************* 매출 대비 메뉴 데이터를 받아 그래프를 그리는 함수 *************************
      getMenuSalesData(){
        // console.log('국가');
        // console.log(this.rankingCountrySelect['countryNum']);
        // console.log('성별');
        // console.log(this.rankingGenderSelect['genderNum']);
        // console.log('연령');
        // console.log(this.rankingAgeSelect['ageNum']);

        // axios http 라이브러리 
        axios.post('/owner/getSalesMenuData', {
          'shop_id'         : this.shop_id,   // 가게 id
          'start_date'      : this.startDate,  // 처음 날짜
          'end_date'        : this.endDatePlusOne,    // 마지막 날짜
          'ranking_country' : this.salesCountrySelect['countryNum'],   // 국적
          'ranking_age'     : this.salesAgeSelect['ageNum'],       // 나이
          'ranking_gender'  : this.salesGenderSelect['genderNum'],    // 성별
        }).
        then((response)=>{
          var getMenuData = response.data['menuData'];  // 전달받은 메뉴 데이터를 대입합니다.

          // console.log('메뉴 데이터');
          // console.log(getMenuData);

          var menuNameList   = [];  // 메뉴 이름 목록이 저장되는 배열
          var menuValueList  = [];  // 메뉴 값 목록이 저장되는 배열

          // 메뉴이름 및 메뉴별 주문 개수 값을 각각 배열에 저장합니다.
          for(var iCount = 0; iCount < getMenuData.length; iCount++){
            menuNameList.push(getMenuData[iCount]['menuName']);
            menuValueList.push(getMenuData[iCount]['menuTotal']);
          }

          // console.log(menuNameList);
          // console.log(menuValueList);

          // 그래프 색상 설정
          this.firstBar   = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.secondBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.thirdBar   = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.fourthBar  = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);
          this.fifthBar   = document.createElement('canvas').getContext('2d').createLinearGradient(0, 0, 0, 450);

          this.firstBar.addColorStop(0, 'rgba(255, 0,0, 0.9)');
          this.firstBar.addColorStop(0.5, 'rgba(255, 0, 0, 0.7)');
          this.firstBar.addColorStop(1, 'rgba(255, 0, 0, 0.5)');
            
          this.secondBar.addColorStop(0, 'rgba(000, 051, 255, 0.9)')
          this.secondBar.addColorStop(0.5, 'rgba(000, 051, 255, 0.7)');
          this.secondBar.addColorStop(1, 'rgba(000, 051, 255, 0.5)');

          this.thirdBar.addColorStop(0, 'rgba(000, 153, 102, 0.9)')
          this.thirdBar.addColorStop(0.5, 'rgba(000, 153, 102, 0.7)');
          this.thirdBar.addColorStop(1, 'rgba(000, 153, 102, 0.5)');

          this.fourthBar.addColorStop(0, 'rgba(102, 000, 204, 0.9)')
          this.fourthBar.addColorStop(0.5, 'rgba(102, 000, 204, 0.7)');
          this.fourthBar.addColorStop(1, 'rgba(102, 000, 204, 0.5)');

          this.fifthBar.addColorStop(0, 'rgba(255, 102, 000, 0.9)')
          this.fifthBar.addColorStop(0.5, 'rgba(255, 102, 000, 0.7)');
          this.fifthBar.addColorStop(1, 'rgba(255, 102, 000, 0.5)');

          // 그래프 데이터
          this.menuSalesData = {
            labels: menuNameList,
            datasets: [
              {
                label: '그릇',
                backgroundColor: [this.firstBar, this.secondBar, this.thirdBar, this.fourthBar, this.fifthBar],
                hoverBackgroundColor:[
                  'rgba(255,051,051,0.8)',
                  'rgba(000,102,255,0.8)',
                  'rgba(051,204,153,0.8)',
                  'rgba(102,000,153,0.8)',
                  'rgba(255,051,000,0.8)'
                ],
                data: menuValueList,
              },
            ]
          }
        }).catch(console.log('Oh my god!!, Failed'));
      },

    },

    mounted () {
      // 유저평점 데이터를 받아 그래프를 그리는 함수
      this.getCustomerRating();

      // 메뉴 주문 그래프 생성 함수
      this.getMenuRankData();

      // 메뉴 매출대비 주문 그래프 생성 함수
      this.getMenuSalesData();

      // 판매량 대비 방문 손님 성비를 갱신하는 함수
      this.getCustomerGenderData();

      // 판매량 대비 방문 손님 연령을 갱신하는 함수
      this.getCustomerAgeData();

      // 판매량 대비 방문 손님 국적을 갱신하는 함수
      this.getCustomerCountryData();

      // 매출 대비 방문 손님 성비를 갱신하는 함수
      this.getSalesGenderData();

      // 매출 대비 방문 손님 연령을 갱신하는 함수
      this.getSalesAgeData();
    },

    created() {
      this.setMonth();  // 통계 기간을 이번달로 초기화합니다.

      // Add shop_id in statisticsData
      var statisticsData = new FormData();
      statisticsData.append('shop_id',    this.shop_id);        // 가게 아이디
      statisticsData.append('start_date', this.startDate);      // 시작 날짜
      statisticsData.append('end_date',   this.endDate);        // 마지막 날짜
      statisticsData.append('ranking_country',  this.rankingCountrySelect.countryNum);  // 판매량 기준 인기 메뉴 순위 국가 필터링
      statisticsData.append('ranking_gender',   this.rankingGenderSelect.genderNum);    // 판매량 기준 인기 메뉴 순위 성별 필터링
      statisticsData.append('ranking_age',      this.rankingAgeSelect);                 // 판매량 기준 인기 메뉴 순위 연령 필터링, 배열
      statisticsData.append('sales_country',  this.salesCountrySelect.countryNum);      // 매출 기준 인기 메뉴 순위 국가 필터링
      statisticsData.append('sales_gender',   this.salesGenderSelect.genderNum);        // 매출 기준 인기 메뉴 순위 성별 필터링
      statisticsData.append('sales_age',      this.salesAgeSelect);                     // 매출 기준 인기 메뉴 순위 연령 필터링, 배열

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