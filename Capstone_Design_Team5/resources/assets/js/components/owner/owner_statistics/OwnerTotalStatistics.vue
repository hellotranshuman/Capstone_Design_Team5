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
                  <v-btn large color="error">
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
              <CustomerRatingChart :height="300"></CustomerRatingChart>
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
                    <v-flex xs2> 00</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs5>맛 : </v-flex>
                    <v-flex xs2> 00</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs5>서비스 : </v-flex>
                    <v-flex xs2> 00</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs5>분위기 : </v-flex>
                    <v-flex xs2> 00</v-flex>
                    <v-spacer></v-spacer>
                  </v-layout>
                  <br>
                  <v-layout>
                    <v-spacer></v-spacer>
                    <v-flex xs5>가격 : </v-flex>
                    <v-flex xs2> 00</v-flex>
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
          <CustomerNumberChart :height="200"></CustomerNumberChart>
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
              <CustomerGenderChart :height="350"></CustomerGenderChart>
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
              <CustomerAgeChart :height="350"></CustomerAgeChart>
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
              <CustomerNationalityChart :height="350"></CustomerNationalityChart>
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
                    return-object>
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
                  <h2>인기 메뉴 순위 (그릇)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <MenuRankingChart :height="200"></MenuRankingChart>
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
              <SalesProfitChart :height="200"></SalesProfitChart>
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
              <SalesGenderChart :height="350"></SalesGenderChart>
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
              <SalesAgeChart :height="350"></SalesAgeChart>
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
              <SalesNationalityChart :height="350"></SalesNationalityChart>
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
              <MenuSalesChart :height="200"></MenuSalesChart>
            </v-flex>
          </v-layout>
        </v-flex>
      </v-layout>
  </v-container>
</template>

<script>
// LineChart.js
// import { Line } from 'vue-chartjs';
import CustomerNumberChart      from './CustomerNumberChart.vue';
import CustomerGenderChart      from './CustomerGenderChart.vue';
import CustomerAgeChart         from './CustomerAgeChart.vue';
import CustomerNationalityChart from './CustomerNationalityChart.vue';
import CustomerRatingChart      from './CustomerRatingChart.vue';
import MenuRankingChart         from './MenuRankingChart.vue';
import MenuSalesChart           from './MenuSalesChart.vue';

