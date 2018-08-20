<!-- ※ 방문 손님수를 그리는 차트 -->

<script>
// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';
import { Line } from 'vue-chartjs'

export default {
  props : {
    // 통계 시작 날짜
    startDay:{
      type    : String,
      default : ""
    },
    // 통계 마지막 날짜
    endDay:{
      type    : String,
      default : ""
    },
  },

  data(){
    return {
      monthList             : ['1月','2月','3月','4月','5月','6月','7月','8月','9月','10月','11月','12月'],  // 방문 손님수를 분류할 기준
      shop_id               : this.$route.params.shop_id,   // 식당 아이디를 저장하는 변수
      getCustomerScore      : [],                           // 월별 손님수값을 전달받는 배열
      sendMonthList         : [],                           // 전송할 값
      filterCustomerScore   : [],                           // 전달받은 월별 손님수를 가공한 값이 저장되는 배열
    }
  },

  extends: Line,
  mounted () {
    // axios로 전달할 값을 가공합니다.
    this.sendMonthListSet();

    // axios http 라이브러리 
    axios.post('/owner/getCustomerNumber', 
      this.sendMonthList
    ).
    then((response)=>{
      this.getCustomerScore = response.data['customerData'];  // 전달받은 월별 손님수를 대입합니다.

      // console.log('손님수 배열');
      // console.log(this.getCustomerScore);
      // console.log(response.data['test']);
      // console.log('haha');

      // 월별 사용자수를 가공합니다.
      this.customerDataFilter();

      // Overwriting base render method with actual data.
      this.renderChart({
        labels  : this.monthList,
        datasets: [
          {
            label: '今年の客入り',
            backgroundColor       : 'transparent',              // 배경 색상, transparent는 투명함을 의미
            data                  : this.filterCustomerScore,   // 월별 사용자수 값
            lineTension           : 0,                          // 선의 곡선 관련 값, 0은 직선을 의미
            fill                  : false,                      // 두개의 데이터 경계 영역을 만드는데 사용되는 값
            borderColor           : 'orange',                   // 선의 색상
            borderDash            : [5, 5],                     // dash의 길이와 간격
            pointBorderColor      : 'orange',                   // 포인터의 색깔
            pointBackgroundColor  : 'rgba(255,150,0,0.5)',      // 포인터의 배경색깔
            pointRadius           : 7,                          // 포인터의 반지름 크기 값
            pointHoverRadius      : 20,                         // 가리킨 포인터의 반지름
            pointHitRadius        : 30,
            pointBorderWidth      : 2,
            pointStyle            : 'circle'      
          }
        ]
      })
    }).catch(console.log('Oh my god!!, Failed'));
  },

  methods : {
    // axios로 전달할 값을 초기화 하는 함수
    sendMonthListSet(){
      var dateArr = this.endDay.split("-");     // 마지막 날짜 문자열을 -를 기준으로 구분합니다.

      this.sendMonthList = {
        'shop_id'     : this.shop_id,                             //  식당 id
        'start_day1'  : dateArr[0] + "-01" + "-01",               //  1월 시작일
        'end_date1'   : dateArr[0] + "-02" + "-01",               //  1월 종료일 (정확히는 2월1일 00시00분00초)
        'start_day2'  : dateArr[0] + "-02" + "-01",               //  2월 시작일
        'end_date2'   : dateArr[0] + "-03" + "-01",               //  2월 종료일
        'start_day3'  : dateArr[0] + "-03" + "-01",               //  3월 시작일
        'end_date3'   : dateArr[0] + "-04" + "-01",               //  3월 종료일
        'start_day4'  : dateArr[0] + "-04" + "-01",               //  4월 시작일
        'end_date4'   : dateArr[0] + "-05" + "-01",               //  4월 종료일
        'start_day5'  : dateArr[0] + "-05" + "-01",               //  5월 시작일
        'end_date5'   : dateArr[0] + "-06" + "-01",               //  5월 종료일
        'start_day6'  : dateArr[0] + "-06" + "-01",               //  6월 시작일
        'end_date6'   : dateArr[0] + "-07" + "-01",               //  6월 종료일
        'start_day7'  : dateArr[0] + "-07" + "-01",               //  7월 시작일
        'end_date7'   : dateArr[0] + "-08" + "-01",               //  7월 종료일
        'start_day8'  : dateArr[0] + "-08" + "-01",               //  8월 시작일
        'end_date8'   : dateArr[0] + "-09" + "-01",               //  8월 종료일
        'start_day9'  : dateArr[0] + "-09" + "-01",               //  9월 시작일
        'end_date9'   : dateArr[0] + "-10" + "-01",               //  9월 종료일
        'start_day10' : dateArr[0] + "-10" + "-01",               //  10월 시작일
        'end_date10'  : dateArr[0] + "-11" + "-01",               //  10월 종료일
        'start_day11' : dateArr[0] + "-11" + "-01",               //  11월 시작일
        'end_date11'  : dateArr[0] + "-12" + "-01",               //  11월 종료일
        'start_day12' : dateArr[0] + "-12" + "-01",               //  12월 시작일
        'end_date12'  : (Number(dateArr[0]) + 1) + "-01" + "-01"  //  12월 종료일
      };
    },

    // 전달받은 월별 사용자수 값을 가공합니다.
    // 현재달 이후의 전달받은 값을 모두 null로 대입합니다.
    customerDataFilter(){
      var dateArr = this.endDay.split("-");     // 마지막 날짜 문자열을 -를 기준으로 구분합니다. ex)2018-05-13 [2018][05][13]

      for(var iCount = 0; iCount < 12; iCount++){
        if(iCount < Number(dateArr[1])){

          // 반환된 달별 손님수가 null값일 경우 0을 대입합니다.
          if(this.getCustomerScore[iCount][0]['customer'] == null){
            this.getCustomerScore[iCount][0]['customer'] = 0;
          }

          this.filterCustomerScore.push(this.getCustomerScore[iCount][0]['customer']);
        } else {
          this.filterCustomerScore.push(null);
        }
      }
      // console.log('test hahaha');
      // console.log(this.filterCustomerScore);
    },
  },
}
</script>