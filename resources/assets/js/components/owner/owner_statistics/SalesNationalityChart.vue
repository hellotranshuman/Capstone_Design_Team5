<!-- 
※ 매출 국적을 그리는 차트

-->
<script>
// axios 라이브러리 import
import VueAxios from 'vue-axios';
import axios    from 'axios';
import { Pie } from 'vue-chartjs'

export default {
  props : {
    // 통계 시작 날짜
    startDay:{
      type: String,
      default: ""
    },
    // 통계 마지막 날짜
    endDay:{
      type: String,
      default: ""
    },
  },

  data(){
    return {
      shop_id               : this.$route.params.shop_id,   // 식당 아이디를 저장하는 변수
      getnationalityData    : [],                           // 전달받은 국적별 값 (퍼센트가 아니라 연령대별 매출금액)
      nationalityRatioData  : [],                           // 전달받은 국적별 매출금액을 비율로 계산한 값을 저장하는 배열
    }
  },

  extends: Pie,
  mounted () {
    // axios http 라이브러리 
    axios.post('/owner/getCountrySalesData', {
      'shop_id'     : this.shop_id,   // 가게 id
      'start_date'  : this.startDay,  // 처음 날짜
      'end_date'    : this.endDay     // 마지막 날짜
    }).
    then((response)=>{
      this.getnationalityData = response.data['countryData'];  // 전달받은 월별 손님수를 대입합니다.

      // console.log('매출별 국적값');
      // console.log(this.getnationalityData); 

      // 손님 연령대를 계산하는 함수를 호출합니다.
      this.getNationalityRatio();

      // Overwriting base render method with actual data.
      this.renderChart({
        labels: ['한국', '일본', '중국', '미국'],
        datasets: [
          {
            label: '방문 손님 국적',
            backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300','#FF6666', '#66FFFF'],
            data: this.nationalityRatioData
          }
        ]
      })
    }).catch(console.log('Oh my god!!, Failed'));
  },

  methods : {
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

    // 손님 연령대를 계산하는 함수
    // (퍼센트 구하는 공식 : 일부값 / 전체값 * 100)
    getNationalityRatio(){  
      // 전달받은 국적 값을 대입합니다. (퍼센트가 아니라 연령대별 매출금액)
      var nationalityArray      = JSON.parse(JSON.stringify(this.getnationalityData[0]));
      // 전달받은 국적 값의 value값 배열을 대입합니다.
      var nationalityValueArray = Object.values(nationalityArray);

      // 전체 국적별 매출금액의 총합이 저장되는 변수
      var totalNumber = 0;
      
      // console.log('전달받은 값');
      // console.log(nationalityArray);
      // console.log('전달받은 값의 values');
      // console.log(nationalityValueArray);
      // console.log('전달받은 값의 keys');
      // console.log(nationalityKeysArray);
      
      // 전체 국적별 매출금액 총합을 구합니다.
      for(var iCount = 0; iCount < nationalityValueArray.length; iCount++){
        totalNumber += Number(nationalityValueArray[iCount]);
      }

      // 전체 국적별 매출금액 비율을 구합니다.
      for (var iCount = 0; iCount < nationalityValueArray.length; iCount++){
        this.nationalityRatioData.push(this.round(nationalityValueArray[iCount] / totalNumber * 100, 2));
      }
    }



  }
}
</script>