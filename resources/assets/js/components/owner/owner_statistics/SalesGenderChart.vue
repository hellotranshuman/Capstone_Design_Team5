<!-- 
※ 매출에서 성비를 그리는 그래프

-->
<script>
import { Pie } from 'vue-chartjs'

export default {
  extends: Pie,
  mounted () {
    // Overwriting base render method with actual data.
    this.renderChart({
      labels: ['남성 손님', '여성 손님'],
      datasets: [
        {
          label: '손님 성비',
          backgroundColor: ['#3399FF','#FF6666'],
          data: [65,35]
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