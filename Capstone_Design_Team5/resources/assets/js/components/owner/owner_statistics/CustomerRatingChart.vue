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
          data: [4.1, 4.5, 4, 3.8, 3.9]
        },
        // {
        //   label: '올해 손님 성비',
        //   backgroundColor: ['#6699FF','#f87979'],
        //   data: [55,45]
        // }
      ]
    })
  }
}
</script>