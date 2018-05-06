<!-- 
※ 방문 손님 연령대를 그리는 차트

-->
<script>
import { Doughnut } from 'vue-chartjs'

export default {
  extends: Doughnut,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['0~9세', '10대', '20대', '30대', '40대', '50대', '60세 이상'],
      datasets: [
        {
          label: '작년 손님 성비',
          backgroundColor: ['#3399FF', '#FF3300', '#CCFF00', '#00CC33', '#CCCC00','#990066', '#663300'],
          data: [1, 21, 39, 20, 13, 5, 1]
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