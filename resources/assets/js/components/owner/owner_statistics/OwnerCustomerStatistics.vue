<!-- 
손님 통계 페이지

1. 통계 제공 종류 (전체, 국적, 연령, 성별), (당일, 일,주,월 단위)

  
손님,매출,메뉴에 대해서
전체, 국적, 연령, 성별 (당일,일,주,월)
단위로 통계를 만들어 제공합니다.


-->
<template>
  <v-container>
      <v-layout>
        <v-flex>
          <br> 
          <h3><B>손님 통계</B></h3>
          손님 통계를 볼 수 있습니다.
          <hr><br>
        </v-flex>
      </v-layout>
      <v-layout>
        <!-- 방문 손님수 그래프 -->
        <v-flex xs9>
          <v-layout justify-space-around>
            <v-flex xs3>
              <h2>방문 손님 수 (명)</h2>
            </v-flex>
          </v-layout>
          <v-layout>
            <v-flex>
              <CustomerNumberChart :height="200"></CustomerNumberChart>
            </v-flex>
          </v-layout>
        </v-flex>
        <!-- 기간 선택 -->
        <v-flex xs3>
          <v-card>
            <v-card-title>
              가간 선택
            </v-card-title>
            <v-card-text>
              <v-layout>
                <!-- 기간 선택, 시작 날짜 -->
                <v-flex xs8>
                  <v-menu ref="startMenu" lazy
                    :close-on-content-click="false"
                    v-model="startMenu"
                    transition="scale-transition"
                    offset-y
                    full-width
                    :nudge-right="40"
                    min-width="290px"
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
              </v-layout>
              <v-layout>
                <!-- 기간 선택, 마지막 날짜 -->
                <v-flex xs8>
                  <v-menu ref="endMenu" lazy
                    :close-on-content-click="false"
                    v-model="endMenu"
                    transition="scale-transition"
                    offset-y
                    full-width
                    :nudge-right="40"
                    min-width="290px"
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
              </v-layout>
              <v-layout justify-space-around>
                <v-flex xs8>
                  <v-btn large color="error">
                    조회
                  </v-btn>
                </v-flex>
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
      <v-layout>
        <v-flex xs4>
          <v-layout justify-space-around>
            <!-- 리뷰 평점 -->
            <v-flex xs5>
                  <h2>손님 평점 (점)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <CustomerRatingChart></CustomerRatingChart>
            </v-flex>
          </v-layout>
        </v-flex>
        <v-flex xs8>
          <v-layout justify-space-around>
            <!-- 리뷰 평점 -->
            <v-flex xs5>
                  <h2>3개월간 인기 메뉴 순위 (그릇)</h2>
            </v-flex>
          </v-layout>
          <v-layout justify-space-around>
            <v-flex>
              <MenuRankingChart :height="200"></MenuRankingChart>
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

  export default {
    data(){
      return {
        startDate: null,
        startMenu: false,

        endDate: null,
        endMenu: false,

        // chartData: [40, 39, 10, 40, 39, 80, 40],
        // chartOptions: 

      }
    },

    components:{
      'CustomerNumberChart'     : CustomerNumberChart,
      'CustomerGenderChart'     : CustomerGenderChart,
      'CustomerAgeChart'        : CustomerAgeChart,
      'CustomerNationalityChart': CustomerNationalityChart,
      'CustomerRatingChart'     : CustomerRatingChart,
      'MenuRankingChart'        : MenuRankingChart,
    }
  }
</script>

<style>

</style>