// 전체 매출을 그리는 그래프
import SalesProfitChart         from './SalesProfitChart.vue';
// 매출에서 성비를 그리는 그래프
import SalesGenderChart         from './SalesGenderChart.vue';
// 매출 연령대를 그리는 차트
import SalesAgeChart            from './SalesAgeChart.vue';
// 매출 국적을 그리는 차트
import SalesNationalityChart    from './SalesNationalityChart.vue';

  export default {
    data(){
      return {
        shop_id   : this.$route.params.shop_id,  // 식당 아이디를 저장하는 변수
        startDate : null,
        startMenu : false,
        endDate   : null,
        endMenu   : false,

        rankingCountrySelect    : { country: '국가 선택', countryNum: 0 },  // 선택된 국가 필터링 기준
        rankingCountryItems     : [                                         // 국가 필터링 기준들
          { country: 'all',   countryNum: 0 },
          { country: 'china', countryNum: 1 },
          { country: 'japan', countryNum: 2 },
          { country: 'korea', countryNum: 3 },
        ],

        rankingGenderSelect    : { gender: '성별 선택', genderNum: 0 }, // 선택된 국가 필터링 기준
        rankingGenderItems     : [                                      // 국가 필터링 기준들
          { gender: 'all',    genderNum: 0 },
          { gender: 'male',   genderNum: 1 },
          { gender: 'female', genderNum: 2 },
        ],

        rankingAgeSelect    : [{ age: '연령 선택', ageNum: 0 }],  // 선택된 국가 필터링 기준
        rankingAgeItems     : [                                   // 국가 필터링 기준들
          { age: '0~9세', ageNum: 1 },
          { age: '10대',  ageNum: 2 },
          { age: '20대',  ageNum: 3 },
          { age: '30대',  ageNum: 4 },
          { age: '40대',  ageNum: 5 },
          { age: '50대',  ageNum: 6 },
          { age: '60세 이상', ageNum: 7 },
        ],

        // 매출 필터링
        salesCountrySelect    : { country: '국가 선택', countryNum: 0 },  // 선택된 국가 필터링 기준
        salesCountryItems     : [                                         // 국가 필터링 기준들
          { country: 'all',   countryNum: 0 },
          { country: 'china', countryNum: 1 },
          { country: 'japan', countryNum: 2 },
          { country: 'korea', countryNum: 3 },
        ],


        salesGenderSelect    : { gender: '성별 선택', genderNum: 0 }, // 선택된 국가 필터링 기준
        salesGenderItems     : [                                      // 국가 필터링 기준들
          { gender: 'all',    genderNum: 0 },
          { gender: 'male',   genderNum: 1 },
          { gender: 'female', genderNum: 2 },
        ],

        salesAgeSelect    : [{ age: '연령 선택', ageNum: 0 }],  // 선택된 국가 필터링 기준
        salesAgeItems     : [                                   // 국가 필터링 기준들
          { age: '0~9세', ageNum: 1 },
          { age: '10대',  ageNum: 2 },
          { age: '20대',  ageNum: 3 },
          { age: '30대',  ageNum: 4 },
          { age: '40대',  ageNum: 5 },
          { age: '50대',  ageNum: 6 },
          { age: '60세 이상', ageNum: 7 },
        ],

      }
    },

    methods : {
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
      }



    },

    components:{
      'CustomerNumberChart'     : CustomerNumberChart,
      'CustomerGenderChart'     : CustomerGenderChart,
      'CustomerAgeChart'        : CustomerAgeChart,
      'CustomerNationalityChart': CustomerNationalityChart,
      'CustomerRatingChart'     : CustomerRatingChart,
      'MenuRankingChart'        : MenuRankingChart,
      'SalesProfitChart'        : SalesProfitChart,
      'SalesGenderChart'        : SalesGenderChart,
      'SalesAgeChart'           : SalesAgeChart,
      'SalesNationalityChart'   : SalesNationalityChart,
      'MenuSalesChart'          : MenuSalesChart
    },

    created() {
      console.log('test');
      console.log(this.rankingCountrySelect.countryNum);

      // Add shop_id in statisticsData
      var statisticsData = new FormData();
      statisticsData.append('shop_id',    this.shop_id);        // 가게 아이디
      statisticsData.append('start_date', this.startDate);      // 시작 날짜
      statisticsData.append('end_date',   this.endDate);        // 마지막 날짜
      statisticsData.append('ranking_country',  this.rankingCountrySelect.countryNum); // 판매량 기준 인기 메뉴 순위 국가 필터링
      statisticsData.append('ranking_gender',   this.rankingGenderSelect.genderNum);   // 판매량 기준 인기 메뉴 순위 성별 필터링
      statisticsData.append('ranking_age',      this.rankingAgeSelect);                // 판매량 기준 인기 메뉴 순위 연령 필터링, 배열
      statisticsData.append('sales_country',  this.salesCountrySelect.countryNum); // 매출 기준 인기 메뉴 순위 국가 필터링
      statisticsData.append('sales_gender',   this.salesGenderSelect.genderNum);   // 매출 기준 인기 메뉴 순위 성별 필터링
      statisticsData.append('sales_age',      this.salesAgeSelect);                // 매출 기준 인기 메뉴 순위 연령 필터링, 배열

      console.log('-----send data-----');
      console.log(statisticsData.get('end_date'));

      // axios http 라이브러리 with Send statisticsData
      // axios.post('/???', statisticsData).
      // then((response)=>{
          
      // }).catch(console.log('Oh my god!!, Failed'));

    },

    beforeUpdate() {
      // console.log('시작 날짜');
      // console.log(this.startDate);
      // console.log('마지막 날짜');
      // console.log(this.endDate);
      // console.log('test');
      // console.log(this.rankingCountrySelect.countryNum);
    }
  }
</script>

<style>
    /* .statistics-line {
        padding-left: 5%;
        padding-right: 5%;
    } */

    /* 기간 선택 구분 hr태그 CSS */
    .date-picker-line {
      border : dashed 0.1em rgba(105, 105, 105, 0.3);
    }

    .card-text-style {
      font-size: 1.5em;
    }
</style>