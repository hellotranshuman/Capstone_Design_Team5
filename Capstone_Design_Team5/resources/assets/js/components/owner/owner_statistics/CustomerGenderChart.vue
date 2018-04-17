<!-- 
※ 방문 손님 성별을 그리는 차트

-->
<script>
import { Doughnut } from 'vue-chartjs'

export default {
  extends: Doughnut,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['남성 손님', '여성 손님'],
      datasets: [
        {
          label: '손님 성비',
          backgroundColor: ['#3399FF','#FF6666'],
          data: [59,41]
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