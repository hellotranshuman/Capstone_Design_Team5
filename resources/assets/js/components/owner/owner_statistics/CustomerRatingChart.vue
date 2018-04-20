<!-- 
※ 방문 평점을 그리는 차트

-->
<script>
import { Radar } from 'vue-chartjs';

export default {
  extends: Radar,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['총점', '맛', '서비스', '분위기', '가격'],
      datasets: [
        {
          label: '평점',
          backgroundColor: ['rgba(54, 162, 235, 0.5)'],
          borderColor: ['#0099FF'],
          fill: true,
          // borderWidth: 1,
          data: [4.1, 4.5, 4, 3.8, 3.9],
          pointRadius           : 7,                      // 포인터의 반지름 크기 값
          pointHoverRadius      : 20,                     // 가리킨 포인터의 반지름
          pointBorderColor      : '#3366CC  ',               // 포인터의 색깔
          pointBackgroundColor  : 'rgba(000,102,255,0.7)',  // 포인터의 배경색깔
        },
      ]
    })
  }
}
</script>