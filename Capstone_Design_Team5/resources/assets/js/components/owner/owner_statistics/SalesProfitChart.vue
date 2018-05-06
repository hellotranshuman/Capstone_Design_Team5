<!-- 
※ 전체 매출을 그리는 그래프

-->
<script>
import { Line } from 'vue-chartjs'

export default {
  extends: Line,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월', '12월'],
      datasets: [
        {
          label: '작년 매출',
          backgroundColor: 'transparent',
          data: [156000, 198860, 231250, 350000, 225000, 238080, 305920, 364000, 433350, 451260, 379600, 361200],
          lineTension           : 0,                      // 선의 곡선 관련 값, 0은 직선을 의미
          fill                  : false,                  // 두개의 데이터 경계 영역을 만드는데 사용되는 값
          borderColor           : '#0066FF',               // 선의 색상
          borderDash            : [5, 5],                 // dash의 길이와 간격
          pointBorderColor      : '#3366CC  ',               // 포인터의 색깔
          pointBackgroundColor  : 'rgba(000,102,255,0.5)',  // 포인터의 배경색깔
          pointRadius           : 7,                      // 포인터의 반지름 크기 값
          pointHoverRadius      : 20,                     // 가리킨 포인터의 반지름
          pointHitRadius        : 30,
          pointBorderWidth      : 2,
          pointStyle            : 'circle'
        },
        {
          label: '올해 매출',
          backgroundColor       : 'transparent',          // 배경 색상, transparent는 투명함을 의미
          data                  : [301200, 311300, 390400, 366300, 430660, 492700, 526800, 540000, 648000, 676000, 640000, 587500],
          lineTension           : 0,                      // 선의 곡선 관련 값, 0은 직선을 의미
          fill                  : false,                  // 두개의 데이터 경계 영역을 만드는데 사용되는 값
          borderColor           : 'orange',               // 선의 색상
          borderDash            : [5, 5],                 // dash의 길이와 간격
          pointBorderColor      : 'orange',               // 포인터의 색깔
          pointBackgroundColor  : 'rgba(255,150,0,0.5)',  // 포인터의 배경색깔
          pointRadius           : 7,                      // 포인터의 반지름 크기 값
          pointHoverRadius      : 20,                     // 가리킨 포인터의 반지름
          pointHitRadius        : 30,
          pointBorderWidth      : 2,
          pointStyle            : 'circle'



          
        }
      ]
    })
  }
}
</script>